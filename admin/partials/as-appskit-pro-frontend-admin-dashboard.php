<?php
/**
 * Frontend Site Admin Dashboard for as-appskit-pro.
 * Accessible at /as-appskit-admin.
 * This is for the main site admin to manage global plugin settings from the frontend.
 *
 * @since 1.0.0
 */

// Ensure user is logged in and has manage_options capability
if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ) {
    wp_die( __( 'You do not have sufficient permissions to access this page.', 'as-appskit-pro' ) );
}

// Fetch some global settings for display
$app_name = get_option( 'as_appskit_pro_app_name', 'N/A' );
$onboarding_status = get_option( 'as_appskit_pro_onboarding_completed', 'no' );
$offline_usage = get_option( 'as_appskit_pro_offline_usage_enabled', 'no' );
?>

<div class="container-fluid as-appskit-pro-frontend-dashboard">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
            <div class="position-sticky pt-3 sidebar-sticky">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                    <span><?php esc_html_e( 'as-appskit-pro Admin', 'as-appskit-pro' ); ?></span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#general-settings">
                            <span data-feather="home" class="align-text-bottom"></span>
                            <?php esc_html_e( 'General Settings', 'as-appskit-pro' ); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#feature-toggles">
                            <span data-feather="sliders" class="align-text-bottom"></span>
                            <?php esc_html_e( 'Feature Toggles', 'as-appskit-pro' ); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#maintenance">
                            <span data-feather="tool" class="align-text-bottom"></span>
                            <?php esc_html_e( 'Maintenance', 'as-appskit-pro' ); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#analytics">
                            <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                            <?php esc_html_e( 'Global Analytics', 'as-appskit-pro' ); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo esc_url( admin_url() ); ?>">
                            <span data-feather="arrow-left" class="align-text-bottom"></span>
                            <?php esc_html_e( 'Back to WP Admin', 'as-appskit-pro' ); ?>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><?php esc_html_e( 'as-appskit-pro Frontend Admin Dashboard', 'as-appskit-pro' ); ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-sm btn-outline-secondary">
                        <span data-feather="save" class="align-text-bottom"></span>
                        <?php esc_html_e( 'Save All Settings', 'as-appskit-pro' ); ?>
                    </button>
                </div>
            </div>

            <section id="general-settings" class="dashboard-section mb-5">
                <h3><?php esc_html_e( 'General PWA Settings', 'as-appskit-pro' ); ?></h3>
                <p><?php esc_html_e( 'Manage global PWA configurations for your main site and as a fallback for new apps.', 'as-appskit-pro' ); ?></p>
                <form class="as-appskit-pro-settings-form">
                    <?php wp_nonce_field( 'as_appskit_pro_frontend_admin_nonce', 'as_appskit_pro_frontend_admin_nonce_field' ); ?>
                    <div class="mb-3">
                        <label for="adminAppName" class="form-label"><?php esc_html_e( 'Application Name', 'as-appskit-pro' ); ?></label>
                        <input type="text" class="form-control" id="adminAppName" name="as_appskit_pro_app_name" value="<?php echo esc_attr( get_option('as_appskit_pro_app_name') ); ?>">
                        <div class="form-text"><?php esc_html_e( 'The full name of your main application.', 'as-appskit-pro' ); ?></div>
                    </div>
                    <div class="mb-3">
                        <label for="adminThemeColor" class="form-label"><?php esc_html_e( 'Theme Color (Browser Bar)', 'as-appskit-pro' ); ?></label>
                        <input type="color" class="form-control form-control-color" id="adminThemeColor" name="as_appskit_pro_theme_color" value="<?php echo esc_attr( get_option('as_appskit_pro_theme_color') ); ?>">
                        <div class="form-text"><?php esc_html_e( 'Changes the color of browser address bar.', 'as-appskit-pro' ); ?></div>
                    </div>
                    </form>
            </section>

            <section id="feature-toggles" class="dashboard-section mb-5">
                <h3><?php esc_html_e( 'PWA Feature Toggles', 'as-appskit-pro' ); ?></h3>
                <p><?php esc_html_e( 'Globally enable or disable core PWA features.', 'as-appskit-pro' ); ?></p>
                <form class="as-appskit-pro-settings-form">
                    <?php wp_nonce_field( 'as_appskit_pro_frontend_admin_nonce', 'as_appskit_pro_frontend_admin_nonce_field' ); ?>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="offlineUsageToggle" name="as_appskit_pro_offline_usage_enabled" value="yes" <?php checked( 'yes', get_option('as_appskit_pro_offline_usage_enabled') ); ?>>
                        <label class="form-check-label" for="offlineUsageToggle"><?php esc_html_e( 'Enable Offline Usage & Caching', 'as-appskit-pro' ); ?></label>
                        <div class="form-text"><?php esc_html_e( 'Allows your PWA to function offline by caching content.', 'as-appskit-pro' ); ?></div>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="installPromptToggle" name="as_appskit_pro_install_prompt_enabled" value="yes" <?php checked( 'yes', get_option('as_appskit_pro_install_prompt_enabled') ); ?>>
                        <label class="form-check-label" for="installPromptToggle"><?php esc_html_e( 'Show "Add to Home Screen" Prompt', 'as-appskit-pro' ); ?></label>
                        <div class="form-text"><?php esc_html_e( 'Prompts users to install the PWA to their device.', 'as-appskit-pro' ); ?></div>
                    </div>
                    </form>
            </section>

            <section id="maintenance" class="dashboard-section mb-5">
                <h3><?php esc_html_e( 'Maintenance & Auto-Fix', 'as-appskit-pro' ); ?></h3>
                <p><?php esc_html_e( 'Perform health checks and regenerate plugin files to ensure optimal performance.', 'as-appskit-pro' ); ?></p>
                <div class="card p-3 mb-3">
                    <h5 class="card-title"><?php esc_html_e('Automated Checks', 'as-appskit-pro'); ?></h5>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="autofixEnabled" name="as_appskit_pro_autofix_enabled" value="yes" <?php checked( 'yes', get_option('as_appskit_pro_autofix_enabled') ); ?>>
                        <label class="form-check-label" for="autofixEnabled"><?php esc_html_e( 'Enable Automatic Health Monitoring', 'as-appskit-pro' ); ?></label>
                        <div class="form-text"><?php esc_html_e( 'Periodically checks for common issues and attempts to fix them.', 'as-appskit-pro' ); ?></div>
                    </div>
                    <button type="button" class="btn btn-primary" id="as-appskit-pro-frontend-check-errors-btn">
                        <span data-feather="activity" class="align-text-bottom"></span> <?php esc_html_e( 'Run Manual Health Check & Fix', 'as-appskit-pro' ); ?>
                    </button>
                    <div id="as-appskit-pro-frontend-check-errors-status" class="mt-2"></div>
                </div>

                <div class="card p-3">
                    <h5 class="card-title"><?php esc_html_e('File Regeneration', 'as-appskit-pro'); ?></h5>
                    <p class="card-text"><?php esc_html_e('If your PWA manifest or service worker are not updating, click here to force regeneration.', 'as-appskit-pro'); ?></p>
                    <button type="button" class="btn btn-warning" id="as-appskit-pro-frontend-regenerate-files-btn">
                        <span data-feather="refresh-cw" class="align-text-bottom"></span> <?php esc_html_e( 'Regenerate Core PWA Files', 'as-appskit-pro' ); ?>
                    </button>
                    <div id="as-appskit-pro-frontend-regenerate-status" class="mt-2"></div>
                </div>
            </section>

            <section id="analytics" class="dashboard-section mb-5">
                <h3><?php esc_html_e( 'Global Analytics', 'as-appskit-pro' ); ?></h3>
                <p><?php esc_html_e( 'Overview of all app installations, usage trends, and PWA performance across your network.', 'as-appskit-pro' ); ?></p>
                <div class="alert alert-info" role="alert">
                    <?php esc_html_e( 'Analytics data will be displayed here once collected. (Future Feature)', 'as-appskit-pro' ); ?>
                </div>
                <div class="row">
                    <div class="col-md-6"><div class="card p-3"><p class="text-muted">Total Apps: XX</p></div></div>
                    <div class="col-md-6"><div class="card p-3"><p class="text-muted">PWA Installs: XX</p></div></div>
                </div>
            </section>

        </main>
    </div>
</div>