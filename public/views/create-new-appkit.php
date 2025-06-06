<?php
/**
 * Template for the "Create New AppKit" landing page.
 *
 * This page serves as the entry point for users to start building their app.
 *
 * @package As_Appskit_Pro
 * @subpackage Public/Views
 * @version 4.0.1
 */

// This page typically requires a WordPress header.
get_header();
?>

<div class="wrap as-appskit-pro-landing-page">
    <div class="container text-center py-5">
        <h1 class="display-4"><?php _e( 'Build Your Dream App with AppKit Pro!', 'as-appskit-pro' ); ?></h1>
        <p class="lead"><?php _e( 'Transform your website into a powerful Progressive Web App or a native Android/iOS application with no coding required.', 'as-appskit-pro' ); ?></p>

        <a href="<?php echo esc_url( home_url( '/new-appkit-step-1' ) ); ?>" class="btn btn-primary btn-lg my-4">
            <?php _e( 'Create New AppKit Now!', 'as-appskit-pro' ); ?>
        </a>

        <div class="row features-grid mt-5">
            <div class="col-md-4">
                <div class="card p-3 mb-3">
                    <i class="dashicons-star-filled text-primary display-4"></i>
                    <h3 class="card-title mt-3"><?php _e( 'Stunning Themes & Layouts', 'as-appskit-pro' ); ?></h3>
                    <p class="card-text"><?php _e( 'Choose from 100+ beautiful, ready-to-use themes and flexible layouts to match your brand.', 'as-appskit-pro' ); ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 mb-3">
                    <i class="dashicons-admin-settings text-success display-4"></i>
                    <h3 class="card-title mt-3"><?php _e( 'Powerful Modules', 'as-appskit-pro' ); ?></h3>
                    <p class="card-text"><?php _e( 'Add advanced features like Food Ordering, Booking, Loyalty Programs, and more with drag-and-drop ease.', 'as-appskit-pro' ); ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 mb-3">
                    <i class="dashicons-cloud-upload text-info display-4"></i>
                    <h3 class="card-title mt-3"><?php _e( 'Publish Anywhere', 'as-appskit-pro' ); ?></h3>
                    <p class="card-text"><?php _e( 'Instantly generate APK/IPA files and publish your app to Google Play Store and Apple App Store.', 'as-appskit-pro' ); ?></p>
                </div>
            </div>
        </div>

        <p class="mt-5"><?php _e( 'Ready to get started?', 'as-appskit-pro' ); ?></p>
        <a href="<?php echo esc_url( home_url( '/new-appkit-step-1' ) ); ?>" class="btn btn-primary btn-lg mb-5">
            <?php _e( 'Create Your First App Now!', 'as-appskit-pro' ); ?>
        </a>

    </div></div><?php
// This page typically requires a WordPress footer.
get_footer();