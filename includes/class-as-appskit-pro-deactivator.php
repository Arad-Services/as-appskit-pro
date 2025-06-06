<?php
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    As_Appskit_Pro
 * @subpackage As_Appskit_Pro/includes
 */
class As_Appskit_Pro_Deactivator {

    /**
     * Run the network-wide deactivation logic.
     *
     * This method is called when the plugin is network-deactivated. It handles global
     * cleanup operations such as removing scheduled events for the entire network.
     *
     * @since    1.0.0
     * @param    bool $network_wide True if plugin is network deactivated.
     */
    public static function network_deactivate( $network_wide = true ) {
        // IMPORTANT: For a SaaS plugin, you typically DON'T delete user data (apps, subscriptions)
        // on deactivation, only on uninstallation.
        // Deactivation should only clean up temporary data or scheduled events.

        // Example: Remove any scheduled cron jobs created by the plugin for the network.
        // This clears all instances of this hook across all sites.
        wp_clear_scheduled_hook( 'as_appskit_pro_daily_check' );

        // If plugin is network-deactivated in a Multisite setup, iterate through sites.
        if ( $network_wide ) {
            global $wpdb;
            $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
            foreach ( $blog_ids as $blog_id ) {
                switch_to_blog( $blog_id );
                self::deactivate_for_site(); // Run site-specific deactivation
                restore_current_blog();
            }
        } else {
            // Single site deactivation (even if Multisite is enabled, this is a single-site deactivation)
            self::deactivate_for_site();
        }

        // Flush rewrite rules for the entire network.
        flush_rewrite_rules();
    }

    /**
     * Site-specific deactivation logic (runs for each blog in a multisite network or for a single site).
     *
     * This method can be used to clean up site-specific temporary data or options that
     * were set during activation for individual blogs.
     *
     * @since 1.0.0
     */
    protected static function deactivate_for_site() {
        // Example: Delete site-specific options that might have been set for default PWA settings.
        // delete_option( 'as_appskit_pro_site_default_pwa_enabled' );
        // delete_option( 'as_appskit_pro_site_default_offline_page' );

        // You might clear any site-specific scheduled tasks here.
        // wp_clear_scheduled_hook( 'as_appskit_pro_site_hourly_task' );
    }
}