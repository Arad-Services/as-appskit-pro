<div class="as-appskit-onboarding-step-content card p-4">
    <h2 class="mb-4"><?php _e( 'Step 3: Add and Edit Your App Modules', 'as-appskit-pro' ); ?></h2>
    <p class="lead"><?php _e( 'Drag & drop modules from the palette onto the app canvas to build your app\'s functionality. Available modules depend on your chosen plan.', 'as-appskit-pro' ); ?></p>

    <div class="row mt-4">
        <div class="col-md-3">
            <h3 class="mb-3"><?php _e( 'Available Modules', 'as-appskit-pro' ); ?></h3>
            <div class="modules-palette card p-3 shadow-sm">
                <p class="text-muted small mb-3"><?php _e( 'Drag these modules to the App Canvas:', 'as-appskit-pro' ); ?></p>
                <div class="module-item btn btn-outline-primary d-flex align-items-center mb-2" data-module-id="food-ordering">
                    <i class="dashicons-restaurant me-2"></i> <?php _e( 'Food Ordering', 'as-appskit-pro' ); ?>
                </div>
                <div class="module-item btn btn-outline-primary d-flex align-items-center mb-2" data-module-id="appointment-booking">
                    <i class="dashicons-calendar-alt me-2"></i> <?php _e( 'Appointment Booking', 'as-appskit-pro' ); ?>
                </div>
                <div class="module-item btn btn-outline-primary d-flex align-items-center mb-2" data-module-id="image-gallery">
                    <i class="dashicons-images-alt2 me-2"></i> <?php _e( 'Image Gallery', 'as-appskit-pro' ); ?>
                </div>
                <div class="module-item btn btn-outline-secondary d-flex align-items-center mb-2 disabled" title="<?php _e( 'Requires Premium Plan', 'as-appskit-pro' ); ?>">
                    <i class="dashicons-chart-bar me-2"></i> <?php _e( 'Advanced Analytics', 'as-appskit-pro' ); ?>
                </div>
                <div class="module-item btn btn-outline-secondary d-flex align-items-center mb-2 disabled" title="<?php _e( 'Requires Business App Pro+ Plan', 'as-appskit-pro' ); ?>">
                    <i class="dashicons-tag me-2"></i> <?php _e( 'Coupons & Rewards', 'as-appskit-pro' ); ?>
                </div>
                </div>
        </div>
        <div class="col-md-9">
            <h3 class="mb-3"><?php _e( 'App Builder Canvas', 'as-appskit-pro' ); ?></h3>
            <div id="app-builder-canvas" class="app-builder-canvas card p-4 shadow-sm">
                <p class="placeholder-text text-muted"><?php _e( 'Drag modules here to build your app. Live preview coming soon!', 'as-appskit-pro' ); ?></p>
                <div class="example-module-block mt-4 p-3 border rounded bg-light text-muted">
                    <p><em><?php _e( 'Example: Dragged modules will appear here and become configurable.', 'as-appskit-pro' ); ?></em></p>
                    <button class="btn btn-outline-info btn-sm"><?php _e('Configure Module', 'as-appskit-pro'); ?></button>
                </div>
            </div>

            <h3 class="mb-3 mt-5"><?php _e( 'Live App Preview', 'as-appskit-pro' ); ?></h3>
            <div class="card p-3 shadow-sm">
                <iframe id="app-live-preview" srcdoc='<!DOCTYPE html><html><head><style>body { font-family: sans-serif; text-align: center; padding: 20px; background-color: #f8f9fa; }</style></head><body><h1><?php _e("App Preview", "as-appskit-pro"); ?></h1><p><?php _e("Your app will appear here as you build it. Select themes, layouts, and add modules!", "as-appskit-pro"); ?></p></body></html>' width="100%" height="500px" frameborder="0" class="border rounded"></iframe>
            </div>

            <h3 class="mb-3 mt-5"><?php _e( 'App Analytics (Placeholder)', 'as-appskit-pro' ); ?></h3>
            <div class="card p-4 shadow-sm">
                <p class="text-muted"><?php _e( 'Detailed analytics and insights on app usage, installs, and performance will appear here after your app is published and in use.', 'as-appskit-pro' ); ?></p>
                <div class="placeholder-chart" style="height: 150px; background-color: #e9ecef; border-radius: 5px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                    <?php _e('Analytics Dashboard Coming Soon', 'as-appskit-pro'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="navigation-buttons text-end mt-4">
        <button class="btn btn-secondary btn-lg me-2" id="prev-step-3"><?php _e( 'Previous: Choose Layout', 'as-appskit-pro' ); ?></button>
        <button class="btn btn-success btn-lg" id="next-step-3"><?php _e( 'Next: Publish App', 'as-appskit-pro' ); ?></button>
    </div>
</div>