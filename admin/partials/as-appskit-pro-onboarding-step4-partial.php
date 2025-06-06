<div class="as-appskit-onboarding-step-content card p-4">
    <h2 class="mb-4"><?php _e( 'Step 4: Publish Your New App', 'as-appskit-pro' ); ?></h2>
    <p class="lead"><?php _e( 'Congratulations! Your app is ready. Choose how you want to deploy and share it.', 'as-appskit-pro' ); ?></p>

    <div class="row mt-4 g-4">
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-primary text-white"><h3><?php _e( 'Download App Packages', 'as-appskit-pro' ); ?></h3></div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <p class="card-text"><?php _e( 'Generate your native app packages (APK for Android, IPA for iOS) for manual upload to app stores or direct sharing.', 'as-appskit-pro' ); ?></p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg" id="generate-apk-btn">
                            <i class="dashicons-android me-2"></i> <?php _e( 'Generate Android APK', 'as-appskit-pro' ); ?>
                        </button>
                        <button class="btn btn-primary btn-lg" id="generate-ios-btn">
                            <i class="dashicons-apple me-2"></i> <?php _e( 'Generate iOS IPA', 'as-appskit-pro' ); ?>
                        </button>
                    </div>
                    <p class="mt-3 text-muted small"><?php _e( 'Note: This process uses external build services (like VoltBuilder/Cordova) and may take a few minutes depending on your app\'s complexity and current server load. Downloads will appear below.', 'as-appskit-pro' ); ?></p>
                    <div id="package-download-links" class="mt-3 alert alert-light text-center" style="display: none;">
                        <p class="mb-0"><?php _e( 'Your download links will appear here:', 'as-appskit-pro' ); ?></p>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-success text-white"><h3><?php _e( 'Publish to App Stores', 'as-appskit-pro' ); ?></h3></div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <p class="card-text"><?php _e( 'Streamline your deployment. Automatically publish your app to Google Play Store and Apple App Store with a click!', 'as-appskit-pro' ); ?></p>
                    <div class="alert alert-info small">
                        <?php _e( 'Automatic publishing requires active developer accounts (Google Play Console, Apple Developer Program) and a **paid plan** with AppKit Pro.', 'as-appskit-pro' ); ?>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-success btn-lg" id="publish-google-play-btn">
                            <i class="dashicons-google me-2"></i> <?php _e( 'Publish to Google Play', 'as-appskit-pro' ); ?>
                        </button>
                        <button class="btn btn-success btn-lg" id="publish-apple-app-store-btn">
                            <i class="dashicons-apple me-2"></i> <?php _e( 'Publish to Apple App Store', 'as-appskit-pro' ); ?>
                        </button>
                    </div>
                    <p class="mt-3 text-muted small"><?php _e( 'You will be guided through providing necessary credentials and completing any required payments for store fees.', 'as-appskit-pro' ); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="navigation-buttons text-end mt-4">
        <button class="btn btn-secondary btn-lg me-2" id="prev-step-4"><?php _e( 'Previous: Add Modules', 'as-appskit-pro' ); ?></button>
        <button class="btn btn-info btn-lg" id="view-app-dashboard-btn"><?php _e( 'Go to My App Dashboard', 'as-appskit-pro' ); ?></button>
    </div>
</div>