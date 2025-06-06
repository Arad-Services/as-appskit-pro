<?php
/**
 * Admin View: PWA Feature Toggles
 * Displays checkboxes for enabling/disabling various PWA features.
 *
 * @since 1.0.0
 */

// Get current options
$offline_usage_enabled    = get_option( 'as_appskit_pro_offline_usage_enabled', 'yes' ); // Default to 'yes'
$install_prompt_enabled   = get_option( 'as_appskit_pro_install_prompt_enabled', 'yes' );
$pull_to_refresh_enabled  = get_option( 'as_appskit_pro_pull_to_refresh_enabled', 'yes' );
// Add more feature options here as you implement them
?>

<table class="form-table">
    <tr>
        <th scope="row"><?php esc_html_e( 'Offline Usage & Caching', 'as-appskit-pro' ); ?></th>
        <td>
            <label for="as_appskit_pro_offline_usage_enabled">
                <input type="checkbox" id="as_appskit_pro_offline_usage_enabled" name="as_appskit_pro_offline_usage_enabled" value="yes" <?php checked( 'yes', $offline_usage_enabled ); ?> />
                <?php esc_html_e( 'Enable aggressive caching and offline content serving.', 'as-appskit-pro' ); ?>
            </label>
            <p class="description"><?php esc_html_e( 'Allows your app to load cached pages even when the user is offline.', 'as-appskit-pro' ); ?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e( 'Installation Prompt', 'as-appskit-pro' ); ?></th>
        <td>
            <label for="as_appskit_pro_install_prompt_enabled">
                <input type="checkbox" id="as_appskit_pro_install_prompt_enabled" name="as_appskit_pro_install_prompt_enabled" value="yes" <?php checked( 'yes', $install_prompt_enabled ); ?> />
                <?php esc_html_e( 'Show "Add to Home Screen" prompt for supported browsers.', 'as-appskit-pro' ); ?>
            </label>
            <p class="description"><?php esc_html_e( 'Encourages users to install your PWA to their device home screen.', 'as-appskit-pro' ); ?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e( 'Pull Down to Refresh', 'as-appskit-pro' ); ?></th>
        <td>
            <label for="as_appskit_pro_pull_to_refresh_enabled">
                <input type="checkbox" id="as_appskit_pro_pull_to_refresh_enabled" name="as_appskit_pro_pull_to_refresh_enabled" value="yes" <?php checked( 'yes', $pull_to_refresh_enabled ); ?> />
                <?php esc_html_e( 'Enable native-like pull-down-to-refresh on supported pages.', 'as-appskit-pro' ); ?>
            </label>
            <p class="description"><?php esc_html_e( 'Allows users to refresh content by pulling down the screen.', 'as-appskit-pro' ); ?></p>
        </td>
    </tr>
    <?php
    // Add more feature rows here, following the same structure
    /*
    <tr>
        <th scope="row"><?php esc_html_e( 'Dark Mode Toggle', 'as-appskit-pro' ); ?></th>
        <td>
            <label for="as_appskit_pro_dark_mode_enabled">
                <input type="checkbox" id="as_appskit_pro_dark_mode_enabled" name="as_appskit_pro_dark_mode_enabled" value="yes" <?php checked( 'yes', get_option('as_appskit_pro_dark_mode_enabled', 'no') ); ?> />
                <?php esc_html_e( 'Enable dark mode toggle for users.', 'as-appskit-pro' ); ?>
            </label>
            <p class="description"><?php esc_html_e( 'Adds a switch to enable a dark theme for your app.', 'as-appskit-pro' ); ?></p>
        </td>
    </tr>
    */
    ?>
</table>