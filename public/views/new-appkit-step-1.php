<?php
/**
 * Template for the "Choose Your App Template" (Step 1) page in the app creation funnel.
 *
 * @package As_Appskit_Pro
 * @subpackage Public/Views
 * @version 4.0.1
 */

// This page typically requires a WordPress header.
get_header();
?>

<div class="wrap as-appskit-pro-onboarding-page">
    <div class="container py-5">
        <?php
        // Include the partial for Step 1 content
        include AS_APPSKIT_PRO_PLUGIN_DIR . 'admin/partials/as-appskit-pro-onboarding-step1-partial.php';
        ?>
    </div></div><?php
// This page typically requires a WordPress footer.
get_footer();
<div class="as-appskit-onboarding-step-content card p-4">
    <h2 class="mb-4"><?php _e( 'Step 1: Choose Your App Template', 'as-appskit-pro' ); ?></h2>
    <p class="lead"><?php _e( 'Select a beautiful pre-designed template to kickstart your app. You can customize it later!', 'as-appskit-pro' ); ?></p>

    <div class="app-templates-grid row g-4 mt-3">
        <?php
        // TODO: Dynamically load available themes/templates from as-appskit-pro/templates/app-themes/
        // For now, these are placeholders. You'll need to create dummy image files
        // at AS_APPSKIT_PRO_PLUGIN_URL . 'assets/img/template-X.png'
        $dummy_themes = array(
            'restaurant-modern', 'ecommerce-shop', 'service-agency', 'event-planner',
            'fitness-gym', 'blog-magazine', 'portfolio-creative', 'real-estate',
            'education-portal', 'community-hub'
        );
        $i = 1;
        foreach ( $dummy_themes as $theme_slug ) {
            $theme_name = ucwords( str_replace( '-', ' ', $theme_slug ) );
            ?>
            <div class="col-md-3 template-card" data-template-id="<?php echo esc_attr( $theme_slug ); ?>">
                <div class="card h-100 shadow-sm">
                    <img src="<?php echo esc_url( AS_APPSKIT_PRO_PLUGIN_URL . 'assets/img/template-' . $i . '.png' ); ?>" class="card-img-top" alt="<?php echo esc_attr( $theme_name ); ?> Template">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo esc_html( $theme_name ); ?></h5>
                        <p class="card-text text-muted small flex-grow-1"><?php _e( 'A clean and modern design for ', 'as-appskit-pro' ); echo esc_html($theme_name); ?>.</p>
                        <button class="btn btn-primary choose-template-btn mt-2"><?php _e( 'Choose This', 'as-appskit-pro' ); ?></button>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        }
        ?>
    </div>

    <div class="navigation-buttons text-end mt-4">
        <button class="btn btn-success btn-lg" id="next-step-1" disabled><?php _e( 'Next: Choose Layout', 'as-appskit-pro' ); ?></button>
    </div>
</div>