<?php
/**
 * Manages the licensing and feature plans for as-appskit-pro.
 * Defines which features are available for each plan level.
 *
 * @since    1.0.0
 */
class AS_Appskit_Pro_Licensing_Plans {

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
     * Stores the defined app plans and their features.
     * @access   private
     * @var      array    $plans
     */
    private $plans;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        $this->plugin_name = 'as-appskit-pro';
        $this->version = '1.0.0';
        $this->define_plans();
    }

    /**
     * Defines the available plans and their features.
     * @since 1.0.0
     */
    private function define_plans() {
        // --- Define base modules for each tier ---
        $free_plan_modules = array( 'text_block', 'image_gallery', 'contact_form' );
        $pro_plan_modules_base = array( 'call_to_action', 'data_analytics', 'pre_loader', 'app_shortcuts', 'qr_code_generator' );
        $premium_plan_modules_base = array( 'navigation_bar', 'multilingual_compatibility', 'buddypress_integration' );
        $business_pro_plus_modules_base = array(
            'coupons', 'dollar_rewards', 'submit_receipt', 'gps_coupons', 'point_rewards', 'referral_rewards', 'scratch_and_win',
            'appointment_booking', 'time_slot_booking', 'container_app_modules', 'car_booking', 'employee_schedules',
            'food_ordering_system', 'clientele_feature', 'event_ticketing', 'fan_page', 'shopping_cart',
            'smart_reviews', 'image_gallery_pro', 'yellow_pages'
        );

        // --- Define base features for each tier ---
        $free_plan_features = array(
            'swipe_navigation', 'disable_scrollbar', 'amp_support', 'multisite_support',
            'utm_tracking', 'onesignal_support', 'change_start_url',
            'caching_strategy', 'service_worker', 'app_banners', 'web_app_manifest',
            'offline_support', 'full_screen_splash_screen', 'dashboard_stats',
            'app_icon_upload', 'splash_background_color', 'app_short_name',
            'device_orientation', 'google_lighthouse_tested', 'native_wordpress_support',
            'pwa_sync_support', 'support_ticket_system', 'cache_expire_option'
        );
        $pro_plan_features_base = array(
            'call_to_action_enabled', 'data_analytics_enabled', 'pre_loader_enabled',
            'app_shortcuts_enabled', 'qr_code_generator_enabled'
        );
        $premium_plan_features_base = array(
            'enhanced_call_to_action', 'loading_icon_library', 'advanced_data_analytics',
            'enhanced_pull_to_refresh', 'scroll_progress_bar', 'pwa_to_apk_conversion',
            'offline_forms', 'rewards_on_install', 'whitelabel_enabled'
        );
        $business_pro_plus_features_base = array(
            'action_points_system', 'multiple_app_modules', 'food_ordering_full',
            'clientele_management', 'event_ticketing_full', 'fan_page_enhancements',
            'shopping_cart_full', 'advanced_reviews', 'enhanced_image_gallery', 'local_directories'
        );


        $this->plans = array(
            'free' => array(
                'name'        => __( 'Free Plan', 'as-appskit-pro' ),
                'description' => __( 'Basic features for simple apps and testing.', 'as-appskit-pro' ),
                'price'       => 0.00,
                'modules'     => $free_plan_modules,
                'features'    => $free_plan_features,
                'publishing_options' => array( 'pwa' ),
            ),
            'pro' => array(
                'name'        => __( 'PRO Plan', 'as-appskit-pro' ),
                'description' => __( 'Advanced features for growing businesses, including native app generation.', 'as-appskit-pro' ),
                'price'       => 29.99, // Example price
                // Merge free modules with pro specific ones
                'modules'     => array_merge( $free_plan_modules, $pro_plan_modules_base ),
                // Merge free features with pro specific ones
                'features'    => array_merge( $free_plan_features, $pro_plan_features_base ),
                'publishing_options' => array( 'pwa', 'android_apk', 'ios_ipa' ),
            ),
            'premium' => array(
                'name'        => __( 'Premium Plan', 'as-appskit-pro' ),
                'description' => __( 'Full control and expanded capabilities for comprehensive app solutions.', 'as-appskit-pro' ),
                'price'       => 79.99, // Example price
                // Merge PRO modules with premium specific ones
                'modules'     => array_merge( $free_plan_modules, $pro_plan_modules_base, $premium_plan_modules_base ),
                // Merge PRO features with premium specific ones
                'features'    => array_merge( $free_plan_features, $pro_plan_features_base, $premium_plan_features_base ),
                'publishing_options' => array( 'pwa', 'android_apk', 'ios_ipa', 'instant_play_store' ),
            ),
            'business_pro_plus' => array(
                'name'        => __( 'Business App Pro+ Plan', 'as-appskit-pro' ),
                'description' => __( 'All features for enterprise-level app solutions and advanced business modules.', 'as-appskit-pro' ),
                'price'       => 199.99, // Example price
                // Merge Premium modules with business specific ones
                'modules'     => array_merge( $free_plan_modules, $pro_plan_modules_base, $premium_plan_modules_base, $business_pro_plus_modules_base ),
                // Merge Premium features with business specific ones
                'features'    => array_merge( $free_plan_features, $pro_plan_features_base, $premium_plan_features_base, $business_pro_plus_features_base ),
                'publishing_options' => array( 'pwa', 'android_apk', 'ios_ipa', 'instant_play_store', 'instant_app_store', 'microsoft_store', 'samsung_store' ),
            ),
        );
    }

    /**
     * Get all defined plans.
     * @since 1.0.0
     * @return array
     */
    public function get_all_plans() {
        return $this->plans;
    }

    /**
     * Get a specific plan by its ID.
     * @since 1.0.0
     * @param string $plan_id The ID of the plan (e.g., 'pro').
     * @return array|null The plan array if found, null otherwise.
     */
    public function get_plan( $plan_id ) {
        return isset( $this->plans[ $plan_id ] ) ? $this->plans[ $plan_id ] : null;
    }

    /**
     * Check if a specific feature is enabled for a given plan.
     * @since 1.0.0
     * @param string $plan_id The ID of the plan.
     * @param string $feature_id The ID of the feature to check.
     * @return bool True if the feature is enabled for the plan, false otherwise.
     */
    public function is_feature_enabled_for_plan( $plan_id, $feature_id ) {
        $plan = $this->get_plan( $plan_id );
        if ( $plan && isset( $plan['features'] ) && in_array( $feature_id, (array) $plan['features'] ) ) { // Cast to array for safety
            return true;
        }
        return false;
    }

    /**
     * Get available modules for a given plan.
     * @since 1.0.0
     * @param string $plan_id The ID of the plan.
     * @return array List of module IDs.
     */
    public function get_modules_for_plan( $plan_id ) {
        $plan = $this->get_plan( $plan_id );
        return $plan && isset( $plan['modules'] ) ? (array) $plan['modules'] : array(); // Cast to array for safety
    }

    /**
     * Get available publishing options for a given plan.
     * @since 1.0.0
     * @param string $plan_id The ID of the plan.
     * @return array List of publishing option IDs.
     */
    public function get_publishing_options_for_plan( $plan_id ) {
        $plan = $this->get_plan( $plan_id );
        return $plan && isset( $plan['publishing_options'] ) ? (array) $plan['publishing_options'] : array(); // Cast to array for safety
    }


    /**
     * Run the licensing plan actions.
     * @since    1.0.0
     */
    public function run() {
        // No direct actions for now, mainly public methods.
        // Could add hooks for plan changes, etc. here later.
    }
}