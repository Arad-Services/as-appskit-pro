<?php
/**
 * Admin View: Onboarding Step 4 - Publish Your New App
 * This step will integrate with payment gateways and app store publishing.
 * It now collects the app title and slug for sub-site creation.
 *
 * @since 1.0.0
 */

// Retrieve choices from previous steps (example from transients)
$selected_layout = get_transient( 'as_appskit_pro_onboarding_layout_choice_' . get_current_user_id() );
$selected_template = get_transient( 'as_appskit_pro_onboarding_template_choice_' . get_current_user_id() );
$selected_modules = get_transient( 'as_appskit_pro_onboarding_modules_choice_' . get_current_user_id() );
if ( ! is_array( $selected_modules ) ) {
    $selected_modules = array();
}
$app_title_draft = get_transient( 'as_appskit_pro_onboarding_app_title_' . get_current_user_id() ) ?: '';
$app_slug_draft = get_transient( 'as_appskit_pro_onboarding_app_slug_' . get_current_user_id() ) ?: '';

// Instantiate Licensing Plans to get publishing options
$licensing_plans = new AS_Appskit_Pro_Licensing_Plans();
// Assume user has 'free' plan for now for demo, you'd fetch actual user plan
$current_user_plan_id = 'free'; // This should come from a licensing system for the logged-in user
$available_publishing_options = $licensing_plans->get_publishing_options_for_plan( $current_user_plan_id );

