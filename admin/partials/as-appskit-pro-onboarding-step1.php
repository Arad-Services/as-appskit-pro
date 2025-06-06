<?php
/**
 * Admin View: Onboarding Step 1 - Choose App Layout
 *
 * @since 1.0.0
 */

// Instantiate App Themes to get layouts
$app_themes = new AS_Appskit_Pro_App_Themes();
$layouts = $app_themes->get_all_layouts();

// Get current selected layout from a transient or temporary storage
$current_selected_layout = get_transient( 'as_appskit_pro_onboarding_layout_choice_' . get_current_user_id() );

// PHP Debug check: Log if layouts are being fetched.
if ( empty( $layouts ) ) {
    error_log( 'as-appskit-pro: Onboarding Step 1 - No layouts found from AS_Appskit_Pro_App_Themes->get_all_layouts(). Check define_app_layouts().' );
} else {
    error_log( 'as-appskit-pro: Onboarding Step 1 - ' . count($layouts) . ' layouts successfully retrieved.' );
}

?>
<div class="as-appskit-pro-onboarding-step active" id="as-appskit-pro-onboarding-step-1">
    <h2><?php esc_html_e( 'Step 1: Choose Your App Layout', 'as-appskit-pro' ); ?></h2>
    <p class="description"><?php esc_html_e( 'Select from a wide range of pre-designed layouts to define the fundamental structure of your app.', 'as-appskit-pro' ); ?></p>

    <div class="as-appskit-pro-layout-selector row">
        <?php if ( ! empty( $layouts ) ) : ?>
            <?php foreach ( $layouts as $layout_id => $layout_data ) : ?>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="layout-card <?php echo ( $current_selected_layout === $layout_id ) ? 'selected' : ''; ?>" data-layout-id="<?php echo esc_attr( $layout_id ); ?>">
                        <img src="<?php echo esc_url( $layout_data['preview_image'] ); ?>" alt="<?php echo esc_attr( $layout_data['name'] ); ?>" class="img-fluid mb-2">
                        <h5><?php echo esc_html( $layout_data['name'] ); ?></h5>
                        <p class="description"><?php echo esc_html( $layout_data['description'] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12 alert alert-warning">
                <?php esc_html_e( 'No app layouts found. Please check plugin files and AS_Appskit_Pro_App_Themes class.', 'as-appskit-pro' ); ?>
            </div>
        <?php endif; ?>
    </div>
    <input type="hidden" id="selected_layout_id" name="selected_layout_id" value="<?php echo esc_attr( $current_selected_layout ); ?>">

    <div class="as-appskit-pro-onboarding-navigation mt-4">
        <a href="#" class="button button-primary next-step" data-next-step="2"><?php esc_html_e( 'Continue to Step 2', 'as-appskit-pro' ); ?></a>
    </div>
</div>