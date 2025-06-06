<?php
/**
 * The frontend routing functionality of the plugin.
 *
 * This class handles custom rewrite rules for dedicated URLs like
 * /as-appskit-admin and /as-appskit-dashboard.
 * Note: Individual user apps (e.g., /user-app-slug/) are now standard Multisite sub-site URLs
 * and don't need a specific rewrite rule from this plugin, as WordPress handles them.
 *
 * @since    1.0.0
 */
class AS_Appskit_Pro_Frontend_Routes {

    /**
     * The ID of this plugin.
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        $this->plugin_name = 'as-appskit-pro';
        $this->version = '1.0.0';
    }

    /**
     * Add custom rewrite rules for frontend dashboards.
     * Individual user apps will be at their own sub-site URLs managed by WordPress.
     * @since 1.0.0
     */
    public function add_custom_rewrite_rules() {
        // Rule for the Site Admin Dashboard (frontend)
        add_rewrite_rule(
            '^as-appskit-admin/?$',
            'index.php?as_appskit_pro_frontend_route=admin_dashboard',
            'top'
        );

        // Rule for the App Dashboard Editor (frontend)
        add_rewrite_rule(
            '^as-appskit-dashboard/?$',
            'index.php?as_appskit_pro_frontend_route=app_editor_dashboard',
            'top'
        );

        // Make sure WordPress recognizes the new query vars
        add_filter( 'query_vars', array( $this, 'add_custom_query_vars' ) );
    }

    /**
     * Add custom query variables so WordPress processes them.
     * @since 1.0.0
     * @param array $vars The array of query variables.
     * @return array The filtered array.
     */
    public function add_custom_query_vars( $vars ) {
        $vars[] = 'as_appskit_pro_frontend_route';
        // 'app_slug' is no longer needed here as user apps are direct sub-site URLs
        return $vars;
    }

    /**
     * Intercept template loading to serve custom content for our routes.
     * @since 1.0.0
     */
    public function template_redirect_handler() {
        $route = get_query_var( 'as_appskit_pro_frontend_route' );

        if ( $route ) {
            // Prevent caching for these dynamic pages
            nocache_headers();

            // Set appropriate status header (e.g., 200 OK)
            status_header( 200 );

            // Load a generic frontend dashboard template which will then load specific content
            add_filter( 'template_include', function( $template ) use ( $route ) {
                $template_path = plugin_dir_path( __FILE__ ) . '../templates/frontend-dashboard-template.php';

                // Pass the route to the template for conditional content loading
                set_query_var( 'as_appskit_pro_current_route', $route );

                return $template_path;
            });
        }
    }

    /**
     * Run the frontend routing actions.
     * @since    1.0.0
     */
    public function run() {
        add_action( 'init', array( $this, 'add_custom_rewrite_rules' ) );
        // The 'query_vars' filter is hooked inside add_custom_rewrite_rules()
        add_action( 'template_redirect', array( $this, 'template_redirect_handler' ) );
    }
}