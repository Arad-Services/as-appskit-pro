<?php
/**
 * Handles WordPress Multisite specific operations for as-appskit-pro.
 * This includes creating new sub-sites (apps) and applying site templates.
 *
 * @since    1.0.0
 */
class AS_Appskit_Pro_Multisite_Helper {

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
     * Instance of AS_Appskit_Pro_App_Themes.
     * @access   private
     * @var      AS_Appskit_Pro_App_Themes    $app_themes
     */
    private $app_themes;


    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        $this->plugin_name = 'as-appskit-pro';
        $this->version = '1.0.0';
        $this->app_themes = new AS_Appskit_Pro_App_Themes(); // Initialize App Themes here
    }

    /**
     * Create a new WordPress sub-site (app).
     * This function is intended to be called during the onboarding process (Step 4).
     *
     * @since 1.0.0
     * @param string $site_slug The slug for the new sub-site (e.g., 'my-awesome-app').
     * @param string $site_title The title for the new sub-site.
     * @param int    $user_id The ID of the user who owns this app/site.
     * @param string $template_id The ID of the app template to apply (e.g., 'template-1').
     * @param string $layout_id The ID of the app layout to apply (e.g., 'layout-1').
     * @return int|WP_Error Blog ID on success, WP_Error on failure.
     */
    public function create_new_app_site( $site_slug, $site_title, $user_id, $template_id, $layout_id ) {
        if ( ! is_multisite() ) {
            return new WP_Error( 'multisite_not_enabled', __( 'WordPress Multisite is not enabled.', 'as-appskit-pro' ) );
        }

        // Validate slug
        $site_slug = sanitize_title( $site_slug );
        if ( empty( $site_slug ) ) {
            return new WP_Error( 'empty_slug', __( 'Site slug cannot be empty.', 'as-appskit-pro' ) );
        }

        // Check if site already exists. In subdirectory installs, this checks if the path is taken.
        // It's good to call get_site_by_path directly on the network ID.
        if ( get_site_by_path( get_network()->id, '/' . $site_slug . '/' ) ) {
             return new WP_Error( 'site_exists', __( 'A site with this path already exists. Please choose a different App URL Slug.', 'as-appskit-pro' ) );
        }

        // Create the new blog (sub-site)
        $blog_id = wpmu_create_blog(
            get_network()->domain, // Network domain (e.g., 'localhost' or your actual domain)
            '/' . $site_slug . '/', // Path for subdirectory install (e.g., '/sitetest03/my-app/')
            $site_title,            // Site title
            $user_id,               // User ID
            array(                  // Meta data to store with the blog
                'public' => 1,
                'as_appskit_pro_app_layout'    => $layout_id,
                'as_appskit_pro_app_template'  => $template_id,
                // Add more app-specific initial settings here
            )
        );

        if ( is_wp_error( $blog_id ) ) {
            return $blog_id;
        }

        // Switch to the new blog to apply settings and templates
        switch_to_blog( $blog_id );

        // Apply selected template
        $this->app_themes->apply_app_template_to_site( $template_id, $layout_id );

        // Restore context to the main blog
        restore_current_blog();

        return $blog_id;
    }

    /**
     * Run the multisite helper actions.
     * @since    1.0.0
     */
    public function run() {
        // No direct actions for now, mainly public methods used by App Manager.
        // If you need to hook into new site creation or other multisite events, add them here.
        // e.g., add_action( 'wpmu_new_blog', array( $this, 'on_new_blog_created' ), 10, 6 );
    }
}