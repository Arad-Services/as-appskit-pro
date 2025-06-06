<div class="wrap">
    <h1><?php _e( 'AppKit Pro Site Settings', 'as-appskit-pro' ); ?></h1>
    <p class="lead"><?php _e( 'This area allows you to configure AppKit Pro settings specific to this WordPress site.', 'as-appskit-pro' ); ?></p>

    <?php
    // Display settings updated message
    if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] === 'true' ) {
        echo '<div id="setting-error-settings_updated" class="updated notice is-dismissible"><p><strong>' . __( 'Site settings saved.', 'as-appskit-pro' ) . '</strong></p></div>';
    }
    ?>

    <div class="card p-4">
        <h2><?php _e( 'Site-Specific AppKit Pro Options', 'as-appskit-pro' ); ?></h2>
        <p class="description"><?php _e( 'Options configured here will apply to apps created on this specific site or influence the site\'s AppKit Pro features.', 'as-appskit-pro' ); ?></p>

        <form method="post" action="options.php">
            <?php settings_fields( 'as-appskit-pro-site-options-group' ); // Will need to register this group in As_Appskit_Pro_Site_Admin ?>
            <?php do_settings_sections( 'as-appskit-pro-site-settings-page' ); // Will need to define sections/fields in As_Appskit_Pro_Site_Admin ?>
            <?php submit_button(); ?>
        </form>

        <h3 class="mt-4"><?php _e( 'Business Listing Integration', 'as-appskit-pro' ); ?></h3>
        <p><?php _e( 'If the "Business App Pro+" plan is active, you can manage business listings for this site here.', 'as-appskit-pro' ); ?></p>
        <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=as_appskit_business_listing' ) ); ?>" class="button button-primary"><?php _e( 'Manage Business Listings', 'as-appskit-pro' ); ?></a>
    </div>

</div>