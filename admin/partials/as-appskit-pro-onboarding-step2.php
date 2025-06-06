<?php
/**
 * Admin View: Onboarding Step 2 - Choose App Template
 *
 * @since 1.0.0
 */

// Instantiate App Themes to get templates
$app_themes = new AS_Appskit_Pro_App_Themes();
$templates = $app_themes->get_all_templates();

$current_selected_template = get_transient( 'as_appskit_pro_onboarding_template_choice_' . get_current_user_id() );
?>
<div class="as-appskit-pro-onboarding-step" id="as-appskit-pro-onboarding-step-2">
    <h2><?php esc_html_e( 'Step 2: Choose Your App Template', 'as-appskit-pro' ); ?></h2>
    <p class="description"><?php esc_html_e( 'Select a pre-designed template that aligns with your brand and app purpose. This will define colors, fonts, and overall visual style.', 'as-appskit-pro' ); ?></p>

    <div class="as-appskit-pro-template-selector row">
        <?php foreach ( $templates as $template_id => $template_data ) : ?>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="template-card <?php echo ( $current_selected_template === $template_id ) ? 'selected' : ''; ?>" data-template-id="<?php echo esc_attr( $template_id ); ?>">
                    <img src="<?php echo esc_url( $template_data['preview_image'] ); ?>" alt="<?php echo esc_attr( $template_data['name'] ); ?>" class="img-fluid mb-2">
                    <h5><?php echo esc_html( $template_data['name'] ); ?></h5>
                    <p class="description"><?php echo esc_html( $template_data['description'] ); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <input type="hidden" id="selected_template_id" name="selected_template_id" value="<?php echo esc_attr( $current_selected_template ); ?>">

    <div class="as-appskit-pro-onboarding-navigation mt-4">
        <a href="#" class="button prev-step" data-prev-step="1"><?php esc_html_e( 'Previous Step', 'as-appskit-pro' ); ?></a>
        <a href="#" class="button button-primary next-step" data-next-step="3"><?php esc_html_e( 'Continue to Step 3', 'as-appskit-pro' ); ?></a>
    </div>
</div>