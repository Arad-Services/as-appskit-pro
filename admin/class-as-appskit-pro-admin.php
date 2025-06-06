<?php
/**
 * The site admin-specific functionality of the plugin.
 * Handles settings and features for individual sites in a Multisite network.
 *
 * @since      1.0.0
 * @package    As_Appskit_Pro
 * @subpackage As_Appskit_Pro/admin
 */
class As_Appskit_Pro_Site_Admin {

    private $plugin_name;
    private $version;

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Enqueue dashboard-specific styles for frontend site admin dashboard.
     *
     * @since 1.0.0
     * @param string $hook_suffix The current admin page hook.
     */
    public function enqueue_dashboard_styles( $hook_suffix ) {
        // Enqueue styles only on our frontend site admin dashboard page
        if ( is_page( 'as-appskit-site-admin-dashboard' ) ) {
            wp_enqueue_style( $this->plugin_name . '-site-admin-dashboard-style', AS_APPSKIT_PRO_PLUGIN_URL . 'assets/css/admin-style.css', array(), $this->version, 'all' );
            wp_enqueue_style( 'bootstrap-site-admin-css', 'https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css', array(), '5.3.0', 'all' );
        }
    }

    /**
     * Enqueue dashboard-specific scripts for frontend site admin dashboard.
     *
     * @since 1.0.0
     * @param string $hook_suffix The current admin page hook.
     */
    public function enqueue_dashboard_scripts( $hook_suffix ) {
        // Enqueue scripts only on our frontend site admin dashboard page
        if ( is_page( 'as-appskit-site-admin-dashboard' ) ) {
            wp_enqueue_script( $this->plugin_name . '-site-admin-dashboard-script', AS_APPSKIT_PRO_PLUGIN_URL . 'assets/js/admin-script.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );
            wp_enqueue_style( 'wp-color-picker' ); // Needed if color picker is used on this frontend dashboard
            wp_enqueue_media(); // Needed if media uploader is used on this frontend dashboard
            wp_enqueue_script( 'bootstrap-site-admin-js', 'https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0', true );
        }
    }

    /**
     * Add the main plugin menu for individual sites in the WordPress admin.
     * This will allow site-specific settings or access to app creation for this site.
     *
     * @since 4.0.1
     */
    public function add_site_admin_menu() {
        add_menu_page(
            __( 'AppKit Pro', 'as-appskit-pro' ),
            __( 'AppKit Pro', 'as-appskit-pro' ),
            'manage_options', // Capability for site admin
            'as-appskit-pro-site-settings',
            array( $this, 'display_site_settings_page' ),
            'dashicons-tablet', // Icon
            6 // Position
        );

        // Submenu for managing business listings if the feature is enabled for this site's plan
        add_submenu_page(
            'as-appskit-pro-site-settings',
            __( 'Business Listings', 'as-appskit-pro' ),
            __( 'Listings', 'as-appskit-pro' ),
            'edit_posts', // or a custom capability for business listings
            'edit.php?post_type=as_appskit_business_listing', // Assuming a CPT for listings
            null // WordPress will handle the CPT listing page
        );
        // Link to the frontend app editor dashboard (if this site's users create apps directly from here)
        add_submenu_page(
            'as-appskit-pro-site-settings',
            __( 'My App Editor', 'as-appskit-pro' ),
            __( 'My App Editor', 'as-appskit-pro' ),
            'manage_options', // Or a custom capability
            home_url( '/as-appskit-user-dashboard' ), // Direct link to frontend dashboard
            '', // No callback, just redirect
            99 // High position
        );
    }

    /**
     * Display the site-specific settings page for the plugin.
     *
     * @since 4.0.1
     */
    public function display_site_settings_page() {
        include_once AS_APPSKIT_PRO_PLUGIN_DIR . 'admin/views/site-settings.php';
    }
}