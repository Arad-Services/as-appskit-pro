<?php
/**
 * Frontend App Editor Dashboard for individual app owners.
 * Accessible at /as-appskit-dashboard.
 * This is where the drag & drop editor will eventually live.
 *
 * @since 1.0.0
 */

// Ensure user is logged in (and perhaps owns/has access to an app)
if ( ! is_user_logged_in() ) {
    wp_die( __( 'You must be logged in to access the App Editor.', 'as-appskit-pro' ) );
}

$current_user = wp_get_current_user();
$app_record_id = isset( $_GET['app_id'] ) ? intval( $_GET['app_id'] ) : 0;
$app_record = null;
$app_site_url = '#'; // Default
$app_title = 'Your App Name'; // Default

if ( $app_record_id ) {
    $app_record = get_post( $app_record_id );
    if ( $app_record && $app_record->post_type === 'as_appskit_pro_app' ) {
        // Verify user owns this app record or has permission to edit
        if ( current_user_can( 'edit_post', $app_record->ID ) || current_user_can( 'manage_network' ) ) {
            $app_title = $app_record->post_title;
            $app_site_url = get_post_meta( $app_record->ID, '_as_appskit_pro_site_url', true );
            // Switch to the app's context if necessary for editor operations
            // switch_to_blog( get_post_meta( $app_record->ID, '_as_appskit_pro_site_id', true ) );
            // ... load app specific content and settings
            // restore_current_blog();
        } else {
            wp_die( __( 'You do not have permission to edit this app.', 'as-appskit-pro' ) );
        }
    } else {
        wp_die( __( 'App not found.', 'as-appskit-pro' ) );
    }
} else {
    // If no app_id is passed, could list user's apps or prompt to create one
    // For now, it will just show generic editor placeholder
    $user_apps = get_posts( array(
        'post_type' => 'as_appskit_pro_app',
        'author' => $current_user->ID,
        'posts_per_page' => 1, // Get the first app if any
    ) );
    if ( ! empty( $user_apps ) ) {
        $app_record = $user_apps[0];
        $app_title = $app_record->post_title;
        $app_site_url = get_post_meta( $app_record->ID, '_as_appskit_pro_site_url', true );
        // Consider redirecting to the specific app_id
        // wp_redirect( add_query_arg('app_id', $app_record->ID, site_url('as-appskit-dashboard')) );
        // exit;
    }
}

?>

