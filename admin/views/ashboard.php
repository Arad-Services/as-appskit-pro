<div class="wrap">
    <h1><?php _e( 'as-appskit-pro Network Admin Dashboard', 'as-appskit-pro' ); ?></h1>

    <div class="card">
        <h2 class="title"><?php _e( 'Welcome to AppKit Pro!', 'as-appskit-pro' ); ?></h2>
        <p><?php _e( 'This is your central hub for managing your entire SaaS app builder platform across your WordPress Multisite network.', 'as-appskit-pro' ); ?></p>
        <p><?php printf( __( 'Current Plugin Version: <strong>%s</strong>', 'as-appskit-pro' ), AS_APPSKIT_PRO_VERSION ); ?></p>
    </div>

    <div class="card">
        <h2 class="title"><?php _e( 'Quick Stats', 'as-appskit-pro' ); ?></h2>
        <div class="row">
            <div class="col-md-4">
                <div class="stat-box">
                    <h3><?php _e( 'Total Apps Created', 'as-appskit-pro' ); ?></h3>
                    <p class="stat-number">
                        <?php
                        // TODO: Fetch count from as_appskit_pro_apps table
                        global $wpdb;
                        $table_name_apps = $wpdb->base_prefix . 'as_appskit_pro_apps';
                        $total_apps = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name_apps" );
                        echo esc_html( $total_apps );
                        ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <h3><?php _e( 'Active Subscriptions', 'as-appskit-pro' ); ?></h3>
                    <p class="stat-number">
                        <?php
                        // TODO: Fetch count from as_appskit_pro_subscriptions table
                        $table_name_subscriptions = $wpdb->base_prefix . 'as_appskit_pro_subscriptions';
                        $active_subs = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name_subscriptions WHERE status = 'active'" );
                        echo esc_html( $active_subs );
                        ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <h3><?php _e( 'Published Apps', 'as-appskit-pro' ); ?></h3>
                    <p class="stat-number">
                        <?php
                        // TODO: Fetch count of published apps
                        $published_apps = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name_apps WHERE status = 'published'" );
                        echo esc_html( $published_apps );
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2 class="title"><?php _e( 'Quick Actions', 'as-appskit-pro' ); ?></h2>
        <div class="row">
            <div class="col-md-3">
                <a href="<?php echo esc_url( network_admin_url( 'edit.php?post_type=as_appskit_app' ) ); ?>" class="button button-primary button-hero">
                    <?php _e( 'Manage All Apps', 'as-appskit-pro' ); ?>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?php echo esc_url( network_admin_url( 'admin.php?page=as-appskit-pro-plans' ) ); ?>" class="button button-secondary button-hero">
                    <?php _e( 'Configure Plans', 'as-appskit-pro' ); ?>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?php echo esc_url( network_admin_url( 'admin.php?page=as-appskit-pro-support' ) ); ?>" class="button button-secondary button-hero">
                    <?php _e( 'View Support Tickets', 'as-appskit-pro' ); ?>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?php echo esc_url( network_admin_url( 'admin.php?page=as-appskit-pro-whitelabel' ) ); ?>" class="button button-secondary button-hero">
                    <?php _e( 'White Label Settings', 'as-appskit-pro' ); ?>
                </a>
            </div>
        </div>
    </div>

    <?php // You can add more sections here, e.g., System Status, Integrations, etc. ?>

</div>