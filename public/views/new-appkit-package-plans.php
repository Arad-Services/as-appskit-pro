<?php
/**
 * Template for the "AppKit Pro Package Plans" page.
 *
 * This page displays the different subscription tiers and their features.
 *
 * @package As_Appskit_Pro
 * @subpackage Public/Views
 * @version 4.0.1
 */

get_header(); // Use WordPress theme header
?>

<div class="wrap as-appskit-pro-plans-page">
    <div class="container py-5">
        <h1 class="text-center mb-5"><?php _e( 'Choose Your AppKit Pro Plan', 'as-appskit-pro' ); ?></h1>
        <p class="lead text-center mb-5"><?php _e( 'Unlock powerful features and build amazing apps with our flexible pricing plans.', 'as-appskit-pro' ); ?></p>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            // TODO: Dynamically fetch plan data from As_Appskit_Pro_Activator::get_default_plans_config()
            // For now, static placeholders.
            $plans = As_Appskit_Pro_Activator::get_default_plans_config(); // Use the static method from activator
            unset($plans['addon_pos_system_restaurant']); // Remove addon from main display

            foreach ( $plans as $slug => $plan_data ) :
                // Basic feature display, very simplified
                $features_to_display = array_slice($plan_data['features'], 0, 5); // Show first 5 features
                if (count($plan_data['features']) > 5) {
                    $features_to_display[] = '... and more!';
                }
            ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-<?php echo ($slug === 'business-app-pro-plus') ? 'primary' : 'light'; ?>">
                    <div class="card-header text-center bg-<?php echo ($slug === 'business-app-pro-plus') ? 'primary text-white' : 'light'; ?> py-3">
                        <h4 class="my-0 fw-normal"><?php echo esc_html( $plan_data['name'] ); ?></h4>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h1 class="card-title pricing-card-title text-center">
                            $<?php echo esc_html( $plan_data['price_monthly'] ); ?>
                            <small class="text-muted fw-light">/mo</small>
                        </h1>
                        <h2 class="card-title pricing-card-title text-center text-muted">
                            $<?php echo esc_html( $plan_data['price_yearly'] ); ?>
                            <small class="fw-light">/yr</small>
                        </h2>
                        <ul class="list-unstyled mt-3 mb-4 flex-grow-1">
                            <?php foreach ( $features_to_display as $feature ) : ?>
                                <li><i class="dashicons-yes-alt me-2 text-success"></i><?php echo esc_html( str_replace('_', ' ', $feature) ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="d-grid">
                            <a href="#" class="btn btn-lg btn-<?php echo ($slug === 'business-app-pro-plus') ? 'primary' : 'outline-primary'; ?> choose-plan-btn mt-auto" data-plan-slug="<?php echo esc_attr( $slug ); ?>">
                                <?php _e( 'Choose Plan', 'as-appskit-pro' ); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <p class="text-center mt-5">
            <?php _e( 'All plans include a 30-Day Money-Back Guarantee!', 'as-appskit-pro' ); ?>
        </p>

        <h2 class="text-center mt-5 mb-4"><?php _e( 'Available Add-Ons', 'as-appskit-pro' ); ?></h2>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header text-center bg-secondary text-white py-3">
                        <h4 class="my-0 fw-normal"><?php _e( 'POS System for Restaurants Add-On', 'as-appskit-pro' ); ?></h4>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h1 class="card-title pricing-card-title text-center">
                            $29 <small class="text-muted fw-light">/mo</small>
                        </h1>
                        <p class="card-text text-center flex-grow-1"><?php _e( 'Integrate a powerful Point-of-Sale system directly into your restaurant app.', 'as-appskit-pro' ); ?></p>
                        <div class="d-grid">
                            <a href="#" class="btn btn-lg btn-outline-secondary mt-auto" data-addon-slug="pos-system-restaurant"><?php _e( 'Add On', 'as-appskit-pro' ); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div></div><?php
get_footer(); // Use WordPress theme footer