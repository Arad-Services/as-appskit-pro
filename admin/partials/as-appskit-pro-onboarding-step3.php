<?php
/**
 * Admin View: Onboarding Step 3 - Edit App Modules
 * This step is simplified for now. The drag & drop editor will be a separate, complex module.
 *
 * @since 1.0.0
 */

// Instantiate Licensing Plans to get available modules based on user's plan
$licensing_plans = new AS_Appskit_Pro_Licensing_Plans();
$current_user_plan_id = 'free'; // Example: default to free, or load from user meta
$available_modules_for_plan = $licensing_plans->get_modules_for_plan( $current_user_plan_id );

// Placeholder for chosen modules (will be used by the drag & drop editor)
$chosen_modules = get_transient( 'as_appskit_pro_onboarding_modules_choice_' . get_current_user_id() );
if ( ! is_array( $chosen_modules ) ) {
    $chosen_modules = array();
}

?>
<div class="as-appskit-pro-onboarding-step" id="as-appskit-pro-onboarding-step-3">
    <h2><?php esc_html_e( 'Step 3: Edit Your App Modules', 'as-appskit-pro' ); ?></h2>
    <p class="description"><?php esc_html_e( 'Now, choose the modules to power your app and define its content. You will use our powerful Drag & Drop Editor in the next step.', 'as-appskit-pro' ); ?></p>

    <div class="as-appskit-pro-plan-info mb-4">
        <h3><?php esc_html_e( 'Your Current Plan: ', 'as-appskit-pro' ); echo esc_html( $licensing_plans->get_plan($current_user_plan_id)['name'] ); ?></h3>
        <p><?php esc_html_e( $licensing_plans->get_plan($current_user_plan_id)['description'], 'as-appskit-pro' ); ?></p>
        <p class="description"><?php esc_html_e( 'Upgrade your plan to unlock more modules and features for your app.', 'as-appskit-pro' ); ?> <a href="#" class="as-appskit-pro-link-to-plans"><?php esc_html_e( 'View Plans', 'as-appskit-pro' ); ?></a></p>
    </div>

    <div class="as-appskit-pro-module-selection">
        <h4><?php esc_html_e( 'Available Modules for Your Plan:', 'as-appskit-pro' ); ?></h4>
        <div class="row">
            <?php
            // Mock module icons and names (you'd have a lookup for these)
            $module_icons = array(
                'text_block'        => 'dashicons-text',
                'image_gallery'     => 'dashicons-format-gallery',
                'contact_form'      => 'dashicons-email-alt',
                'call_to_action'    => 'dashicons-megaphone',
                'data_analytics'    => 'dashicons-chart-bar',
                'navigation_bar'    => 'dashicons-menu',
                'multilingual_compatibility' => 'dashicons-admin-site',
                'buddypress_integration' => 'dashicons-groups',
                'pre_loader'        => 'dashicons-update',
                'app_shortcuts'     => 'dashicons-external',
                'qr_code_generator' => 'dashicons-align-wide',
                'coupons'           => 'dashicons-tag',
                'dollar_rewards'    => 'dashicons-money',
                'submit_receipt'    => 'dashicons-media-text',
                'gps_coupons'       => 'dashicons-location',
                'point_rewards'     => 'dashicons-star-filled',
                'referral_rewards'  => 'dashicons-share',
                'scratch_and_win'   => 'dashicons-editor-expand',
                'appointment_booking' => 'dashicons-calendar-alt',
                'time_slot_booking' => 'dashicons-clock',
                'container_app_modules' => 'dashicons-layout',
                'car_booking'       => 'dashicons-car',
                'employee_schedules'=> 'dashicons-list-view',
                'food_ordering_system' => 'dashicons-carrot',
                'clientele_feature' => 'dashicons-id-alt',
                'event_ticketing'   => 'dashicons-tickets',
                'fan_page'          => 'dashicons-heart',
                'shopping_cart'     => 'dashicons-cart',
                'smart_reviews'     => 'dashicons-thumbs-up',
                'image_gallery_pro' => 'dashicons-images-alt',
                'yellow_pages'      => 'dashicons-phone'
            );

            foreach ( $available_modules_for_plan as $module_id ) :
                $module_name = ucwords( str_replace( '_', ' ', $module_id ) );
                $module_icon = isset( $module_icons[$module_id] ) ? $module_icons[$module_id] : 'dashicons-admin-generic';
            ?>
                <div class="col-md-2 col-sm-4 mb-3">
                    <div class="module-box <?php echo in_array($module_id, $chosen_modules) ? 'selected' : ''; ?>" data-module-id="<?php echo esc_attr( $module_id ); ?>">
                        <span class="dashicons <?php echo esc_attr( $module_icon ); ?>"></span>
                        <p><?php echo esc_html( $module_name ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <input type="hidden" id="selected_modules" name="selected_modules" value="<?php echo esc_attr( implode(',', $chosen_modules) ); ?>">
    </div>

    <div class="as-appskit-pro-onboarding-navigation mt-4">
        <a href="#" class="button prev-step" data-prev-step="2"><?php esc_html_e( 'Previous Step', 'as-appskit-pro' ); ?></a>
        <a href="#" class="button button-primary next-step" data-next-step="4"><?php esc_html_e( 'Continue to Publish', 'as-appskit-pro' ); ?></a>
    </div>
</div>