<div class="card p-4">
    <h2><?php _e( 'General & PWA Features Settings', 'as-appskit-pro' ); ?></h2>
    <p class="lead"><?php _e( 'Configure global settings for all apps built using AppKit Pro.', 'as-appskit-pro' ); ?></p>

    <h3 class="mt-4"><?php _e( 'App Core Settings', 'as-appskit-pro' ); ?></h3>
    <table class="form-table">
        <tr>
            <th scope="row"><label for="app_name"><?php _e( 'Default Application Name', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="text" id="app_name" name="app_name" value="<?php echo esc_attr( get_site_option( 'as_appskit_pro_setting_app_name', '' ) ); ?>" class="regular-text" />
                <p class="description"><?php _e( 'The default full name for new apps.', 'as-appskit-pro' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="app_short_name"><?php _e( 'Default Application Short Name', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="text" id="app_short_name" name="app_short_name" value="<?php echo esc_attr( get_site_option( 'as_appskit_pro_setting_app_short_name', '' ) ); ?>" class="regular-text" />
                <p class="description"><?php _e( 'A short name for new apps (max 12-15 characters, for homescreen icons).', 'as-appskit-pro' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pwa_start_page"><?php _e( 'Default PWA Start Page URL', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="url" id="pwa_start_page" name="pwa_start_page" value="<?php echo esc_url( get_site_option( 'as_appskit_pro_setting_pwa_start_page', '' ) ); ?>" class="regular-text" />
                <p class="description"><?php _e( 'The default URL where the PWA will launch. Leave empty to use app slug.', 'as-appskit-pro' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pwa_icon_upload"><?php _e( 'Default App Icon URL', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="text" id="pwa_icon_upload" name="pwa_icon_upload" value="<?php echo esc_url( get_site_option( 'as_appskit_pro_setting_pwa_icon_upload', '' ) ); ?>" class="regular-text as-appskit-pro-media-field" />
                <button type="button" class="button as-appskit-pro-upload-button" data-target-field="#pwa_icon_upload" data-target-image="#pwa_icon_upload_preview"><?php _e( 'Upload Image', 'as-appskit-pro' ); ?></button>
                <img id="pwa_icon_upload_preview" src="<?php echo esc_url( get_site_option( 'as_appskit_pro_setting_pwa_icon_upload', '' ) ); ?>" style="max-width:100px;height:auto;margin-top:10px;display:<?php echo get_site_option( 'as_appskit_pro_setting_pwa_icon_upload', '' ) ? 'block' : 'none'; ?>;" />
                <p class="description"><?php _e( 'Default 192x192px icon for new apps. Also used as Apple Touch Icon.', 'as-appskit-pro' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="splash_icon_512_enabled"><?php _e( 'High-Quality Splash Screen Icon (512x512)', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="splash_icon_512_enabled" name="splash_icon_512_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_splash_icon_512_enabled', false ) ); ?> />
                <label for="splash_icon_512_enabled" class="description"><?php _e( 'Enable default 512x512px icon for splash screens.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pwa_splash_bg_color"><?php _e( 'Default Splash Screen Background Color', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="text" id="pwa_splash_bg_color" name="pwa_splash_bg_color" value="<?php echo esc_attr( get_site_option( 'as_appskit_pro_setting_pwa_splash_bg_color', '#ffffff' ) ); ?>" class="as-appskit-pro-color-picker" />
                <p class="description"><?php _e( 'Default background color for the app splash screen.', 'as-appskit-pro' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="default_orientation"><?php _e( 'Default App Orientation', 'as-appskit-pro' ); ?></label></th>
            <td>
                <select id="default_orientation" name="default_orientation">
                    <option value="any" <?php selected( get_site_option( 'as_appskit_pro_setting_default_orientation', 'any' ), 'any' ); ?>><?php _e( 'Any (Follow Device)', 'as-appskit-pro' ); ?></option>
                    <option value="portrait" <?php selected( get_site_option( 'as_appskit_pro_setting_default_orientation', 'any' ), 'portrait' ); ?>><?php _e( 'Portrait', 'as-appskit-pro' ); ?></option>
                    <option value="landscape" <?php selected( get_site_option( 'as_appskit_pro_setting_default_orientation', 'any' ), 'landscape' ); ?>><?php _e( 'Landscape', 'as-appskit-pro' ); ?></option>
                </select>
                <p class="description"><?php _e( 'The default preferred orientation for apps.', 'as-appskit-pro' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="display_property"><?php _e( 'Default Display Property', 'as-appskit-pro' ); ?></label></th>
            <td>
                <select id="display_property" name="display_property">
                    <option value="fullscreen" <?php selected( get_site_option( 'as_appskit_pro_setting_display_property', 'standalone' ), 'fullscreen' ); ?>><?php _e( 'Fullscreen', 'as-appskit-pro' ); ?></option>
                    <option value="standalone" <?php selected( get_site_option( 'as_appskit_pro_setting_display_property', 'standalone' ), 'standalone' ); ?>><?php _e( 'Standalone (Native-like)', 'as-appskit-pro' ); ?></option>
                    <option value="minimal-ui" <?php selected( get_site_option( 'as_appskit_pro_setting_display_property', 'standalone' ), 'minimal-ui' ); ?>><?php _e( 'Minimal UI', 'as-appskit-pro' ); ?></option>
                    <option value="browser" <?php selected( get_site_option( 'as_appskit_pro_setting_display_property', 'standalone' ), 'browser' ); ?>><?php _e( 'Browser', 'as-appskit-pro' ); ?></option>
                </select>
                <p class="description"><?php _e( 'How the web app is displayed to the user.', 'as-appskit-pro' ); ?></p>
            </td>
        </tr>
    </table>

    <h3 class="mt-4"><?php _e( 'PWA & Offline Settings', 'as-appskit-pro' ); ?></h3>
    <table class="form-table">
        <tr>
            <th scope="row"><label for="pwa_install_prompt_enabled"><?php _e( 'Installation Prompts and Buttons', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="pwa_install_prompt_enabled" name="pwa_install_prompt_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_pwa_install_prompt_enabled', true ) ); ?> />
                <label for="pwa_install_prompt_enabled" class="description"><?php _e( 'Enable "Add to Home Screen" prompts.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="add_to_home_screen_notice_enabled"><?php _e( '"Add to Home Screen" Notice', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="add_to_home_screen_notice_enabled" name="add_to_home_screen_notice_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_add_to_home_screen_notice_enabled', true ) ); ?> />
                <label for="add_to_home_screen_notice_enabled" class="description"><?php _e( 'Show the browser\'s default "Add to home screen" notice.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="offline_usage_enabled"><?php _e( 'Offline Usage & Aggressive Caching', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="offline_usage_enabled" name="offline_usage_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_offline_usage_enabled', true ) ); ?> />
                <label for="offline_usage_enabled" class="description"><?php _e( 'Enable pages to be served offline using Cache Storage API.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="custom_offline_page_id"><?php _e( 'Custom Offline Page', 'as-appskit-pro' ); ?></label></th>
            <td>
                <?php
                $args = array(
                    'name'              => 'custom_offline_page_id',
                    'id'                => 'custom_offline_page_id',
                    'selected'          => get_site_option( 'as_appskit_pro_setting_custom_offline_page_id', 0 ),
                    'show_option_none'  => __( '— Select a page —', 'as-appskit-pro' ),
                    'option_none_value' => '0',
                    'echo'              => 0,
                    'post_type'         => 'page', // Only show pages
                    'post_status'       => 'publish', // Only published pages
                    'show_option_no_change' => __( 'Default Offline Page', 'as-appskit-pro' ), // Custom text for default
                );
                echo wp_dropdown_pages( $args );
                ?>
                <p class="description"><?php _e( 'Select the page users see when offline and accessing uncached content.', 'as-appskit-pro' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="caching_strategy"><?php _e( 'Default Caching Strategy', 'as-appskit-pro' ); ?></label></th>
            <td>
                <select id="caching_strategy" name="caching_strategy">
                    <option value="network_first" <?php selected( get_site_option( 'as_appskit_pro_setting_caching_strategy', 'network_first' ), 'network_first' ); ?>><?php _e( 'Network First (prefer fresh content)', 'as-appskit-pro' ); ?></option>
                    <option value="cache_first" <?php selected( get_site_option( 'as_appskit_pro_setting_caching_strategy', 'network_first' ), 'cache_first' ); ?>><?php _e( 'Cache First (prefer offline speed)', 'as-appskit-pro' ); ?></option>
                    <option value="stale_while_revalidate" <?php selected( get_site_option( 'as_appskit_pro_setting_caching_strategy', 'network_first' ), 'stale_while_revalidate' ); ?>><?php _e( 'Stale While Revalidate', 'as-appskit-pro' ); ?></option>
                </select>
                <p class="description"><?php _e( 'How the Service Worker fetches and caches content.', 'as-appskit-pro' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cache_expire_time"><?php _e( 'Cache Expire Time (seconds)', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="number" id="cache_expire_time" name="cache_expire_time" value="<?php echo esc_attr( get_site_option( 'as_appskit_pro_setting_cache_expire_time', 2592000 ) ); ?>" class="small-text" />
                <p class="description"><?php _e( 'Time before cached assets are considered stale (0 for no expiration). Default: 30 days.', 'as-appskit-pro' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="service_worker_update_handling_improved"><?php _e( 'Improved Service Worker Update Handling', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="service_worker_update_handling_improved" name="service_worker_update_handling_improved" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_service_worker_update_handling_improved', true ) ); ?> />
                <label for="service_worker_update_handling_improved" class="description"><?php _e( 'Enable smoother in-browser service worker updates.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="manifest_theme_color_prop_enabled"><?php _e( 'Theme Color Property in Manifest', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="manifest_theme_color_prop_enabled" name="manifest_theme_color_prop_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_manifest_theme_color_prop_enabled', true ) ); ?> />
                <label for="manifest_theme_color_prop_enabled" class="description"><?php _e( 'Include theme_color property in the Web App Manifest.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="maskable_icons_enabled"><?php _e( 'Maskable Icons Support', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="maskable_icons_enabled" name="maskable_icons_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_maskable_icons_enabled', true ) ); ?> />
                <label for="maskable_icons_enabled" class="description"><?php _e( 'Enable support for Maskable Icons for adaptive icon shapes.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="monochrome_icon_enabled"><?php _e( 'Monochrome Icon Support', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="monochrome_icon_enabled" name="monochrome_icon_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_monochrome_icon_enabled', true ) ); ?> />
                <label for="monochrome_icon_enabled" class="description"><?php _e( 'Enable support for Monochrome Icons for system interfaces.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="apple_touch_icons_enabled"><?php _e( 'Apple Touch Icons', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="apple_touch_icons_enabled" name="apple_touch_icons_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_apple_touch_icons_enabled', true ) ); ?> />
                <label for="apple_touch_icons_enabled" class="description"><?php _e( 'Automatically set app icons as Apple Touch Icons for iOS devices.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
    </table>

    <h3 class="mt-4"><?php _e( 'Engagement & UI Features', 'as-appskit-pro' ); ?></h3>
    <table class="form-table">
        <tr>
            <th scope="row"><label for="navigation_tab_bar_enabled"><?php _e( 'Navigation Tab Bar', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="navigation_tab_bar_enabled" name="navigation_tab_bar_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_navigation_tab_bar_enabled', true ) ); ?> />
                <label for="navigation_tab_bar_enabled" class="description"><?php _e( 'Enable default navigation tab bar in apps.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="scroll_progress_bar_enabled"><?php _e( 'Scroll Progress Bar', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="scroll_progress_bar_enabled" name="scroll_progress_bar_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_scroll_progress_bar_enabled', true ) ); ?> />
                <label for="scroll_progress_bar_enabled" class="description"><?php _e( 'Show a progress bar indicating scroll position.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pull_down_refresh_enabled"><?php _e( 'Pull Down Refresh', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="pull_down_refresh_enabled" name="pull_down_refresh_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_pull_down_refresh_enabled', true ) ); ?> />
                <label for="pull_down_refresh_enabled" class="description"><?php _e( 'Enable pull-to-refresh gesture in apps.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="dark_mode_enabled"><?php _e( 'Dark Mode Support', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="dark_mode_enabled" name="dark_mode_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_dark_mode_enabled', true ) ); ?> />
                <label for="dark_mode_enabled" class="description"><?php _e( 'Enable dark mode toggle/auto-detection for apps.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="shake_to_refresh_enabled"><?php _e( 'Shake To Refresh', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="shake_to_refresh_enabled" name="shake_to_refresh_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_shake_to_refresh_enabled', false ) ); ?> />
                <label for="shake_to_refresh_enabled" class="description"><?php _e( 'Enable shaking device to refresh app content.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="page_loader_enabled"><?php _e( 'Page Loader Animation', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="page_loader_enabled" name="page_loader_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_page_loader_enabled', true ) ); ?> />
                <label for="page_loader_enabled" class="description"><?php _e( 'Show a loading animation during page transitions.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="toast_messages_enabled"><?php _e( 'Toast Messages', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="toast_messages_enabled" name="toast_messages_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_toast_messages_enabled', true ) ); ?> />
                <label for="toast_messages_enabled" class="description"><?php _e( 'Enable small, non-intrusive notification popups.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="inactive_blur_enabled"><?php _e( 'Inactive Blur Effect', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="inactive_blur_enabled" name="inactive_blur_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_inactive_blur_enabled', false ) ); ?> />
                <label for="inactive_blur_enabled" class="description"><?php _e( 'Apply a blur effect when the app is inactive in the background.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="smooth_page_transitions_enabled"><?php _e( 'Smooth Page Transitions', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="smooth_page_transitions_enabled" name="smooth_page_transitions_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_smooth_page_transitions_enabled', true ) ); ?> />
                <label for="smooth_page_transitions_enabled" class="description"><?php _e( 'Enable subtle animations for page navigation.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="vibrations_enabled"><?php _e( 'Haptic Feedback (Vibrations)', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="vibrations_enabled" name="vibrations_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_vibrations_enabled', false ) ); ?> />
                <label for="vibrations_enabled" class="description"><?php _e( 'Enable subtle vibrations for user interactions (e.g., button taps).', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="idle_detection_enabled"><?php _e( 'Idle Detection API', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="idle_detection_enabled" name="idle_detection_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_idle_detection_enabled', false ) ); ?> />
                <label for="idle_detection_enabled" class="description"><?php _e( 'Detect user inactivity to optimize resources (requires user permission).', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="screen_wake_lock_enabled"><?php _e( 'Screen Wake Lock API', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="screen_wake_lock_enabled" name="screen_wake_lock_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_screen_wake_lock_enabled', false ) ); ?> />
                <label for="screen_wake_lock_enabled" class="description"><?php _e( 'Prevent screen from turning off (e.g., during presentations or media playback).', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="biometric_auth_enabled"><?php _e( 'Biometric Authentication (Fingerprint/Face ID)', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="biometric_auth_enabled" name="biometric_auth_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_biometric_auth_enabled', false ) ); ?> />
                <label for="biometric_auth_enabled" class="description"><?php _e( 'Allow users to authenticate with biometrics (requires HTTPS).', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="background_sync_enabled"><?php _e( 'Background Sync API', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="background_sync_enabled" name="background_sync_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_background_sync_enabled', true ) ); ?> />
                <label for="background_sync_enabled" class="description"><?php _e( 'Enable sending data when online, even if user closes app (for offline forms).', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="content_indexing_enabled"><?php _e( 'Content Indexing API', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="content_indexing_enabled" name="content_indexing_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_content_indexing_enabled', true ) ); ?> />
                <label for="content_indexing_enabled" class="description"><?php _e( 'Make offline content discoverable by the device OS.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="persistent_storage_enabled"><?php _e( 'Persistent Storage', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="persistent_storage_enabled" name="persistent_storage_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_persistent_storage_enabled', true ) ); ?> />
                <label for="persistent_storage_enabled" class="description"><?php _e( 'Request the browser to persist app data, preventing automatic deletion.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="push_notifications_enabled"><?php _e( 'Push Notifications (via OneSignal)', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="push_notifications_enabled" name="push_notifications_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_push_notifications_enabled', true ) ); ?> />
                <label for="push_notifications_enabled" class="description"><?php _e( 'Enable push notifications for your apps (requires OneSignal configuration).', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="swipe_navigation_enabled"><?php _e( 'Swipe Navigation', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="swipe_navigation_enabled" name="swipe_navigation_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_swipe_navigation_enabled', true ) ); ?> />
                <label for="swipe_navigation_enabled" class="description"><?php _e( 'Adds swipe left/right to load next and previous articles/pages.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="disable_scrollbar_enabled"><?php _e( 'Disable Scrollbar in PWA', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="disable_scrollbar_enabled" name="disable_scrollbar_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_disable_scrollbar_enabled', false ) ); ?> />
                <label for="disable_scrollbar_enabled" class="description"><?php _e( 'Hide the scrollbar in the PWA app for a cleaner look.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="create_app_from_url_enabled"><?php _e( 'Create App Using Website URL', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="create_app_from_url_enabled" name="create_app_from_url_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_create_app_from_url_enabled', true ) ); ?> />
                <label for="create_app_from_url_enabled" class="description"><?php _e( 'Allow users to quickly create an app from an existing website URL.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="ai_agents_enabled"><?php _e( 'AI Agents for Content Updates', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="ai_agents_enabled" name="ai_agents_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_ai_agents_enabled', false ) ); ?> />
                <label for="ai_agents_enabled" class="description"><?php _e( 'Enable AI agents to automatically update app content and cache.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
    </table>

    <h3 class="mt-4"><?php _e( 'Compatibility Settings', 'as-appskit-pro' ); ?></h3>
    <table class="form-table">
        <tr>
            <th scope="row"><label for="amp_support_enabled"><?php _e( 'AMP Support', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="amp_support_enabled" name="amp_support_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_amp_support_enabled', true ) ); ?> />
                <label for="amp_support_enabled" class="description"><?php _e( 'Enable full PWA compatibility for Accelerated Mobile Pages (AMP).', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="wp_hide_security_enhancer_compat_enabled"><?php _e( 'WP Hide & Security Enhancer Compatibility', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="wp_hide_security_enhancer_compat_enabled" name="wp_hide_security_enhancer_compat_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_wp_hide_security_enhancer_compat_enabled', true ) ); ?> />
                <label for="wp_hide_security_enhancer_compat_enabled" class="description"><?php _e( 'Ensure compatibility with WP Hide & Security Enhancer plugin.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="subfolder_compat_enabled"><?php _e( 'WordPress Sub-folder Compatibility', 'as-appskit-pro' ); ?></label></th>
            <td>
                <input type="checkbox" id="subfolder_compat_enabled" name="subfolder_compat_enabled" value="1" <?php checked( get_site_option( 'as_appskit_pro_setting_subfolder_compat_enabled', true ) ); ?> />
                <label for="subfolder_compat_enabled" class="description"><?php _e( 'Ensure full compatibility when WordPress is installed in a sub-folder.', 'as-appskit-pro' ); ?></label>
            </td>
        </tr>
    </table>
</div>