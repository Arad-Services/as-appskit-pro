<?php
/**
 * Template for the Frontend App Editor (User) Dashboard.
 *
 * This is the primary interface for app builders (your users) to manage their apps.
 *
 * @package As_Appskit_Pro
 * @subpackage Public/Views
 * @version 4.0.1
 */

get_header(); // Use WordPress theme header
?>

<div class="wrap as-appskit-user-dashboard">
    <div class="container py-5">
        <h1 class="mb-4"><?php _e( 'My AppKit Dashboard', 'as-appskit-pro' ); ?></h1>
        <p class="lead"><?php _e( 'Welcome back! Manage your apps, subscriptions, and settings here.', 'as-appskit-pro' ); ?></p>

        <div class="row mt-4 g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="dashicons-smartphone display-1 text-primary"></i>
                        <h3 class="card-title mt-3"><?php _e( 'Your Apps', 'as-appskit-pro' ); ?></h3>
                        <p class="card-text"><?php _e( 'View, edit, and manage all the apps you have created.', 'as-appskit-pro' ); ?></p>
                        <a href="#" class="btn btn-primary mt-auto"><?php _e( 'View My Apps', 'as-appskit-pro' ); ?></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="dashicons-admin-users display-1 text-success"></i>
                        <h3 class="card-title mt-3"><?php _e( 'My Plan & Billing', 'as-appskit-pro' ); ?></h3>
                        <p class="card-text"><?php _e( 'Review your current subscription plan and manage billing details.', 'as-appskit-pro' ); ?></p>
                        <a href="<?php echo esc_url( home_url( '/new-appkit-package-plans' ) ); ?>" class="btn btn-success mt-auto"><?php _e( 'Manage Plan', 'as-appskit-pro' ); ?></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="dashicons-email-alt display-1 text-info"></i>
                        <h3 class="card-title mt-3"><?php _e( 'Support & Help', 'as-appskit-pro' ); ?></h3>
                        <p class="card-text"><?php _e( 'Submit a support ticket or find answers to common questions.', 'as-appskit-pro' ); ?></p>
                        <a href="#" class="btn btn-info mt-auto"><?php _e( 'Get Help', 'as-appskit-pro' ); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-5 mb-4"><?php _e( 'App Statistics (Placeholder)', 'as-appskit-pro' ); ?></h2>
        <div class="card p-4 shadow-sm">
            <p class="text-muted"><?php _e( 'This section will display statistics related to your apps, such as installs, active users, and feature usage.', 'as-appskit-pro' ); ?></p>
            <div class="placeholder-chart" style="height: 200px; background-color: #f8f9fa; border-radius: 5px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                <?php _e('Your App Data Coming Soon', 'as-appskit-pro'); ?>
            </div>
        </div>

    </div></div><?php
get_footer(); // Use WordPress theme footer