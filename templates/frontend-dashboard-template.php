<?php
/**
 * Generic Frontend Dashboard Template for as-appskit-pro.
 * This template is used by as_appskit_pro_frontend_routes to wrap custom content
 * for /as-appskit-admin and /as-appskit-dashboard.
 *
 * @since 1.0.0
 */

// Get the route and slug passed by the routing handler
$route = get_query_var( 'as_appskit_pro_current_route' );
// app_slug is no longer passed to this wrapper template for user apps

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php
        if ( $route === 'admin_dashboard' ) {
            esc_html_e( 'as-appskit-pro Admin Dashboard', 'as-appskit-pro' );
        } elseif ( $route === 'app_editor_dashboard' ) {
            esc_html_e( 'as-appskit-pro App Editor', 'as-appskit-pro' );
        } else {
            esc_html_e( 'as-appskit-pro', 'as-appskit-pro' );
        }
        ?>
    </title>
    <?php wp_head(); // Essential for scripts and styles ?>
    <!-- Feather Icons for a modern look in dashboards -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body <?php body_class( 'as-appskit-pro-frontend-dashboard-body' ); ?>>

    <?php
    // Load the specific partial based on the route
    if ( $route === 'admin_dashboard' ) {
        include plugin_dir_path( __FILE__ ) . '../admin/partials/as-appskit-pro-frontend-admin-dashboard.php';
    } elseif ( $route === 'app_editor_dashboard' ) {
        include plugin_dir_path( __FILE__ ) . '../admin/partials/as-appskit-pro-app-editor-dashboard.php';
    } else {
        // Fallback or 404 for unknown routes if wp_head() is still loaded by this.
        // In a true Multisite context, if route is not one of ours, WP will handle it normally.
        status_header( 404 );
        nocache_headers();
        include( get_query_template( '404' ) );
    }
    ?>

    <?php wp_footer(); // Essential for scripts in footer ?>
    <script>
        // Initialize Feather Icons
        feather.replace();
    </script>
</body>
</html>