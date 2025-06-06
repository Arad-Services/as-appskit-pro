<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's network activation.
 *
 * @since      1.0.0
 * @package    As_Appskit_Pro
 * @subpackage As_Appskit_Pro/includes
 */
class As_Appskit_Pro_Activator {

    /**
     * Run the network-wide activation logic.
     *
     * This method is called when the plugin is network-activated. It handles global
     * database table creation, setting up key pages on the main site, and flushing
     * rewrite rules for the entire network.
     *
     * @since    1.0.0
     * @param    bool $network_wide True if plugin is network activated.
     */
    public static function network_activate( $network_wide = true ) {
        global $wpdb;

        if ( $network_wide ) {
            // This code runs when the plugin is network activated.
            // Loop through all existing blogs and activate for each.
            $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
            foreach ( $blog_ids as $blog_id ) {
                switch_to_blog( $blog_id );
                self::activate_for_site(); // Run site-specific activation
                restore_current_blog();
            }
        } else {
            // This code runs when the plugin is activated on a single site,
            // even if Multisite is enabled but the plugin is not network-activated.
            self::activate_for_site();
        }

        // --- Network-wide operations (run only once for the whole network) ---
        // Create custom global database tables (e.g., for apps data, plans, subscriptions, global support tickets)
        self::create_global_db_tables();

        // Create core funnel pages on the main site of the network (only if they don't exist)
        // These are global pages for the SaaS funnel and dashboards.
        self::create_global_funnel_pages(); // This call should now be fine

        // Flush rewrite rules for the entire network to ensure new URLs work
        flush_rewrite_rules();
    }

    /**
     * Site-specific activation logic (runs for each blog in a multisite network or for a single site).
     *
     * This method can be used to set up site-specific options or tables if your plugin
     * has features that vary per sub-site. For a network-centric SaaS app builder,
     * this might be minimal, primarily setting default options for new blogs.
     *
     * @since 1.0.0
     */
    protected static function activate_for_site() {
        // Example: Set default PWA options for a new site if it ever creates an app.
        // update_option( 'as_appskit_pro_site_pwa_enabled_default', true );
        // update_option( 'as_appskit_pro_site_default_offline_page', '' );
        // You might register site-specific cron jobs here too.
    }

    /**
     * Create global database tables for network-wide data.
     *
     * These tables are essential for storing data that pertains to the entire SaaS platform,
     * such as app configurations, user subscriptions, and support tickets, independent of individual blogs.
     *
     * @since 1.0.0
     */
    protected static function create_global_db_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' ); // Required for dbDelta()

