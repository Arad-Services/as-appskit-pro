<div class="as-appskit-onboarding-step-content card p-4">
    <h2 class="mb-4"><?php _e( 'Step 2: Choose Your App Layout', 'as-appskit-pro' ); ?></h2>
    <p class="lead"><?php _e( 'Select a layout that best fits the structure and functionality of your app. This determines how your content is organized.', 'as-appskit-pro' ); ?></p>

    <div class="app-layouts-grid row g-4 mt-3">
        <?php
        // TODO: Dynamically load available layouts from as-appskit-pro/templates/app-layouts/
        // For now, these are placeholders. You'll need to create dummy image files
        // at AS_APPSKIT_PRO_PLUGIN_URL . 'assets/img/layout-X.png'
        $dummy_layouts = array(
            'tab-bar-bottom', 'drawer-menu-left', 'grid-style', 'card-stack',
            'full-screen-scroll', 'split-view', 'vertical-list', 'horizontal-swipe',
            'multi-level-nav', 'single-page-app'
        );
        $i = 1;
        foreach ( $dummy_layouts as $layout_slug ) {
            $layout_name = ucwords( str_replace( '-', ' ', $layout_slug ) );
            ?>
            <div class="col-md-3 layout-card" data-layout-id="<?php echo esc_attr( $layout_slug ); ?>">
                <div class="card h-100 shadow-sm">
                    <img src="<?php echo esc_url( AS_APPSKIT_PRO_PLUGIN_URL . 'assets/img/layout-' . $i . '.png' ); ?>" class="card-img-top" alt="<?php echo esc_attr( $layout_name ); ?> Layout">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo esc_html( $layout_name ); ?></h5>
                        <p class="card-text text-muted small flex-grow-1"><?php _e( 'A common layout for modern apps.', 'as-appskit-pro' ); ?></p>
                        <button class="btn btn-primary choose-layout-btn mt-2"><?php _e( 'Choose This', 'as-appskit-pro' ); ?></button>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        }
        ?>
    </div>

    <div class="navigation-buttons text-end mt-4">
        <button class="btn btn-secondary btn-lg me-2" id="prev-step-2"><?php _e( 'Previous: Choose Template', 'as-appskit-pro' ); ?></button>
        <button class="btn btn-success btn-lg" id="next-step-2" disabled><?php _e( 'Next: Add Modules', 'as-appskit-pro' ); ?></button>
    </div>
</div>