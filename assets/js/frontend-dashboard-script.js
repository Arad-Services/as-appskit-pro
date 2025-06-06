/**
 * as-appskit-pro Frontend Dashboard JavaScript
 * Handles AJAX actions for auto-fix/regenerate, and sidebar navigation.
 *
 * @since 1.0.0
 */

jQuery(document).ready(function($){

    // Use localized script variables for AJAX URL and Nonce
    // asAppskitProFrontend.ajaxurl and asAppskitProFrontend.nonce are defined in class-as-appskit-pro-admin.php
    const ajax_url = asAppskitProFrontend.ajaxurl;
    const maintenance_nonce = asAppskitProFrontend.maintenanceNonce;
    const frontend_admin_nonce = asAppskitProFrontend.frontendAdminNonce;


    // Smooth scroll for sidebar navigation
    $('.sidebar .nav-link').on('click', function(e) {
        e.preventDefault();
        const targetId = $(this).attr('href');
        if (targetId.startsWith('#')) {
            $('html, body').animate({
                scrollTop: $(targetId).offset().top - 70 // Adjust for fixed header/toolbar height
            }, 800);

            // Update active state in sidebar
            $('.sidebar .nav-link').removeClass('active');
            $(this).addClass('active');
        }
    });

    // Handle "Regenerate Core Files" button click (Frontend Admin Dashboard)
    $('#as-appskit-pro-frontend-regenerate-files-btn').on('click', function(e) {
        e.preventDefault();
        const button = $(this);
        const statusDiv = $('#as-appskit-pro-frontend-regenerate-status');
        const originalText = button.html();

        button.attr('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Regenerating...');
        statusDiv.removeClass('alert alert-success alert-danger alert-info').html(''); // Clear previous status

        $.ajax({
            url: ajax_url, // Use localized ajax_url
            type: 'POST',
            data: {
                action: 'as_appskit_pro_regenerate_files',
                nonce: maintenance_nonce // Use localized nonce
            },
            success: function(response) {
                if (response.success) {
                    statusDiv.addClass('alert alert-success').html(response.data || 'Files regenerated successfully!');
                } else {
                    statusDiv.addClass('alert alert-danger').html(response.data || 'Failed to regenerate files.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                statusDiv.addClass('alert alert-danger').html('An unexpected error occurred during regeneration. Check console for details.');
                console.error('AJAX Error on regenerate files:', textStatus, errorThrown, jqXHR.responseText);
            },
            complete: function() {
                button.attr('disabled', false).html(originalText);
            }
        });
    });

    // Handle "Run Manual Health Check & Fix" button click (Frontend Admin Dashboard)
    $('#as-appskit-pro-frontend-check-errors-btn').on('click', function(e) {
        e.preventDefault();
        const button = $(this);
        const statusDiv = $('#as-appskit-pro-frontend-check-errors-status');
        const originalText = button.html();

        button.attr('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Checking...');
        statusDiv.removeClass('alert alert-success alert-danger alert-info').html(''); // Clear previous status

        $.ajax({
            url: ajax_url, // Use localized ajax_url
            type: 'POST',
            data: {
                action: 'as_appskit_pro_check_and_fix_errors',
                nonce: maintenance_nonce // Use localized nonce
            },
            success: function(response) {
                if (response.success) {
                    statusDiv.addClass('alert alert-info').html(response.data || 'Health check completed.');
                } else {
                    statusDiv.addClass('alert alert-danger').html(response.data || 'Health check failed.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                statusDiv.addClass('alert alert-danger').html('An unexpected error occurred during health check. Check console for details.');
                console.error('AJAX Error on health check:', textStatus, errorThrown, jqXHR.responseText);
            },
            complete: function() {
                button.attr('disabled', false).html(originalText);
            }
        });
    });

    // Handle saving settings from frontend admin dashboard forms (using Bootstrap forms)
    // This example uses a generic class '.as-appskit-pro-settings-form' for forms to save.
    $('.as-appskit-pro-settings-form input, .as-appskit-pro-settings-form select, .as-appskit-pro-settings-form textarea').on('change', function() {
        const form = $(this).closest('form');
        const formData = form.serializeArray();
        formData.push({name: 'action', value: 'as_appskit_pro_update_frontend_settings'});
        formData.push({name: 'nonce', value: frontend_admin_nonce}); // Use localized nonce

        // This is a simplified auto-save, for complex forms, use a debounce
        $.ajax({
            url: ajax_url, // Use localized ajax_url
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    console.log('Setting saved:', response.data);
                    // Optionally show a temporary save indicator
                } else {
                    console.error('Error saving setting:', response.data);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX error saving setting:', textStatus, errorThrown, jqXHR.responseText);
            }
        });
    });
});