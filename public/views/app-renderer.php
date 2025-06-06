<?php
/**
 * Template for rendering dynamically created user apps.
 *
 * This file acts as the entry point for each user-generated app URL (e.g., yourdomain.com/app/my-awesome-app).
 * It will fetch the app's configuration and render its content.
 *
 * @package As_Appskit_Pro
 * @subpackage Public/Views
 * @version 4.0.1
 */

// Important: This file typically should NOT include get_header()/get_footer() from the main WordPress theme
// as it needs to render a standalone app experience. It will build its own HTML structure.

$app_slug = get_query_var( 'as_appskit_pro_app_slug' );

// TODO: Fetch app data from the global custom table 'wp_as_appskit_pro_apps' using $app_slug
// Use global $wpdb; to query the table.
// Example:
global $wpdb;
$table_name_apps = $wpdb->base_prefix . 'as_appskit_pro_apps';
$app_data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name_apps WHERE app_slug = %s AND status = 'published'", $app_slug ), ARRAY_A );

if ( ! $app_data ) {
    // App not found or not published, show a 404 or a custom error page
    status_header( 404 );
    nocache_headers();
    // You could redirect to a custom 404 page or display a message
    echo '<!DOCTYPE html><html><head><title>App Not Found</title></head><body><h1>404 - App Not Found</h1><p>The app you are looking for does not exist or is not published.</p></body></html>';
    exit;
}

// Parse app settings (stored as JSON)
$app_settings = json_decode( $app_data['settings'], true );
$pwa_settings = $app_settings['pwa_settings'] ?? array();

// Extract PWA manifest data
$app_name = $pwa_settings['app_name'] ?? $app_data['app_name'];
$short_name = $pwa_settings['short_name'] ?? substr($app_name, 0, 12);
$theme_color = $pwa_settings['theme_color'] ?? '#ffffff';
$background_color = $pwa_settings['background_color'] ?? '#ffffff';
$display_mode = $pwa_settings['display_mode'] ?? 'standalone';
$orientation = $pwa_settings['orientation'] ?? 'any';
$icon_url = $pwa_settings['icon_url'] ?? AS_APPSKIT_PRO_PLUGIN_URL . 'assets/img/default-pwa-icon.png';
$splash_icon_url = $pwa_settings['splash_icon_url'] ?? AS_APPSKIT_PRO_PLUGIN_URL . 'assets/img/default-splash-icon.png';
$maskable_icon_enabled = !empty($pwa_settings['maskable_icon']);
$monochrome_icon_enabled = !empty($pwa_settings['monochrome_icon']);


// IMPORTANT: This is where the magic happens.
// You will dynamically construct the HTML for the app based on:
// 1. The selected theme (from templates/app-themes/)
// 2. The selected layout (from templates/app-layouts/)
// 3. The configured modules (from templates/app-modules/)
// 4. The PWA settings retrieved from $app_settings

// For a basic working placeholder:
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?php echo esc_html( $app_name ); ?></title>

    <meta name="theme-color" content="<?php echo esc_attr( $theme_color ); ?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="<?php echo esc_attr( $app_name ); ?>">
    <link rel="apple-touch-icon" href="<?php echo esc_url( $icon_url ); ?>">
    <?php if ( $maskable_icon_enabled ) : ?>
        <link rel="icon" type="image/png" sizes="192x192" href="<?php echo esc_url( $icon_url ); ?>" maskable>
    <?php endif; ?>
    <?php if ( $monochrome_icon_enabled ) : ?>
        <link rel="icon" type="image/png" sizes="192x192" href="<?php echo esc_url( $icon_url ); ?>" monochrome>
    <?php endif; ?>

    <link rel="manifest" href="<?php echo esc_url( home_url( '/manifest.json?app_slug=' . $app_slug ) ); ?>">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo esc_url( AS_APPSKIT_PRO_PLUGIN_URL . 'assets/css/app-common.css' ); ?>">
    <?php
    // TODO: Include theme-specific CSS based on $app_data['theme_id']
    // Example: <link rel="stylesheet" href="<?php echo esc_url( AS_APPSKIT_PRO_PLUGIN_URL . 'templates/app-themes/' . $app_data['theme_id'] . '/style.css' ); ?>">
    ?>

    <style>
        /* Dynamic styles based on app settings, e.g. splash screen background */
        body {
            background-color: <?php echo esc_attr( $background_color ); ?>;
        }
    </style>
</head>
<body>
    <div id="app-wrapper">
        <div class="app-header bg-primary text-white p-3 text-center">
            <h1><?php echo esc_html( $app_name ); ?></h1>
            <p><?php echo esc_html( $short_name ); ?></p>
            <?php
            // TODO: Render Navigation Tab Bar / Drawer Menu based on $app_data['layout_id']
            // Example: include AS_APPSKIT_PRO_PLUGIN_DIR . 'templates/app-layouts/' . $app_data['layout_id'] . '.html';
            ?>
        </div>

        <div class="app-content p-3">
            <h2 class="text-center mt-3"><?php _e( 'Your App Content!', 'as-appskit-pro' ); ?></h2>
            <p class="text-center lead"><?php _e( 'This is a live preview of your generated app. Content will be loaded dynamically based on your chosen theme, layout, and modules.', 'as-appskit-pro' ); ?></p>

            <?php
            // TODO: Loop through $app_settings['module_data'] and include/render each module
            // This is complex and requires each module to have a rendering function.
            // Example:
            if ( ! empty( $app_settings['module_data'] ) ) {
                echo '<h3 class="mt-4">' . __( 'Configured Modules:', 'as-appskit-pro' ) . '</h3>';
                echo '<ul class="list-group">';
                foreach ( $app_settings['module_data'] as $module ) {
                    $module_id = sanitize_text_field( $module['id'] ?? 'unknown-module' );
                    echo '<li class="list-group-item">' . esc_html( ucfirst( str_replace('-', ' ', $module_id) ) ) . ' Module</li>';
                    // TODO: Call a function to render the module's actual content
                    // As_Appskit_Pro_Module_Renderer::render_module( $module_id, $module['settings'] );
                }
                echo '</ul>';
            } else {
                echo '<p class="text-center text-muted mt-4">' . __( 'No modules configured yet. Go back to the App Builder to add features!', 'as-appskit-pro' ) . '</p>';
            }
            ?>
        </div>

        <div class="app-footer bg-light p-3 text-center text-muted small">
            <?php printf( __( '&copy; %d %s. Powered by AppKit Pro.', 'as-appskit-pro' ), date('Y'), esc_html( $app_name ) ); ?>
            <?php
            // TODO: If whitelabeling is enabled and plan allows, remove "Powered by AppKit Pro."
            ?>
        </div>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('<?php echo esc_url( home_url( '/service-worker.js?app_slug=' . $app_slug . '&v=' . AS_APPSKIT_PRO_VERSION ) ); ?>').then(function(registration) {
                    // Registration was successful
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    // registration failed :(
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo esc_url( AS_APPSKIT_PRO_PLUGIN_URL . 'assets/js/app-common.js' ); ?>"></script>
    <?php
    // TODO: Include theme-specific JS based on $app_data['theme_id']
    // Example: <script src="<?php echo esc_url( AS_APPSKIT_PRO_PLUGIN_URL . 'templates/app-themes/' . $app_data['theme_id'] . '/script.js' ); ?>"></script>
    ?>
</body>
</html>
<?php
exit; // Crucial: Stop WordPress execution to serve only the app content