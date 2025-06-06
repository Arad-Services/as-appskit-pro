<?php
/**
 * The main plugin class that coordinates other classes.
 *
 * This file is responsible for defining all hooks that run throughout the plugin.
 *
 * @since      1.0.0
 * @package    As_Appskit_Pro
 * @subpackage As_Appskit_Pro/includes
 */
class As_Appskit_Pro {

    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->plugin_name = 'as-appskit-pro';
        $this->version = AS_APPSKIT_PRO_VERSION;

        $this->load_dependencies();
        $this->set_locale();
        $this->define_network_admin_hooks();
        $this->define_site_admin_hooks(); // Hook for site-specific admin menu
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {
        // Core loading mechanism
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'includes/class-as-appskit-pro-loader.php';
        // Internationalization
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'includes/class-as-appskit-pro-i18n.php';
        // Main Admin & Public classes
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'admin/class-as-appskit-pro-admin.php';
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'admin/class-as-appskit-pro-app-manager.php';
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'admin/class-as-appskit-pro-site-admin.php'; // For per-site admin dashboard
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'public/class-as-appskit-pro-public.php';
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'public/class-as-appskit-pro-user-dashboard.php';
        // Feature-specific classes
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'includes/class-as-appskit-pro-pwa.php';
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'includes/class-as-appskit-pro-native.php';
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'includes/class-as-appskit-pro-licensing.php';
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'includes/class-as-appskit-pro-updater.php';
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'includes/class-as-appskit-pro-payments.php';
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'includes/class-as-appskit-pro-support.php';
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'includes/class-as-appskit-pro-integrations.php';
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'includes/class-as-appskit-pro-ai.php';
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'includes/class-as-appskit-pro-analytics.php';
        require_once AS_APPSKIT_PRO_PLUGIN_DIR . 'includes/class-as-appskit-pro-utilities.php';

        $this->loader = new As_Appskit_Pro_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {
        $plugin_i18n = new As_Appskit_Pro_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    /**
     * Register all of the hooks related to the network admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_network_admin_hooks() {
        $plugin_admin = new As_Appskit_Pro_Admin( $this->get_plugin_name(), $this->get_version() );
        $app_manager = new As_Appskit_Pro_App_Manager(); // App Manager is network-wide for CPT

        // Enqueue admin scripts and styles for the network admin pages
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

        // Add custom post type and its meta boxes for AppKits (registered once on init)
        $this->loader->add_action( 'init', $app_manager, 'register_app_cpt' );
        $this->loader->add_action( 'add_meta_boxes', $app_manager, 'add_app_meta_boxes' );
        $this->loader->add_action( 'save_post', $app_manager, 'save_app_meta_data' ); // Saves CPT meta and syncs to global table

        // Handle saving of network-wide settings from our admin pages (using admin-post.php)
        $this->loader->add_action( 'admin_post_as_appskit_pro_save_network_settings', $plugin_admin, 'save_network_settings' );
        $this->loader->add_action( 'admin_post_as_appskit_pro_save_whitelabel_settings', $plugin_admin, 'save_whitelabel_settings' );
        $this->loader->add_action( 'admin_post_as_appskit_pro_save_plan_settings', $plugin_admin, 'save_plan_settings' ); // For managing plans
        $this->loader->add_action( 'admin_post_as_appskit_pro_run_health_check', $plugin_admin, 'run_health_check_action' ); // NEW HEALTH CHECK ACTION

        // Add plugin update checks (self-hosted updates)
        $plugin_updater = new As_Appskit_Pro_Updater( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_filter( 'pre_set_site_transient_update_plugins', $plugin_updater, 'check_for_plugin_updates' );
        $this->loader->add_filter( 'plugins_api', $plugin_updater, 'plugins_api_call', 10, 3 );
        $this->loader->add_filter( 'upgrader_process_complete', $plugin_updater, 'after_update_complete', 10, 2 );

        // Licensing Integration
        $licensing = new As_Appskit_Pro_Licensing();
        $this->loader->add_action( 'admin_init', $licensing, 'register_settings' ); // For network-level license key
        // Further hooks for user subscription validation / feature gating
    }

    /**
     * Register all of the hooks related to the site admin area functionality
     * of the plugin (for individual blogs in a Multisite).
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_site_admin_hooks() {
        // These hooks run on individual site admin dashboards for site-specific features (e.g., business listings)
        if ( is_multisite() ) {
            $site_admin = new As_Appskit_Pro_Site_Admin( $this->get_plugin_name(), $this->get_version() );

            // Add the main plugin menu for individual sites
            $this->loader->add_action( 'admin_menu', $site_admin, 'add_site_admin_menu' ); // NEW SITE ADMIN MENU HOOK

            // Enqueue scripts/styles for the frontend site admin dashboard (`as-appskit-site-admin-dashboard.php`)
            $this->loader->add_action( 'wp_enqueue_scripts', $site_admin, 'enqueue_dashboard_styles' );
            $this->loader->add_action( 'wp_enqueue_scripts', $site_admin, 'enqueue_dashboard_scripts' );

            // Example: Register a custom CPT for business listings on each sub-site if the directory feature is enabled.
            // $this->loader->add_action( 'init', $site_admin, 'register_site_business_listing_cpt' );
        }
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {
        $plugin_public = new As_Appskit_Pro_Public( $this->get_plugin_name(), $this->get_version() );
        $user_dashboard = new As_Appskit_Pro_User_Dashboard( $this->get_plugin_name(), $this->get_version() );
        $pwa_handler = new As_Appskit_Pro_PWA( $this->get_plugin_name(), $this->get_version() );
        $integrations = new As_Appskit_Pro_Integrations();
        $payments = new As_Appskit_Pro_Payments();

        // Enqueue public scripts and styles for general site pages and core app features
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

        // Enqueue scripts/styles specifically for the app builder funnel pages
        $this->loader->add_action( 'wp_enqueue_scripts', $user_dashboard, 'enqueue_onboarding_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $user_dashboard, 'enqueue_onboarding_scripts' );

        // Add PWA manifest and service worker to appropriate pages (especially generated apps)
        $this->loader->add_action( 'wp_head', $pwa_handler, 'add_pwa_meta_tags' ); // Adds manifest link, theme-color
        $this->loader->add_action( 'wp_footer', $pwa_handler, 'add_service_worker_registration' ); // JS to register SW
        $this->loader->add_action( 'template_redirect', $pwa_handler, 'serve_manifest_json' ); // Handles /manifest.json
        $this->loader->add_action( 'template_redirect', $pwa_handler, 'serve_service_worker_js' ); // Handles /service-worker.js
        $this->loader->add_action( 'wp_enqueue_scripts', $pwa_handler, 'enqueue_app_specific_assets' ); // Enqueue app-common.css/js

        // Handle AJAX requests from frontend dashboards (e.g., save app config, trigger build, submit support)
        $this->loader->add_action( 'wp_ajax_as_appskit_pro_save_app_config', $user_dashboard, 'ajax_save_app_config' );
        $this->loader->add_action( 'wp_ajax_nopriv_as_appskit_pro_save_app_config', $user_dashboard, 'ajax_save_app_config' ); // If guests can save drafts
        $this->loader->add_action( 'wp_ajax_as_appskit_pro_trigger_native_build', $user_dashboard, 'ajax_trigger_native_build' );
        $this->loader->add_action( 'wp_ajax_as_appskit_pro_submit_support_ticket', $user_dashboard, 'ajax_submit_support_ticket' );
        $this->loader->add_action( 'wp_ajax_nopriv_as_appskit_pro_submit_support_ticket', $user_dashboard, 'ajax_submit_support_ticket_nopriv' ); // if guests can submit

        // Payment processing hooks
        $this->loader->add_action( 'wp_ajax_as_appskit_pro_process_payment', $payments, 'ajax_process_payment' );
        $this->loader->add_action( 'wp_ajax_nopriv_as_appskit_pro_process_payment', $payments, 'ajax_process_payment_nopriv' ); // For public plan page
        $this->loader->add_action( 'init', $payments, 'handle_webhook_callbacks' ); // For Stripe/PayPal webhooks

        // OneSignal Integration (PWA push notifications)
        $this->loader->add_action( 'wp_head', $integrations, 'add_onesignal_script' );
        // AMP Compatibility
        $this->loader->add_filter( 'amp_post_template_data', $integrations, 'amp_compatibility_filter' );

        // Business Listing integration (inspired by WPMU DEV Directory)
        // If 'Directory' functionality is enabled per-site or globally, register a CPT for listings.
        $this->loader->add_action( 'init', $integrations, 'register_business_listing_cpt_for_apps' );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of WordPress and
     * to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    As_Appskit_Pro_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }
}