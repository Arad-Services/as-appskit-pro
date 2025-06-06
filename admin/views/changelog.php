<div class="wrap">
    <h1><?php _e( 'as-appskit-pro Changelog', 'as-appskit-pro' ); ?></h1>
    <p><?php _e( 'This page lists all changes and updates for the as-appskit-pro plugin.', 'as-appskit-pro' ); ?></p>
    <div class="changelog-content card">
        <?php
        // Ideally, load this from a dedicated changelog.txt file or dynamically generate.
        $changelog_file = AS_APPSKIT_PRO_PLUGIN_DIR . 'changelog.txt';
        if ( file_exists( $changelog_file ) ) {
            echo '<pre style="white-space: pre-wrap; word-wrap: break-word; font-family: monospace;">' . esc_html( file_get_contents( $changelog_file ) ) . '</pre>';
        } else {
            _e( 'Changelog file not found. Please ensure changelog.txt exists in the plugin\'s root directory.', 'as-appskit-pro' );
        }
        ?>
    </div>
</div>