<div class="container-fluid as-appskit-pro-frontend-dashboard editor-dashboard">
    <div class="row">
        <nav id="editorSidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
            <div class="position-sticky pt-3 sidebar-sticky text-light">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                    <span><?php esc_html_e( 'App Editor', 'as-appskit-pro' ); ?></span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white active" aria-current="page" href="#editor-modules">
                            <span data-feather="grid" class="align-text-bottom"></span>
                            <?php esc_html_e( 'Modules', 'as-appskit-pro' ); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#editor-design">
                            <span data-feather="edit" class="align-text-bottom"></span>
                            <?php esc_html_e( 'Design', 'as-appskit-pro' ); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#editor-settings">
                            <span data-feather="settings" class="align-text-bottom"></span>
                            <?php esc_html_e( 'Settings', 'as-appskit-pro' ); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#editor-analytics">
                            <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                            <?php esc_html_e( 'App Analytics', 'as-appskit-pro' ); ?>
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                    <span><?php esc_html_e( 'Actions', 'as-appskit-pro' ); ?></span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            <span data-feather="save" class="align-text-bottom"></span>
                            <?php esc_html_e( 'Save App', 'as-appskit-pro' ); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?php echo esc_url( $app_site_url ); ?>" target="_blank">
                            <span data-feather="play-circle" class="align-text-bottom"></span>
                            <?php esc_html_e( 'Preview App', 'as-appskit-pro' ); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">
                            <span data-feather="upload" class="align-text-bottom"></span>
                            <?php esc_html_e( 'Publish App', 'as-appskit-pro' ); ?>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 editor-canvas">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><?php esc_html_e( 'App Editor for: ', 'as-appskit-pro' ); echo esc_html( $app_title ); ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-primary me-2">
                        <span data-feather="save" class="align-text-bottom"></span>
                        <?php esc_html_e( 'Save App', 'as-appskit-pro' ); ?>
                    </button>
                    <a href="<?php echo esc_url( $app_site_url ); ?>" target="_blank" class="btn btn-success">
                        <span data-feather="eye" class="align-text-bottom"></span>
                        <?php esc_html_e( 'View Live App', 'as-appskit-pro' ); ?>
                    </a>
                </div>
            </div>

            <div class="alert alert-info">
                <?php esc_html_e( 'Welcome, ', 'as-appskit-pro' ); echo esc_html( $current_user->display_name ); ?>!
                <?php esc_html_e( 'This is your App Editor Dashboard. The powerful drag & drop editor will be integrated here for you to build your app visually. (Future Feature)', 'as-appskit-pro' ); ?>
            </div>

            <div class="app-editor-canvas" style="border: 1px dashed #ccc; min-height: 600px; padding: 20px; text-align: center; background-color: #f9f9f9;">
                <h4><?php esc_html_e( 'Drag & Drop Editor Canvas', 'as-appskit-pro' ); ?></h4>
                <p><?php esc_html_e( 'Modules will appear here for you to drag and drop onto your app preview.', 'as-appskit-pro' ); ?></p>

                <div class="module-slider bg-light p-3 mb-4 rounded shadow-sm overflow-auto d-flex flex-nowrap">
                    <?php
                    // Example modules from your free plan for the slider
                    $modules = array(
                        'text_block' => 'Text Block',
                        'image_gallery' => 'Image Gallery',
                        'contact_form' => 'Contact Form',
                        'call_to_action' => 'Call to Action',
                        'data_analytics' => 'Analytics',
                        'navigation_bar' => 'Nav Bar',
                    );
                    $module_icons = array(
                        'text_block'        => 'dashicons-text',
                        'image_gallery'     => 'dashicons-format-gallery',
                        'contact_form'      => 'dashicons-email-alt',
                        'call_to_action'    => 'dashicons-megaphone',
                        'data_analytics'    => 'dashicons-chart-bar',
                        'navigation_bar'    => 'dashicons-menu',
                    );

                    foreach ($modules as $id => $name) : ?>
                        <div class="module-item p-2 me-2 border rounded text-center" style="min-width: 100px;">
                            <span class="dashicons <?php echo esc_attr($module_icons[$id] ?? 'dashicons-admin-generic'); ?>" style="font-size: 2em;"></span>
                            <small class="d-block"><?php echo esc_html($name); ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="app-preview-area bg-white border rounded shadow" style="min-height: 400px; padding: 20px; position: relative;">
                    <p class="text-muted"><?php esc_html_e('Your app preview will render here.', 'as-appskit-pro'); ?></p>
                    <iframe src="<?php echo esc_url( $app_site_url ); ?>" style="width: 100%; height: 100%; border: none;"></iframe>
                </div>
            </div>

            <section id="editor-analytics" class="dashboard-section mt-5">
                <h3><?php esc_html_e( 'Your App Analytics', 'as-appskit-pro' ); ?></h3>
                <p><?php esc_html_e( 'Monitor the performance and engagement of your specific app.', 'as-appskit-pro' ); ?></p>
                <div class="alert alert-info" role="alert">
                    <?php esc_html_e( 'App-specific analytics data will be displayed here. (Future Feature)', 'as-appskit-pro' ); ?>
                </div>
                <div class="row">
                    <div class="col-md-6"><div class="card p-3"><p class="text-muted">App Installs: XX</p></div></div>
                    <div class="col-md-6"><div class="card p-3"><p class="text-muted">Active Users: XX</p></div></div>
                </div>
            </section>
        </main>
    </div>
</div>