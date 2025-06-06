<?php
/**
 * Template for the Frontend Site Admin Dashboard.
 *
 * This dashboard is intended for administrators of individual sites in a Multisite network
 * or the main site admin, providing site-specific management features (e.g., business listings).
 *
 * @package As_Appskit_Pro
 * @subpackage Public/Views
 * @version 4.0.1
 */

get_header(); // Use WordPress theme header
?>

<div class="wrap as-appskit-site-admin-dashboard">
    <div class="container py-5">
        <h1 class="mb-4"><?php _e( 'Site Admin Dashboard', 'as-appskit-pro' ); ?></h1>
        <p class="lead"><?php _e( 'Welcome to your site-specific AppKit Pro management area. You can manage business listings, site-specific app settings, and more.', 'as-appskit-pro' ); ?></p>

        <div class="row mt-4 g-4">
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="dashicons-store display-1 text-warning"></i>
                        <h3 class="card-title mt-3"><?php _e( 'Business Listings', 'as-appskit-pro' ); ?></h3>
                        <p class="card-text"><?php _e( 'Manage your business listings, which can be integrated into your generated apps.', 'as-appskit-pro' ); ?></p>
                        <a href="#" class="btn btn-warning mt-auto"><?php _e( 'Manage Listings', 'as-appskit-pro' ); ?></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="dashicons-dashboard display-1 text-info"></i>
                        <h3 class="card-title mt-3"><?php _e( 'Site App Settings', 'as-appskit-pro' ); ?></h3>
                        <p class="card-text"><?php _e( 'Configure default settings for apps created from this specific site.', 'as-appskit-pro' ); ?></p>
                        <a href="#" class="btn btn-info mt-auto"><?php _e( 'Configure Site App Defaults', 'as-appskit-pro' ); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-5 mb-4"><?php _e( 'Site Activity & Analytics (Placeholder)', 'as-appskit-pro' ); ?></h2>
        <div class="card p-4 shadow-sm">
            <p class="text-muted"><?php _e( 'This section will display activity specific to this site\'s apps and business listings.', 'as-appskit-pro' ); ?></p>
            <div class="placeholder-chart" style="height: 150px; background-color: #f8f9fa; border-radius: 5px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                <?php _e('Site Analytics Coming Soon', 'as-appskit-pro'); ?>
            </div>
        </div>

    </div></div><?php
get_footer(); // Use WordPress theme footer