/**
 * JavaScript for the app builder onboarding funnel (Version 4.0.1)
 * Handles user interactions for theme, layout, module configuration, and publishing steps.
 * Includes navigation logic and placeholder AJAX calls for draft saving.
 */

jQuery(document).ready(function($) {
    // Persistent storage for user selections across steps (e.g., sessionStorage or localStorage)
    var selectedTheme = sessionStorage.getItem('as_appskit_pro_selected_theme') || '';
    var selectedLayout = sessionStorage.getItem('as_appskit_pro_selected_layout') || '';
    var currentAppDraftId = sessionStorage.getItem('as_appskit_pro_current_app_draft_id') || ''; // ID of the AppKit CPT post

    // --- Step 1: Theme Selection (existing logic) ---
    var $nextStep1Button = $('#next-step-1');
    $('.app-templates-grid .template-card').on('click', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            selectedTheme = '';
        } else {
            $('.app-templates-grid .template-card').removeClass('selected');
            $(this).addClass('selected');
            selectedTheme = $(this).data('template-id');
        }
        sessionStorage.setItem('as_appskit_pro_selected_theme', selectedTheme);
        $nextStep1Button.prop('disabled', !selectedTheme);
    });

    if (selectedTheme) {
        $('.app-templates-grid .template-card[data-template-id="' + selectedTheme + '"]').addClass('selected');
        $nextStep1Button.prop('disabled', false);
    } else {
        $nextStep1Button.prop('disabled', true);
    }

    $nextStep1Button.on('click', function() {
        if (selectedTheme) {
            // TODO: AJAX call to save app draft (theme selection) to the AppKit CPT
            // This should return the app_id which should be stored in currentAppDraftId
            // For now, we'll simulate with a direct redirect.
            console.log('Selected Theme:', selectedTheme);
            window.location.href = '<?php echo esc_url( home_url( '/new-appkit-step-2' ) ); ?>';
        } else {
            alert('Please select a theme first to proceed.');
        }
    });

    // --- Step 2: Layout Selection ---
    var $prevStep2Button = $('#prev-step-2');
    var $nextStep2Button = $('#next-step-2');
    $('.app-layouts-grid .layout-card').on('click', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            selectedLayout = '';
        } else {
            $('.app-layouts-grid .layout-card').removeClass('selected');
            $(this).addClass('selected');
            selectedLayout = $(this).data('layout-id');
        }
        sessionStorage.setItem('as_appskit_pro_selected_layout', selectedLayout);
        $nextStep2Button.prop('disabled', !selectedLayout);
    });

    if (selectedLayout) {
        $('.app-layouts-grid .layout-card[data-layout-id="' + selectedLayout + '"]').addClass('selected');
        $nextStep2Button.prop('disabled', false);
    } else {
        $nextStep2Button.prop('disabled', true);
    }

    $prevStep2Button.on('click', function() {
        window.location.href = '<?php echo esc_url( home_url( '/new-appkit-step-1' ) ); ?>';
    });

    $nextStep2Button.on('click', function() {
        if (selectedLayout) {
            // TODO: AJAX call here to save selected layout and theme to the AppKit CPT draft
            // (Use currentAppDraftId if available, otherwise expect new app_id back)
            console.log('Selected Layout:', selectedLayout, 'Selected Theme:', selectedTheme);
            window.location.href = '<?php echo esc_url( home_url( '/new-appkit-step-3' ) ); ?>';
        } else {
            alert('Please select a layout first to proceed.');
        }
    });

    // --- Step 3: Module Editor (placeholder for complex logic) ---
    var $prevStep3Button = $('#prev-step-3');
    var $nextStep3Button = $('#next-step-3');

    if ($('#app-builder-canvas').length) {
        // This is where you would initialize a robust drag-and-drop framework.
        // E.g., for a React/Vue.js app embedded here, its initialization would go.
        console.log('App builder canvas detected. Drag and drop functionality will be implemented here.');

        // Placeholder for module drag-and-drop interactivity:
        $('.modules-palette .module-item').draggable({
            helper: 'clone',
            cursor: 'grabbing',
            revert: 'invalid',
            start: function(event, ui) {
                $(this).css('z-index', 100); // Bring dragged item to front
            }
        });

        $('#app-builder-canvas').droppable({
            accept: '.module-item',
            drop: function(event, ui) {
                var moduleId = ui.draggable.data('module-id');
                var moduleName = ui.draggable.text().trim();
                if (!moduleId) return;

                console.log('Module dropped:', moduleId, moduleName);

                // Simulate adding a module to the canvas
                var moduleHtml = '<div class="dropped-module-item alert alert-info mb-3 d-flex justify-content-between align-items-center" data-module-id="' + moduleId + '">' +
                                    '<span><i class="' + ui.draggable.find('i').attr('class') + ' me-2"></i> ' + moduleName + ' (Configurable)</span>' +
                                    '<button class="btn btn-sm btn-outline-info configure-module-btn me-2">Configure</button>' +
                                    '<button class="btn btn-sm btn-outline-danger remove-module-btn">&times;</button>' +
                                 '</div>';
                $(this).append(moduleHtml);
                $(this).find('.placeholder-text').hide(); // Hide placeholder once a module is added

                // TODO: Trigger an AJAX call to save the module configuration to the app draft
                // This would typically involve saving JSON data about the module and its initial settings.
                // updateAppDraft(currentAppDraftId, { action: 'add_module', module_id: moduleId });

                // Make dropped modules sortable
                // $('#app-builder-canvas').sortable({
                //     placeholder: "ui-state-highlight",
                //     update: function(event, ui) {
                //         // TODO: Save new module order via AJAX
                //     }
                // });
            }
        });

        // Handle "Configure" and "Remove" buttons for dropped modules
        $(document).on('click', '.configure-module-btn', function() {
            var moduleId = $(this).closest('.dropped-module-item').data('module-id');
            alert('Configure ' + moduleId + ' module. (Future popup/sidebar editor)');
            // TODO: Open a modal or sidebar for module-specific settings, loaded via AJAX.
        });

        $(document).on('click', '.remove-module-btn', function() {
            if (confirm('Are you sure you want to remove this module?')) {
                var $moduleItem = $(this).closest('.dropped-module-item');
                var moduleId = $moduleItem.data('module-id');
                $moduleItem.remove();
                console.log('Removed module:', moduleId);
                // TODO: Trigger AJAX call to remove module from app draft.
                if ($('#app-builder-canvas').children('.dropped-module-item').length === 0) {
                    $('#app-builder-canvas').find('.placeholder-text').show();
                }
            }
        });


        $prevStep3Button.on('click', function() {
            window.location.href = '<?php echo esc_url( home_url( '/new-appkit-step-2' ) ); ?>';
        });

        $nextStep3Button.on('click', function() {
            // TODO: Final save of current app configuration (modules, settings) via AJAX
            // Then redirect to the next step
            window.location.href = '<?php echo esc_url( home_url( '/new-appskit-step-4' ) ); ?>';
        });
    }

    // --- Step 4: Publish App ---
    var $prevStep4Button = $('#prev-step-4');
    var $generateApkButton = $('#generate-apk-btn');
    var $generateIosButton = $('#generate-ios-btn');
    var $publishGooglePlayButton = $('#publish-google-play-btn');
    var $publishAppleAppStoreButton = $('#publish-apple-app-store-btn');
    var $viewAppDashboardButton = $('#view-app-dashboard-btn');

    if ($('#publish-app-section').length) {
        $prevStep4Button.on('click', function() {
            window.location.href = '<?php echo esc_url( home_url( '/new-appkit-step-3' ) ); ?>';
        });

        $generateApkButton.on('click', function() {
            alert('Initiating Android APK generation. This may take a few minutes. (AJAX call to backend)');
            // TODO: AJAX call to backend to trigger native build process
            // On success, update #package-download-links
            $('#package-download-links').show().html('<p class="mb-0 text-success">APK generation request sent. Link will appear shortly...</p>');
        });

        $generateIosButton.on('click', function() {
            alert('Initiating iOS IPA generation. This may take a few minutes. (AJAX call to backend)');
            // TODO: AJAX call to backend to trigger native build process
            // On success, update #package-download-links
            $('#package-download-links').show().html('<p class="mb-0 text-success">IPA generation request sent. Link will appear shortly...</p>');
        });

        $publishGooglePlayButton.on('click', function() {
            alert('Redirecting to Google Play publishing. This feature requires a paid plan and developer account details.');
            // TODO: AJAX call to backend to initiate publishing API call/redirect to payment
        });

        $publishAppleAppStoreButton.on('click', function() {
            alert('Redirecting to Apple App Store publishing. This feature requires a paid plan and developer account details.');
            // TODO: AJAX call to backend to initiate publishing API call/redirect to payment
        });

        $viewAppDashboardButton.on('click', function() {
            // TODO: Get the newly created app's slug or ID and redirect to its user dashboard
            // For now, redirect to generic user dashboard
            window.location.href = '<?php echo esc_url( home_url( '/as-appskit-user-dashboard' ) ); ?>';
        });
    }

    // --- Global Helper for AJAX Calls ---
    // This is typically localized with wp_localize_script
    // Example: as_appskit_pro_ajax_object = { ajax_url: "...", nonce: "..." }
    // if (typeof as_appskit_pro_ajax_object === 'undefined') {
    //     console.warn('as_appskit_pro_ajax_object is not defined. AJAX calls will fail.');
    // }
});