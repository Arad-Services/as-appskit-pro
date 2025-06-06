<div class="card p-4">
    <h2><?php _e( 'Plugin Health & Tools', 'as-appskit-pro' ); ?></h2>
    <p class="lead"><?php _e( 'Use these tools to ensure AppKit Pro is running optimally and to resolve common issues.', 'as-appskit-pro' ); ?></p>

    <h3 class="mt-4"><?php _e( 'Health Check & Repair', 'as-appskit-pro' ); ?></h3>
    <p class="description"><?php _e( 'Run a diagnostic check to verify database tables, core pages, and rewrite rules. This can resolve issues after updates or migrations.', 'as-appskit-pro' ); ?></p>

    <form method="post" action="<?php echo esc_url( network_admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="as_appskit_pro_run_health_check">
        <?php wp_nonce_field( 'as-appskit-pro-run-health-check' ); ?>
        <?php submit_button( __( 'Run Health Check & Repair', 'as-appskit-pro' ), 'secondary', 'run-health-check', false ); ?>
    </form>

    <h3 class="mt-4"><?php _e( 'Troubleshooting Tips', 'as-appskit-pro' ); ?></h3>
    <ul class="list-unstyled">
        <li><span class="dashicons dashicons-lightbulb mr-2"></span> <?php _e( 'If app URLs are not working (e.g., <code>/app/your-app-slug</code>), try clicking "Save Changes" on the <a href="' . esc_url( network_admin_url( 'settings.php?page=permalink' ) ) . '">Permalinks Settings</a> page in Network Admin.', 'as-appskit-pro' ); ?></li>
        <li><span class="dashicons dashicons-lightbulb mr-2"></span> <?php _e( 'Ensure your server meets the minimum requirements (PHP version, extensions, etc.) as listed in the documentation.', 'as-appskit-pro' ); ?></li>
        <li><span class="dashicons dashicons-lightbulb mr-2"></span> <?php _e( 'Check your PHP error logs for more detailed error messages.', 'as-appskit-pro' ); ?></li>
        <li><span class="dashicons dashicons-lightbulb mr-2"></span> <?php _e( 'Verify that your plugin files are fully uploaded and directory permissions are correct.', 'as-appskit-pro' ); ?></li>
    </ul>

    <?php
    // The "Full Changelog" is already accessible from the main menu, but you can link here too.
    ?>
    <p class="mt-4"><a href="<?php echo esc_url( network_admin_url( 'admin.php?page=as-appskit-pro-changelog' ) ); ?>"><?php _e( 'View Full Changelog', 'as-appskit-pro' ); ?></a></p>
</div>