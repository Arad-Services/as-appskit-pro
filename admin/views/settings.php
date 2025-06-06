<div class="wrap">
    <h1><?php _e( 'as-appskit-pro Global Settings', 'as-appskit-pro' ); ?></h1>
    <h2 class="nav-tab-wrapper">
        <a href="?page=as-appskit-pro-settings&tab=general" class="nav-tab <?php echo ( $_GET['tab'] ?? 'general' ) === 'general' ? 'nav-tab-active' : ''; ?>">
            <?php _e( 'General & PWA Features', 'as-appskit-pro' ); ?>
        </a>
        <a href="?page=as-appskit-pro-settings&tab=integrations" class="nav-tab <?php echo ( $_GET['tab'] ?? '' ) === 'integrations' ? 'nav-tab-active' : ''; ?>">
            <?php _e( 'Integrations', 'as-appskit-pro' ); ?>
        </a>
        <a href="?page=as-appskit-pro-settings&tab=health_check" class="nav-tab <?php echo ( $_GET['tab'] ?? '' ) === 'health_check' ? 'nav-tab-active' : ''; ?>">
            <?php _e( 'Health & Tools', 'as-appskit-pro' ); ?>
        </a>
        <?php // Add more tabs for Native App Build Settings, AI Settings, etc. ?>
    </h2>

    <?php
    // Display health check results if redirected from health check action
    if ( isset( $_GET['health-check-run'] ) && $_GET['health-check-run'] === 'true' ) {
        $results = get_transient( 'as_appskit_pro_health_check_results' );
        if ( $results && ( ! empty( $results['messages'] ) || ! empty( $results['errors'] ) ) ) {
            echo '<div id="message" class="updated notice is-dismissible"><p><strong>' . __( 'Health Check Results:', 'as-appskit-pro' ) . '</strong></p><ul>';
            foreach ( $results['messages'] as $msg ) {
                echo '<li><span class="dashicons dashicons-yes-alt" style="color: green;"></span> ' . esc_html( $msg ) . '</li>';
            }
            foreach ( $results['errors'] as $err ) {
                echo '<li><span class="dashicons dashicons-warning" style="color: red;"></span> ' . wp_kses_post( $err ) . '</li>';
            }
            echo '</ul></div>';
            delete_transient( 'as_appskit_pro_health_check_results' );
        }
    }

    // Display generic settings updated message
    if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] === 'true' ) {
        echo '<div id="setting-error-settings_updated" class="updated notice is-dismissible"><p><strong>' . __( 'Settings saved.', 'as-appskit-pro' ) . '</strong></p></div>';
    }
    ?>

    <form method="post" action="<?php echo esc_url( network_admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="as_appskit_pro_save_network_settings">
        <?php wp_nonce_field( 'as-appskit-pro-save-network-settings' ); ?>

        <div class="tab-content">
            <?php
            $current_tab = $_GET['tab'] ?? 'general';

            if ( $current_tab === 'general' ) {
                include AS_APPSKIT_PRO_PLUGIN_DIR . 'admin/partials/as-appskit-pro-network-settings-display.php';
            } elseif ( $current_tab === 'integrations' ) {
                // TODO: Include a separate partial for integrations like OneSignal API keys, Firebase settings etc.
                echo '<div class="card p-4"><h2>' . __( 'Integration Settings', 'as-appskit-pro' ) . '</h2><p>' . __( 'Configure API keys and external service integrations here.', 'as-appskit-pro' ) . '</p>';
                // OneSignal Settings
                $onesignal_app_id = get_site_option('as_appskit_pro_setting_onesignal_app_id', '');
                $onesignal_api_key = get_site_option('as_appskit_pro_setting_onesignal_api_key', '');
                ?>
                <h3 class="mt-4"><?php _e('OneSignal Push Notifications', 'as-appskit-pro'); ?></h3>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="onesignal_app_id"><?php _e('OneSignal App ID', 'as-appskit-pro'); ?></label></th>
                        <td>
                            <input type="text" id="onesignal_app_id" name="onesignal_app_id" value="<?php echo esc_attr($onesignal_app_id); ?>" class="regular-text" />
                            <p class="description"><?php _e('Enter your OneSignal Application ID.', 'as-appskit-pro'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="onesignal_api_key"><?php _e('OneSignal REST API Key', 'as-appskit-pro'); ?></label></th>
                        <td>
                            <input type="text" id="onesignal_api_key" name="onesignal_api_key" value="<?php echo esc_attr($onesignal_api_key); ?>" class="regular-text" />
                            <p class="description"><?php _e('Enter your OneSignal REST API Key for sending push notifications.', 'as-appskit-pro'); ?></p>
                        </td>
                    </tr>
                </table>
                <?php
                echo '</div>'; // close card
            } elseif ( $current_tab === 'health_check' ) {
                include AS_APPSKIT_PRO_PLUGIN_DIR . 'admin/partials/as-appskit-pro-health-check-display.php';
            }
            ?>
        </div>

        <?php submit_button(); ?>
    </form>
</div>