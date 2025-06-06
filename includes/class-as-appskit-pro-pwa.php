<?php
/**
 * The PWA core functionality of the plugin.
 *
 * This class defines all code necessary to run the PWA features.
 *
 * @since    1.0.0
 */
class AS_Appskit_Pro_PWA {

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
        $this->version = '1.0.0'; // You can define this more dynamically if needed
    }

    /**
     * Add manifest and meta tags to the <head> section.
     * @since    1.0.0
     */
    public function add_pwa_head_elements() {
        // Enqueue the Web App Manifest
        echo '<link rel="manifest" href="' . esc_url( site_url( '/app-manifest.json' ) ) . '">';

        // Get theme color from plugin settings
        $theme_color = get_option( 'as_appskit_pro_theme_color', '#FF0000' );
        echo '<meta name="theme-color" content="' . esc_attr( $theme_color ) . '">';

        // Get icon paths from plugin settings or default to plugin assets
        $apple_touch_icon = get_option( 'as_appskit_pro_apple_touch_icon_url', plugin_dir_url( __FILE__ ) . '../assets/icons/apple-touch-icon.png' );
        $maskable_icon = get_option( 'as_appskit_pro_maskable_icon_url', plugin_dir_url( __FILE__ ) . '../assets/icons/maskable_icon.png' );
        $monochrome_icon = get_option( 'as_appskit_pro_monochrome_icon_url', plugin_dir_url( __FILE__ ) . '../assets/icons/monochrome_icon.png' );

        // Output Apple Touch Icons, Maskable Icon, and Monochrome Icon links
        echo '<link rel="apple-touch-icon" href="' . esc_url( $apple_touch_icon ) . '">';
        echo '<link rel="maskable-icon" href="' . esc_url( $maskable_icon ) . '">';
        echo '<link rel="monochrome-icon" href="' . esc_url( $monochrome_icon ) . '">';
    }

    /**
     * Register the rewrite rule for the manifest.
     * This method is public so it can be called during plugin activation.
     * @since    1.0.0
     */
    public function add_manifest_rewrite_rule() {
        add_rewrite_rule( 'app-manifest\.json$', 'index.php?as_appskit_pro_manifest=1', 'top' );
    }

    /**
     * Serve the dynamically generated app-manifest.json.
     * @since    1.0.0
     */
    public function serve_manifest() {
        if ( isset( $_GET['as_appskit_pro_manifest'] ) && $_GET['as_appskit_pro_manifest'] == '1' ) {
            header( 'Content-Type: application/manifest+json; charset=UTF-8' );

            // Retrieve settings from plugin options
            $app_name = get_option( 'as_appskit_pro_app_name', 'as-appskit-pro App' );
            $short_name = get_option( 'as_appskit_pro_short_name', 'AppsKit Pro' );
            $description = get_option( 'as_appskit_pro_description', 'Your ultimate SaaS App Builder for WordPress by Arad Services.' );
            $start_url = get_option( 'as_appskit_pro_start_url', '/' );
            $display_mode = get_option( 'as_appskit_pro_display_mode', 'standalone' );
            $background_color = get_option( 'as_appskit_pro_background_color', '#FFFFFF' );
            $theme_color = get_option( 'as_appskit_pro_theme_color', '#FF0000' );
            $orientation = get_option( 'as_appskit_pro_orientation', 'any' );
            $install_prompt_enabled = get_option( 'as_appskit_pro_install_prompt_enabled', 'yes' );


            // Define icon URLs based on user uploads or plugin defaults
            $icon_192 = get_option( 'as_appskit_pro_icon_192_url', plugin_dir_url( __FILE__ ) . '../assets/icons/android-chrome-192x192.png' );
            $icon_512 = get_option( 'as_appskit_pro_icon_512_url', plugin_dir_url( __FILE__ ) . '../assets/icons/android-chrome-512x512.png' );
            $maskable_icon = get_option( 'as_appskit_pro_maskable_icon_url', plugin_dir_url( __FILE__ ) . '../assets/icons/maskable_icon.png' );
            $monochrome_icon = get_option( 'as_appskit_pro_monochrome_icon_url', plugin_dir_url( __FILE__ ) . '../assets/icons/monochrome_icon.png' );

            $manifest_data = [
                "name" => $app_name,
                "short_name" => $short_name,
                "description" => $description,
                "start_url" => $start_url,
                "display" => $display_mode,
                "background_color" => $background_color,
                "theme_color" => $theme_color,
                "icons" => [
                    [
                        "src" => esc_url( $icon_192 ),
                        "sizes" => "192x192",
                        "type" => "image/png",
                        "purpose" => "any"
                    ],
                    [
                        "src" => esc_url( $icon_512 ),
                        "sizes" => "512x512",
                        "type" => "image/png",
                        "purpose" => "any"
                    ],
                    [
                        "src" => esc_url( $maskable_icon ),
                        "sizes" => "512x512",
                        "type" => "image/png",
                        "purpose" => "maskable"
                    ],
                    [
                        "src" => esc_url( $monochrome_icon ),
                        "sizes" => "512x512",
                        "type" => "image/png",
                        "purpose" => "monochrome"
                    ]
                ],
                "screenshots" => [], // Future enhancement: allow users to upload screenshots
                "orientation" => $orientation,
                // The prefer_related_applications field is about suggesting native apps, not controlling A2HS prompt
                // A2HS prompt is largely controlled by browser heuristics and manifest validity
                // Setting this to false prevents browser from trying to install related apps
                "prefer_related_applications" => ( 'yes' === $install_prompt_enabled ) ? false : true // Typically 'false' to encourage PWA install
            ];

            echo json_encode( $manifest_data );
            exit; // Stop WordPress execution after serving the JSON
        }
    }

    /**
     * Register the service worker file.
     * @since    1.0.0
     */
    public function register_service_worker() {
        // Only register service worker for frontend
        if ( ! is_admin() && ! is_customize_preview() && ! is_preview() ) {

            // Get offline usage status
            $offline_usage_enabled = get_option( 'as_appskit_pro_offline_usage_enabled', 'yes' );

            wp_enqueue_script(
                'as-appskit-pro-service-worker-registration',
                plugin_dir_url( __FILE__ ) . '../assets/js/service-worker-registration.js',
                array(),
                $this->version,
                true // Enqueue in the footer
            );

            // Pass data to the service worker registration script
            wp_localize_script(
                'as-appskit-pro-service-worker-registration',
                'asAppskitPro',
                array(
                    'serviceWorkerUrl'      => plugin_dir_url( __FILE__ ) . '../assets/js/service-worker.js',
                    'offlinePageUrl'        => get_permalink( get_option( 'as_appskit_pro_offline_page_id', 0 ) ) ?: site_url( '/offline-fallback/' ),
                    'offlineUsageEnabled'   => ( 'yes' === $offline_usage_enabled ), // Pass boolean
                    'homeUrl'               => home_url('/'), // Pass home URL for SW
                    'cacheName'             => 'as-appskit-pro-cache-v' . $this->version, // Pass dynamic cache name
                )
            );
        }
    }

    /**
     * Add a rewrite rule for a custom offline fallback page.
     * This is useful if no custom offline page is selected, to serve a default one.
     * @since    1.0.0
     */
    public function add_offline_fallback_rewrite_rule() {
        add_rewrite_rule( 'offline-fallback/?$', 'index.php?as_appskit_pro_offline_fallback=1', 'top' );
    }

    /**
     * Serve a default offline fallback page if no custom page is set.
     * @since    1.0.0
     */
    public function serve_offline_fallback() {
        if ( isset( $_GET['as_appskit_pro_offline_fallback'] ) && $_GET['as_appskit_pro_offline_fallback'] == '1' ) {
            status_header( 200 ); // Ensure 200 OK status
            nocache_headers();
            // Load a simple offline template. You'll create this file.
            include plugin_dir_path( __FILE__ ) . 'offline-fallback-template.php';
            exit;
        }
    }

    /**
     * Handles the Pull Down Refresh functionality.
     * @since 1.0.0
     */
    public function handle_pull_to_refresh() {
        $pull_to_refresh_enabled = get_option( 'as_appskit_pro_pull_to_refresh_enabled', 'yes' );

        if ( 'yes' === $pull_to_refresh_enabled && ! is_admin() && ! is_customize_preview() ) {
            wp_enqueue_script(
                'as-appskit-pro-pull-to-refresh',
                plugin_dir_url( __FILE__ ) . '../assets/js/pull-to-refresh.js', // This will be a new JS file
                array(),
                $this->version,
                true
            );
        }
    }

    /**
     * Run the PWA actions and filters.
     * @since    1.0.0
     */
    public function run() {
        // Add PWA meta tags and manifest link to the head
        add_action( 'wp_head', array( $this, 'add_pwa_head_elements' ) );

        // Register rewrite rule for the manifest
        add_action( 'init', array( $this, 'add_manifest_rewrite_rule' ) );

        // Handle the manifest request
        add_action( 'template_redirect', array( $this, 'serve_manifest' ) );

        // Register and localize the service worker registration script
        add_action( 'wp_enqueue_scripts', array( $this, 'register_service_worker' ) );

        // Add rewrite rule and handler for generic offline fallback page
        add_action( 'init', array( $this, 'add_offline_fallback_rewrite_rule' ) );
        add_action( 'template_redirect', array( $this, 'serve_offline_fallback' ) );

        // Handle Pull Down Refresh
        add_action( 'wp_enqueue_scripts', array( $this, 'handle_pull_to_refresh' ) );
    }
}