?>
<div class="as-appskit-pro-onboarding-step" id="as-appskit-pro-onboarding-step-4">
    <h2><?php esc_html_e( 'Step 4: Publish Your New App!', 'as-appskit-pro' ); ?></h2>
    <p class="description"><?php esc_html_e( 'Congratulations! Your app is almost ready. Give your app a name and choose your publishing options.', 'as-appskit-pro' ); ?></p>

    <div class="as-appskit-pro-app-summary card p-3 mb-4">
        <h3 class="card-title"><?php esc_html_e( 'App Configuration Summary', 'as-appskit-pro' ); ?></h3>
        <ul class="list-unstyled">
            <li><strong><?php esc_html_e( 'Layout:', 'as-appskit-pro' ); ?></strong> <?php echo esc_html( $selected_layout ?: 'Not selected' ); ?></li>
            <li><strong><?php esc_html_e( 'Template:', 'as-appskit-pro' ); ?></strong> <?php echo esc_html( $selected_template ?: 'Not selected' ); ?></li>
            <li><strong><?php esc_html_e( 'Modules:', 'as-appskit-pro' ); ?></strong> <?php echo esc_html( implode(', ', array_map('ucwords', array_map(function($m){ return str_replace('_', ' ', $m); }, $selected_modules))) ?: 'None selected' ); ?></li>
        </ul>
    </div>

    <div class="as-appskit-pro-app-details-input card p-3 mb-4">
        <h3 class="card-title"><?php esc_html_e( 'App Name & URL', 'as-appskit-pro' ); ?></h3>
        <div class="mb-3">
            <label for="app_title" class="form-label"><?php esc_html_e( 'Your App Title', 'as-appskit-pro' ); ?><span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="app_title" name="app_title" value="<?php echo esc_attr( $app_title_draft ); ?>" required placeholder="e.g., My Awesome Business App">
            <div class="form-text"><?php esc_html_e( 'This will be the main title of your new app site.', 'as-appskit-pro' ); ?></div>
        </div>
        <div class="mb-3">
            <label for="app_slug" class="form-label"><?php esc_html_e( 'App URL Slug', 'as-appskit-pro' ); ?><span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text"><?php echo esc_url( home_url( '/' ) ); ?></span>
                <input type="text" class="form-control" id="app_slug" name="app_slug" value="<?php echo esc_attr( $app_slug_draft ); ?>" required placeholder="e.g., my-awesome-app">
            </div>
            <div class="form-text"><?php esc_html_e( 'This will be the unique part of your app\'s URL (e.g., website.com/my-awesome-app/). Must be unique across the network.', 'as-appskit-pro' ); ?></div>
        </div>
    </div>


    <div class="as-appskit-pro-publish-options">
        <h3><?php esc_html_e( 'Publishing Options', 'as-appskit-pro' ); ?></h3>
        <p class="description"><?php esc_html_e( 'Select the platforms where you want to publish your app. Available options depend on your subscription plan.', 'as-appskit-pro' ); ?></p>

        <div class="row">
            <?php if ( in_array( 'pwa', $available_publishing_options ) ) : ?>
            <div class="col-md-4 mb-3">
                <div class="publish-option-card">
                    <h4><span class="dashicons dashicons-html"></span> <?php esc_html_e( 'Progressive Web App (PWA)', 'as-appskit-pro' ); ?></h4>
                    <p><?php esc_html_e( 'Instantly available via web browser, installable on mobile devices.', 'as-appskit-pro' ); ?></p>
                    <button class="button button-primary" id="publish-pwa-final" data-type="pwa"><?php esc_html_e( 'Publish PWA (Included)', 'as-appskit-pro' ); ?></button>
                </div>
            </div>
            <?php endif; ?>

            <?php if ( in_array( 'android_apk', $available_publishing_options ) ) : ?>
            <div class="col-md-4 mb-3">
                <div class="publish-option-card">
                    <h4><span class="dashicons dashicons-android"></span> <?php esc_html_e( 'Android APK Package', 'as-appskit-pro' ); ?></h4>
                    <p><?php esc_html_e( 'Download APK for manual upload to Google Play Store, Samsung Store, etc.', 'as-appskit-pro' ); ?></p>
                    <button class="button" id="generate-apk" data-type="apk"><?php esc_html_e( 'Generate APK ($29)', 'as-appskit-pro' ); ?></button>
                </div>
            </div>
            <?php endif; ?>

            <?php if ( in_array( 'ios_ipa', $available_publishing_options ) ) : ?>
            <div class="col-md-4 mb-3">
                <div class="publish-option-card">
                    <h4><span class="dashicons dashicons-apple"></span> <?php esc_html_e( 'iOS App Package', 'as-appskit-pro' ); ?></h4>
                    <p><?php esc_html_e( 'Get IPA file for manual upload to Apple App Store.', 'as-appskit-pro' ); ?></p>
                    <button class="button" id="generate-ios" data-type="ios"><?php esc_html_e( 'Generate iOS App ($49)', 'as-appskit-pro' ); ?></button>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="as-appskit-pro-payment-options mt-4">
            <h3><?php esc_html_e( 'Payment & Subscriptions', 'as-appskit-pro' ); ?></h3>
            <p class="description"><?php esc_html_e( 'Select your plan and securely process payments.', 'as-appskit-pro' ); ?></p>

            <div class="row">
                <?php
                // Display plans dynamically
                $all_plans = $licensing_plans->get_all_plans();
                foreach ( $all_plans as $plan_id => $plan_details ) :
                    if ( $plan_id === 'free' ) continue; // Free plan has no purchase action
                ?>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100 <?php echo ( $plan_id === $current_user_plan_id ) ? 'border-primary shadow' : ''; ?>">
                            <div class="card-header text-center">
                                <h5><?php echo esc_html( $plan_details['name'] ); ?></h5>
                            </div>
                            <div class="card-body text-center">
                                <p class="card-text"><strong>$<?php echo esc_html( number_format( $plan_details['price'], 2 ) ); ?> / month</strong></p>
                                <p class="card-text"><?php echo esc_html( $plan_details['description'] ); ?></p>
                                <ul class="list-unstyled text-start small mt-3">
                                    <li><span class="dashicons dashicons-yes-alt text-success"></span> All Free features</li>
                                    <?php if ( isset( $plan_details['features'] ) ) :
                                        foreach ( $plan_details['features'] as $feature ) :
                                            // Show only a few key differentiators for brevity
                                            if ( in_array( $feature, ['android_apk', 'ios_ipa', 'call_to_action_enabled', 'data_analytics_enabled', 'offline_forms', 'whitelabel_enabled', 'food_ordering_full'] ) ) : ?>
                                                <li><span class="dashicons dashicons-yes-alt text-success"></span> <?php echo esc_html( ucwords( str_replace('_', ' ', $feature) ) ); ?></li>
                                            <?php endif;
                                        endforeach;
                                    endif; ?>
                                </ul>
                            </div>
                            <div class="card-footer text-center">
                                <?php if ( $plan_id === $current_user_plan_id ) : ?>
                                    <button class="btn btn-secondary" disabled><?php esc_html_e( 'Current Plan', 'as-appskit-pro' ); ?></button>
                                <?php else : ?>
                                    <button class="btn btn-primary as-appskit-pro-select-plan-btn" data-plan-id="<?php echo esc_attr( $plan_id ); ?>" data-price="<?php echo esc_attr( $plan_details['price'] ); ?>">
                                        <?php esc_html_e( 'Choose Plan', 'as-appskit-pro' ); ?>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-4">
                <h4><?php esc_html_e( 'Secure Payment Gateway', 'as-appskit-pro' ); ?></h4>
                <div class="payment-buttons">
                    <button class="button button-large button-secondary me-3" id="process-stripe-payment-btn"><?php esc_html_e( 'Pay with Stripe', 'as-appskit-pro' ); ?></button>
                    <button class="button button-large button-secondary" id="process-paypal-payment-btn"><?php esc_html_e( 'Pay with PayPal', 'as-appskit-pro' ); ?></button>
                    </div>
            </div>
        </div>

        <div class="as-appskit-pro-store-publishing mt-4">
            <h3><?php esc_html_e( 'Instant Store Publishing', 'as-appskit-pro' ); ?></h3>
            <p class="description"><?php esc_html_e( 'Let us handle the submission process for you (requires store developer account credentials and relevant plan).', 'as-appskit-pro' ); ?></p>
            <div class="row">
                <?php if ( in_array( 'instant_play_store', $available_publishing_options ) ) : ?>
                <div class="col-md-3 mb-2">
                    <button class="button button-large w-100" id="publish-to-play-store"><?php esc_html_e( 'Google Play Store', 'as-appskit-pro' ); ?></button>
                </div>
                <?php endif; ?>
                <?php if ( in_array( 'instant_app_store', $available_publishing_options ) ) : ?>
                <div class="col-md-3 mb-2">
                    <button class="button button-large w-100" id="publish-to-app-store"><?php esc_html_e( 'Apple App Store', 'as-appskit-pro' ); ?></button>
                </div>
                <?php endif; ?>
                <?php if ( in_array( 'microsoft_store', $available_publishing_options ) ) : ?>
                <div class="col-md-3 mb-2">
                    <button class="button button-large w-100" id="publish-to-microsoft-store"><?php esc_html_e( 'Microsoft Store', 'as-appskit-pro' ); ?></button>
                </div>
                <?php endif; ?>
                <?php if ( in_array( 'samsung_store', $available_publishing_options ) ) : ?>
                <div class="col-md-3 mb-2">
                    <button class="button button-large w-100" id="publish-to-samsung-store"><?php esc_html_e( 'Samsung Galaxy Store', 'as-appskit-pro' ); ?></button>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <div class="as-appskit-pro-onboarding-navigation mt-4">
        <a href="#" class="button prev-step" data-prev-step="3"><?php esc_html_e( 'Previous Step', 'as-appskit-pro' ); ?></a>
        <button class="button button-primary complete-onboarding" id="complete-onboarding-btn"><?php esc_html_e( 'Create App & Go to Editor', 'as-appskit-pro' ); ?></button>
    </div>
</div>