        // Table for storing app builder user subscriptions/plans (network-wide)
        $table_name_plans = $wpdb->base_prefix . 'as_appskit_pro_subscriptions';
        $sql_plans = "CREATE TABLE $table_name_plans (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            user_id bigint(20) unsigned NOT NULL,
            plan_slug varchar(255) NOT NULL, /* e.g., 'pro', 'premium', 'business-pro-plus', 'platform' */
            status varchar(50) NOT NULL, /* active, cancelled, expired, pending_cancellation */
            start_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            end_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            payment_gateway varchar(50) DEFAULT NULL, /* 'stripe', 'paypal' */
            payment_id varchar(255) DEFAULT NULL, /* Transaction ID or subscription ID from gateway */
            last_payment_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            is_yearly tinyint(1) DEFAULT 0 NOT NULL, /* 0 for monthly, 1 for yearly */
            PRIMARY KEY (id),
            KEY user_id (user_id),
            KEY plan_slug (plan_slug),
            KEY status (status)
        ) $charset_collate;";
        dbDelta( $sql_plans );

        // Table for storing app data (network-wide, primary source of truth for app configs)
        // Linked to `as_appskit_app` CPT on the main site for WP-admin UI.
        $table_name_apps = $wpdb->base_prefix . 'as_appskit_pro_apps';
        $sql_apps = "CREATE TABLE $table_name_apps (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            app_post_id bigint(20) unsigned NOT NULL, /* Link to as_appskit_app CPT on main site (Blog ID 1) */
            user_id bigint(20) unsigned NOT NULL, /* Owner of the app (WordPress user ID) */
            app_slug varchar(255) NOT NULL UNIQUE, /* Unique identifier for app URL (e.g., 'my-restaurant-app') */
            app_name varchar(255) NOT NULL,
            theme_id varchar(255) DEFAULT NULL, /* ID of the selected theme (e.g., 'theme-business-1') */
            layout_id varchar(255) DEFAULT NULL, /* ID of the selected layout (e.g., 'layout-tab-bar') */
            settings longtext, /* JSON or serialized array of ALL app settings (PWA, features, module configs) */
            status varchar(50) DEFAULT 'draft' NOT NULL, /* draft, pending_review, published, suspended, archived */
            build_status varchar(50) DEFAULT 'none' NOT NULL, /* none, pending, building, success, failed */
            last_published datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            last_updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY (id),
            KEY app_post_id (app_post_id),
            KEY user_id (user_id),
            UNIQUE KEY app_slug (app_slug) /* Ensure app slugs are unique across the network */
        ) $charset_collate;";
        dbDelta( $sql_apps );

        // Table for support tickets (network-wide, accessible by platform admin and users)
        $table_name_tickets = $wpdb->base_prefix . 'as_appskit_pro_tickets';
        $sql_tickets = "CREATE TABLE $table_name_tickets (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            user_id bigint(20) unsigned NOT NULL, /* Who submitted the ticket */
            app_id bigint(20) unsigned DEFAULT NULL, /* Optional: link to a specific app (from as_appskit_pro_apps.id) */
            subject varchar(255) NOT NULL,
            message longtext NOT NULL,
            status varchar(50) DEFAULT 'open' NOT NULL, /* open, closed, awaiting_reply, pending_admin */
            priority varchar(50) DEFAULT 'normal' NOT NULL, /* low, normal, high, urgent */
            created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            updated_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY (id),
            KEY user_id (user_id),
            KEY status (status),
            KEY updated_at (updated_at)
        ) $charset_collate;";
        dbDelta( $sql_tickets );

        // Table for ticket replies (network-wide)
        $table_name_replies = $wpdb->base_prefix . 'as_appskit_pro_ticket_replies';
        $sql_replies = "CREATE TABLE $table_name_replies (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            ticket_id bigint(20) unsigned NOT NULL, /* Link to as_appskit_pro_tickets.id */
            user_id bigint(20) unsigned NOT NULL, /* Who replied (could be platform admin or user) */
            message longtext NOT NULL,
            created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY (id),
            KEY ticket_id (ticket_id),
            KEY user_id (user_id)
        ) $charset_collate;";
        dbDelta( $sql_replies );

        // Store global plugin options (e.g., white-labeling, API keys for payment gateways, default PWA settings)
        // These are stored as site options on the main site (blog ID 1)
        add_site_option( 'as_appskit_pro_whitelabel_brand_name', 'as-appskit-pro' );
        add_site_option( 'as_appskit_pro_whitelabel_developer_url', 'https://arad-services.com' );
        add_site_option( 'as_appskit_pro_whitelabel_logo_url', AS_APPSKIT_PRO_PLUGIN_URL . 'assets/img/default-logo.png' );
        add_site_option( 'as_appskit_pro_onesignal_app_id', '' );
        add_site_option( 'as_appskit_pro_onesignal_api_key', '' );
        add_site_option( 'as_appskit_pro_stripe_secret_key', '' );
        add_site_option( 'as_appskit_pro_stripe_publishable_key', '' );
        // Define default plan features and pricing (can be modified via admin UI)
        add_site_option( 'as_appskit_pro_plans_config', self::get_default_plans_config() );
    }

    /**
     * Define default pricing plans and their features.
     * This acts as the initial configuration for the licensing system.
     *
     * @since 4.0.1
     * @return array Default plans configuration.
     */
    protected static function get_default_plans_config() {
        return array(
            'free' => array(
                'name' => __( 'Free Plan', 'as-appskit-pro' ),
                'features' => array(
                    'pwa_install_prompt', 'offline_usage_basic', 'basic_navigation_bar', 'scroll_progress', 'pull_down_refresh',
                    'dark_mode', 'shake_to_refresh', 'page_loader', 'toast_messages', 'inactive_blur',
                    'smooth_page_transitions', 'vibrations', 'idle_detection', 'screen_wake_lock',
                    'biometric_authentication', 'background_sync', 'content_indexing', 'persistent_storage', 'push_notifications', // Added features
                    'pwa_app_icon_upload', 'pwa_splash_background', 'pwa_add_to_home_screen_notice',
                    'pwa_aggressive_caching', 'pwa_offline_pages_cached', 'pwa_theme_color_meta',
                    'pwa_edit_app_name', 'pwa_set_start_page', 'pwa_high_quality_splash',
                    'ai_agents_content_updates', 'improved_sw_update', 'pwa_default_orientation', 'pwa_manifest_theme_color_prop',
                    'onesignal_integration', 'wordpress_multisite_compat', 'utm_tracking_addon', // Corrected OneSignal, UTM
                    'apple_touch_icons', 'wordpress_subfolder_compat', 'pwa_display_prop',
                    'maskable_icons', 'monochrome_icon',
                    'swipe_navigation', 'wp_hide_security_enhancer_compat', 'disable_scrollbar', 'amp_support_full',
                    'create_app_using_website_url', 'caching_strategy_assets', 'support_ticket_system',
                    'cache_expire_option', 'service_worker_dev', 'app_banners_home_screen', 'web_app_manifest_file',
                    'offline_support_full', 'full_screen_splash_screen_custom', 'dashboard_stats_full',
                    'app_icon_uploading', 'background_color_splash', 'app_short_name_edit',
                    'set_start_page_easy', 'set_device_orientation_easy', 'google_lighthouse_tested',
                    'native_wp_cpt_fields_taxonomies_comments_auth', 'full_pwa_native_sync',
                    'firebase_support', 'bootstrap_themes_base', 'languages_all_types',
                    'cordova_support', 'voltbuilder_support', 'app_themes_10_templates',
                    'pos_system_restaurant_base', 'customizable_api_hooks', 'instant_apk_creator_free',
                ),
                'price_monthly' => 0,
                'price_yearly' => 0,
                'is_addon' => false,
                'max_apps' => 1, // Free plan might be limited to 1 app
            ),
            'pro' => array(
                'name' => __( 'PRO Plan', 'as-appskit-pro' ),
                'features' => array(
                    'all_free_features', // Inherits all free features
                    'admin_dashboard_limited_privileges', 'custom_call_to_action',
                    'android_apk_generator', 'ios_app_generator', 'data_analytics_pro',
                    'custom_pre_loader', 'app_shortcuts', 'qr_code_generator',
                ),
                'price_monthly' => 49,
                'price_yearly' => 499,
                'is_addon' => false,
                'max_apps' => -1, // Unlimited apps
            ),
            'premium' => array(
                'name' => __( 'Premium Plan', 'as-appskit-pro' ),
                'features' => array(
                    'all_pro_features', // Inherits all PRO features
                    'expanded_user_dashboard_functionality', 'enhanced_cta_pwa_native',
                    'loading_icon_library', 'data_analytics_advanced', 'pull_to_refresh_enhanced',
                    'scroll_progress_bar_enhanced', 'pwa_to_apk_conversion', 'offline_forms',
                    'custom_navigation_bar', 'quick_action', 'multilingual_compatibility',
                    'buddypress_integration', 'rewards_on_install', 'qr_code_for_app',
                    'ios_publish_option', 'whitelabel_lite', // Basic whitelabel for app branding
                ),
                'price_monthly' => 79,
                'price_yearly' => 799,
                'is_addon' => false,
                'max_apps' => -1,
            ),
            'business-app-pro-plus' => array(
                'name' => __( 'Business App Pro+ Plan', 'as-appskit-pro' ),
                'features' => array(
                    'all_premium_features', // Inherits all Premium features
                    // Action Points Modules
                    'module_coupons', 'module_dollar_rewards', 'module_submit_receipt',
                    'module_gps_coupons', 'module_point_rewards', 'module_referral_rewards',
                    'module_scratch_and_win',
                    // Different Modules for Creating Apps
                    'module_appointment_booking', 'module_time_slot_booking', 'module_container_apps',
                    'module_car_booking', 'module_employee_schedules',
                    // Specific Business Modules
                    'module_food_ordering_system', 'module_clientele_feature',
                    'module_event_ticketing', 'module_fan_page', 'module_shopping_cart',
                    // Other Advanced Features
                    'module_smart_reviews', 'module_image_gallery', 'module_yellow_pages',
                ),
                'price_monthly' => 129, // Example price
                'price_yearly' => 1299, // Example price
                'is_addon' => false,
                'max_apps' => -1,
            ),
            'platform-edition' => array(
                'name' => __( 'Platform Edition', 'as-appskit-pro' ),
                'features' => array(
                    'all_business_app_pro_plus_features', // Inherits all Business App Pro+ features
                    'whitelabel_full_platform_branding', // Full re-branding of the app builder platform
                    'user_self_registration', // Enable self-registration for app builders
                    'resellers_wl_panel', // Reseller white-label panel
                ),
                'price_monthly' => 249, // Example price
                'price_yearly' => 2499, // Example price
                'is_addon' => false,
                'max_apps' => -1,
            ),
            // Define add-ons separately if they are not part of a plan but buyable extras
            'addon_pos_system_restaurant' => array(
                'name' => __( 'POS System for Restaurants Add-On', 'as-appskit-pro' ),
                'features' => array( 'pos_system_restaurant_full' ),
                'price_monthly' => 29, // Example addon price
                'is_addon' => true,
            ),
            // ... other addons
        );
    }

    /**
     * Create core funnel pages on the main site (blog ID 1).
     *
     * @since 1.0.0
     */
    public static function create_global_funnel_pages() { // Changed to public static
        $main_site_id = get_main_site_id(); // Use get_main_site_id() for robustness
        if ( get_current_blog_id() !== $main_site_id ) {
            switch_to_blog( $main_site_id );
        }

        $pages = array(
            'create-new-appkit'           => 'Create New AppKit',
            'new-appkit-step-1'           => 'Choose App Template',
            'new-appkit-step-2'           => 'Choose App Layout',
            'new-appkit-step-3'           => 'Add & Edit App Modules',
            'new-appskit-step-4'          => 'Publish Your New App',
            'new-appkit-package-plans'    => 'AppKit Pro Package Plans',
            'as-appskit-site-admin-dashboard' => 'as-appskit-pro Site Admin Dashboard',
            'as-appskit-user-dashboard'   => 'as-appskit-pro User Dashboard',
        );

        foreach ( $pages as $slug => $title ) {
            if ( ! get_page_by_path( $slug ) ) {
                wp_insert_post( array(
                    'post_title'    => $title,
                    'post_name'     => $slug,
                    'post_status'   => 'publish',
                    'post_type'     => 'page',
                    'post_content'  => sprintf( '', $slug ), // Unique identifier for plugin
                    'comment_status' => 'closed',
                    'ping_status'    => 'closed',
                ) );
            }
        }

        if ( get_current_blog_id() !== $main_site_id ) {
            restore_current_blog();
        }
    }

    /**
     * Handle new blog creation in Multisite to ensure plugin compatibility.
     * This hook is fired after a new blog is created.
     *
     * @since 4.0.1
     * @param int $blog_id The ID of the new blog.
     * @param int $user_id The ID of the user creating the new blog.
     * @param array $domain The domain for the new blog.
     * @param string $path The path for the new blog.
     * @param int $site_id The ID of the site.
     * @param array $meta Meta data.
     */
    public static function on_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
        if ( is_plugin_active_for_network( plugin_basename( AS_APPSKIT_PRO_PLUGIN_DIR . 'as-appskit-pro.php' ) ) ) {
            switch_to_blog( $blog_id );
            self::activate_for_site(); // Run site-specific activation for the new blog
            restore_current_blog();
        }
    }
}