<?php
/**
 * Manages the Custom Post Type for 'AppKits' and their associated data.
 * This class handles the registration of the CPT and its meta boxes for admin UI,
 * while syncing data with the global `as_appskit_pro_apps` table.
 *
 * @since      1.0.0
 * @package    As_Appskit_Pro
 * @subpackage As_Appskit_Pro/admin
 */
class As_Appskit_Pro_App_Manager {

    public function __construct() {
        // Constructor, actions are registered from the main plugin loader.
    }

    /**
     * Register the 'as_appskit_app' Custom Post Type.
     * This CPT will store the primary record for each app created by a user
     * on the main site of the Multisite network. Its meta data will hold
     * specific configuration details that are then synced to a global table.
     *
     * @since    1.0.0
     */
    public function register_app_cpt() {
        // Ensure CPT is only registered on the main site if apps are network-wide
        if ( ! is_main_site() ) {
            return;
        }

        $labels = array(
            'name'                  => _x( 'AppKits', 'Post Type General Name', 'as-appskit-pro' ),
            'singular_name'         => _x( 'AppKit', 'Post Type Singular Name', 'as-appskit-pro' ),
            'menu_name'             => __( 'AppKits', 'as-appskit-pro' ),
            'name_admin_bar'        => __( 'AppKit', 'as-appskit-pro' ),
            'parent_item_colon'     => __( 'Parent AppKit:', 'as-appskit-pro' ),
            'all_items'             => __( 'All AppKits', 'as-appskit-pro' ),
            'add_new_item'          => __( 'Add New AppKit', 'as-appskit-pro' ),
            'add_new'               => __( 'Add New', 'as-appskit-pro' ),
            'new_item'              => __( 'New AppKit', 'as-appskit-pro' ),
            'edit_item'             => __( 'Edit AppKit', 'as-appskit-pro' ),
            'update_item'           => __( 'Update AppKit', 'as-appskit-pro' ),
            'view_item'             => __( 'View AppKit', 'as-appskit-pro' ),
            'separate_items_with_commas' => __( 'Separate AppKits with commas', 'as-appskit-pro' ),
            'add_or_remove_items'   => __( 'Add or remove AppKits', 'as-appskit-pro' ),
            'choose_from_most_used' => __( 'Choose from the most used AppKits', 'as-appskit-pro' ),
            'not_found'             => __( 'AppKit Not Found', 'as-appskit-pro' ),
            'not_found_in_trash'    => __( 'AppKit Not found in Trash', 'as-appskit-pro' ),
        );
        $args = array(
            'label'                 => __( 'AppKit', 'as-appskit-pro' ),
            'description'           => __( 'App Builder Projects', 'as-appskit-pro' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'revisions' ),
            'hierarchical'          => false,
            'public'                => false, // Apps are rendered via rewrite rules, not public CPT archive
            'show_ui'               => true,
            'show_in_menu'          => 'as-appskit-pro-dashboard', // Link under our main plugin menu
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-smartphone',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false, // Apps are not browsed via CPT archive
            'exclude_from_search'   => true,
            'publicly_queryable'    => true, // Essential for rewrite rules to work, but actual content from public/views/app-renderer.php
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'app' ), // The base slug for app URLs (e.g., yoursite.com/app/my-app)
            'capability_type'       => 'post',
            'show_in_rest'          => true, // Enable for Gutenberg/REST API interactions
        );
        register_post_type( 'as_appskit_app', $args );
    }

    /**
     * Add custom meta boxes to the AppKit CPT edit screen.
     * This provides the UI for platform admins to view/edit app configurations.
     *
     * @since    1.0.0
     */
    public function add_app_meta_boxes() {
        if ( is_main_site() ) { // Only show on the main site's CPT
            add_meta_box(
                'as_appskit_pro_app_settings',
                __( 'AppKit Configuration', 'as-appskit-pro' ),
                array( $this, 'render_app_settings_meta_box' ),
                'as_appskit_app', // Your CPT slug
                'normal',
                'high'
            );
            // Add more meta boxes for PWA settings, Native App settings, etc. if needed
            // Example: PWA Specific Settings
            add_meta_box(
                'as_appskit_pro_pwa_settings',
                __( 'PWA Settings', 'as-appskit-pro' ),
                array( $this, 'render_pwa_settings_meta_box' ),
                'as_appskit_app',
                'normal',
                'high'
            );
        }
    }

    /**
     * Render the content of the AppKit Configuration meta box.
     * This displays core app details like theme, layout, owner, and status.
     *
     * @since    1.0.0
     * @param    WP_Post $post The current post object.
     */
    public function render_app_settings_meta_box( $post ) {
        wp_nonce_field( 'as_appskit_pro_save_app_data', 'as_appskit_pro_app_nonce' );

        $theme_id     = get_post_meta( $post->ID, '_as_appskit_pro_theme_id', true );
        $layout_id    = get_post_meta( $post->ID, '_as_appskit_pro_layout_id', true );
        $app_slug     = get_post_meta( $post->ID, '_as_appskit_pro_app_slug', true );
        $app_owner_id = get_post_meta( $post->ID, '_as_appskit_pro_app_owner_id', true );
        $app_status   = get_post_meta( $post->ID, '_as_appskit_pro_app_status', true );
        $module_data  = get_post_meta( $post->ID, '_as_appskit_pro_module_data', true ); // All module configs

        ?>
        <p>
            <label for="as_appskit_pro_app_slug"><?php _e( 'App Slug (for URL)', 'as-appskit-pro' ); ?>:</label>
            <input type="text" id="as_appskit_pro_app_slug" name="as_appskit_pro_app_slug" value="<?php echo esc_attr( $app_slug ); ?>" class="large-text" placeholder="e.g., my-awesome-app" required />
            <p class="description"><?php _e( 'This will be part of the app URL, e.g., <code><?php echo esc_url( home_url( '/app/' ) ); ?><strong><?php echo esc_attr( $app_slug ); ?></strong></code>', 'as-appskit-pro' ); ?></p>
        </p>
        <p>
            <label for="as_appskit_pro_theme_id"><?php _e( 'Selected Theme ID', 'as-appskit-pro' ); ?>:</label>
            <input type="text" id="as_appskit_pro_theme_id" name="as_appskit_pro_theme_id" value="<?php echo esc_attr( $theme_id ); ?>" class="large-text" placeholder="e.g., theme-restaurant-light" />
            <p class="description"><?php _e( 'The unique identifier for the theme chosen by the user.', 'as-appskit-pro' ); ?></p>
        </p>
        <p>
            <label for="as_appskit_pro_layout_id"><?php _e( 'Selected Layout ID', 'as-appskit-pro' ); ?>:</label>
            <input type="text" id="as_appskit_pro_layout_id" name="as_appskit_pro_layout_id" value="<?php echo esc_attr( $layout_id ); ?>" class="large-text" placeholder="e.g., layout-tab-bar" />
            <p class="description"><?php _e( 'The unique identifier for the layout chosen by the user.', 'as-appskit-pro' ); ?></p>
        </p>
        <p>
            <label for="as_appskit_pro_app_owner_id"><?php _e( 'App Owner User ID', 'as-appskit-pro' ); ?>:</label>
            <input type="number" id="as_appskit_pro_app_owner_id" name="as_appskit_pro_app_owner_id" value="<?php echo esc_attr( $app_owner_id ); ?>" class="large-text" />
            <p class="description"><?php _e( 'The WordPress User ID of the platform user who owns this app.', 'as-appskit-pro' ); ?></p>
        </p>
        <p>
            <label for="as_appskit_pro_app_status"><?php _e( 'App Status', 'as-appskit-pro' ); ?>:</label>
            <select id="as_appskit_pro_app_status" name="as_appskit_pro_app_status" class="postbox">
                <option value="draft" <?php selected( $app_status, 'draft' ); ?>><?php _e( 'Draft', 'as-appskit-pro' ); ?></option>
                <option value="pending_review" <?php selected( $app_status, 'pending_review' ); ?>><?php _e( 'Pending Review', 'as-appskit-pro' ); ?></option>
                <option value="published" <?php selected( $app_status, 'published' ); ?>><?php _e( 'Published', 'as-appskit-pro' ); ?></option>
                <option value="suspended" <?php selected( $app_status, 'suspended' ); ?>><?php _e( 'Suspended', 'as-appskit-pro' ); ?></option>
                <option value="archived" <?php selected( $app_status, 'archived' ); ?>><?php _e( 'Archived', 'as-appskit-pro' ); ?></option>
            </select>
        </p>
        <p>
            <label for="as_appskit_pro_module_data"><?php _e( 'Module Configuration (JSON)', 'as-appskit-pro' ); ?>:</label>
            <textarea id="as_appskit_pro_module_data" name="as_appskit_pro_module_data" rows="10" class="large-text code"><?php echo esc_textarea( $module_data ); ?></textarea>
            <p class="description"><?php _e( 'JSON representation of all module settings and configurations for this app. This data is primarily managed through the frontend app builder.', 'as-appskit-pro' ); ?></p>
        </p>
        <?php
    }

    /**
     * Render the content of the PWA Settings meta box.
     * This allows platform admins to fine-tune PWA options for a specific app.
     *
     * @since 4.0.1
     * @param WP_Post $post The current post object.
     */
    public function render_pwa_settings_meta_box( $post ) {
        $app_name_pwa = get_post_meta( $post->ID, '_as_appskit_pro_pwa_app_name', true ) ?: $post->post_title;
        $app_short_name = get_post_meta( $post->ID, '_as_appskit_pro_pwa_short_name', true ) ?: substr($post->post_title, 0, 12);
        $start_url = get_post_meta( $post->ID, '_as_appskit_pro_pwa_start_url', true ) ?: home_url('/app/' . $post->post_name . '/');
        $theme_color = get_post_meta( $post->ID, '_as_appskit_pro_pwa_theme_color', true ) ?: '#ffffff';
        $background_color = get_post_meta( $post->ID, '_as_appskit_pro_pwa_background_color', true ) ?: '#ffffff';
        $display_mode = get_post_meta( $post->ID, '_as_appskit_pro_pwa_display_mode', true ) ?: 'standalone';
        $orientation = get_post_meta( $post->ID, '_as_appskit_pro_pwa_orientation', true ) ?: 'any';
        $icon_url = get_post_meta( $post->ID, '_as_appskit_pro_pwa_icon_url', true ) ?: AS_APPSKIT_PRO_PLUGIN_URL . 'assets/img/default-pwa-icon.png';
        $splash_icon_url = get_post_meta( $post->ID, '_as_appskit_pro_pwa_splash_icon_url', true ) ?: AS_APPSKIT_PRO_PLUGIN_URL . 'assets/img/default-splash-icon.png';

        ?>
        <p>
            <label for="as_appskit_pro_pwa_app_name"><?php _e( 'Application Name', 'as-appskit-pro' ); ?>:</label>
            <input type="text" id="as_appskit_pro_pwa_app_name" name="as_appskit_pro_pwa_app_name" value="<?php echo esc_attr( $app_name_pwa ); ?>" class="large-text" />
        </p>
        <p>
            <label for="as_appskit_pro_pwa_short_name"><?php _e( 'Short Name', 'as-appskit-pro' ); ?>:</label>
            <input type="text" id="as_appskit_pro_pwa_short_name" name="as_appskit_pro_pwa_short_name" value="<?php echo esc_attr( $app_short_name ); ?>" class="large-text" />
        </p>
        <p>
            <label for="as_appskit_pro_pwa_start_url"><?php _e( 'Start URL', 'as-appskit-pro' ); ?>:</label>
            <input type="url" id="as_appskit_pro_pwa_start_url" name="as_appskit_pro_pwa_start_url" value="<?php echo esc_url( $start_url ); ?>" class="large-text" />
            <p class="description"><?php _e( 'The page where the PWA will start when launched.', 'as-appskit-pro' ); ?></p>
        </p>
        <p>
            <label for="as_appskit_pro_pwa_theme_color"><?php _e( 'Theme Color', 'as-appskit-pro' ); ?>:</label>
            <input type="text" id="as_appskit_pro_pwa_theme_color" name="as_appskit_pro_pwa_theme_color" value="<?php echo esc_attr( $theme_color ); ?>" class="as-appskit-pro-color-picker" />
            <p class="description"><?php _e( 'Changes the color of the browser address bar for Chrome, Firefox OS, and Opera.', 'as-appskit-pro' ); ?></p>
        </p>
        <p>
            <label for="as_appskit_pro_pwa_background_color"><?php _e( 'Splash Screen Background Color', 'as-appskit-pro' ); ?>:</label>
            <input type="text" id="as_appskit_pro_pwa_background_color" name="as_appskit_pro_pwa_background_color" value="<?php echo esc_attr( $background_color ); ?>" class="as-appskit-pro-color-picker" />
            <p class="description"><?php _e( 'The background color for the splash screen when the PWA is launched.', 'as-appskit-pro' ); ?></p>
        </p>
        <p>
            <label for="as_appskit_pro_pwa_display_mode"><?php _e( 'Display Mode', 'as-appskit-pro' ); ?>:</label>
            <select id="as_appskit_pro_pwa_display_mode" name="as_appskit_pro_pwa_display_mode" class="postbox">
                <option value="fullscreen" <?php selected( $display_mode, 'fullscreen' ); ?>><?php _e( 'Fullscreen', 'as-appskit-pro' ); ?></option>
                <option value="standalone" <?php selected( $display_mode, 'standalone' ); ?>><?php _e( 'Standalone (looks like a native app)', 'as-appskit-pro' ); ?></option>
                <option value="minimal-ui" <?php selected( $display_mode, 'minimal-ui' ); ?>><?php _e( 'Minimal UI', 'as-appskit-pro' ); ?></option>
                <option value="browser" <?php selected( $display_mode, 'browser' ); ?>><?php _e( 'Browser', 'as-appskit-pro' ); ?></option>
            </select>
        </p>
        <p>
            <label for="as_appskit_pro_pwa_orientation"><?php _e( 'Default Orientation', 'as-appskit-pro' ); ?>:</label>
            <select id="as_appskit_pro_pwa_orientation" name="as_appskit_pro_pwa_orientation" class="postbox">
                <option value="any" <?php selected( $orientation, 'any' ); ?>><?php _e( 'Any (Follow Device Orientation)', 'as-appskit-pro' ); ?></option>
                <option value="portrait" <?php selected( $orientation, 'portrait' ); ?>><?php _e( 'Portrait', 'as-appskit-pro' ); ?></option>
                <option value="landscape" <?php selected( $orientation, 'landscape' ); ?>><?php _e( 'Landscape', 'as-appskit-pro' ); ?></option>
            </select>
        </p>
        <p>
            <label for="as_appskit_pro_pwa_icon_url"><?php _e( 'App Icon (192x192 & Apple Touch)', 'as-appskit-pro' ); ?>:</label><br/>
            <input type="text" id="as_appskit_pro_pwa_icon_url" name="as_appskit_pro_pwa_icon_url" value="<?php echo esc_url( $icon_url ); ?>" class="large-text as-appskit-pro-media-field" />
            <button type="button" class="button as-appskit-pro-upload-button" data-target-field="#as_appskit_pro_pwa_icon_url" data-target-image="#as_appskit_pro_pwa_icon_preview"><?php _e( 'Upload/Select Image', 'as-appskit-pro' ); ?></button><br/>
            <img id="as_appskit_pro_pwa_icon_preview" src="<?php echo esc_url( $icon_url ); ?>" style="max-width:100px; height:auto; display:<?php echo $icon_url ? 'block' : 'none'; ?>; margin-top:10px;" />
            <p class="description"><?php _e( 'Upload an icon (preferably square, e.g., 192x192px) for your PWA and Apple Touch Icon.', 'as-appskit-pro' ); ?></p>
        </p>
        <p>
            <label for="as_appskit_pro_pwa_splash_icon_url"><?php _e( 'Splash Screen Icon (512x512)', 'as-appskit-pro' ); ?>:</label><br/>
            <input type="text" id="as_appskit_pro_pwa_splash_icon_url" name="as_appskit_pro_pwa_splash_icon_url" value="<?php echo esc_url( $splash_icon_url ); ?>" class="large-text as-appskit-pro-media-field" />
            <button type="button" class="button as-appskit-pro-upload-button" data-target-field="#as_appskit_pro_pwa_splash_icon_url" data-target-image="#as_appskit_pro_pwa_splash_icon_preview"><?php _e( 'Upload/Select Image', 'as-appskit-pro' ); ?></button><br/>
            <img id="as_appskit_pro_pwa_splash_icon_preview" src="<?php echo esc_url( $splash_icon_url ); ?>" style="max-width:100px; height:auto; display:<?php echo $splash_icon_url ? 'block' : 'none'; ?>; margin-top:10px;" />
            <p class="description"><?php _e( 'Upload a high-quality (e.g., 512x512px) icon for your PWA splash screen.', 'as-appskit-pro' ); ?></p>
        </p>
        <p>
            <label><?php _e( 'Maskable Icon Support:', 'as-appskit-pro' ); ?></label><br/>
            <input type="checkbox" id="as_appskit_pro_pwa_maskable_icon" name="as_appskit_pro_pwa_maskable_icon" value="1" <?php checked( get_post_meta( $post->ID, '_as_appskit_pro_pwa_maskable_icon', true ), 1 ); ?> />
            <label for="as_appskit_pro_pwa_maskable_icon"><?php _e( 'Enable Maskable Icon (ensure your icon is designed for this)', 'as-appskit-pro' ); ?></label>
        </p>
        <p>
            <label><?php _e( 'Monochrome Icon Support:', 'as-appskit-pro' ); ?></label><br/>
            <input type="checkbox" id="as_appskit_pro_pwa_monochrome_icon" name="as_appskit_pro_pwa_monochrome_icon" value="1" <?php checked( get_post_meta( $post->ID, '_as_appskit_pro_pwa_monochrome_icon', true ), 1 ); ?> />
            <label for="as_appskit_pro_pwa_monochrome_icon"><?php _e( 'Enable Monochrome Icon for system interfaces', 'as-appskit-pro' ); ?></label>
        </p>
        <?php
    }

    /**
     * Save custom meta data for the AppKit CPT.
     * This method is responsible for persisting the app's configuration from the
     * WordPress admin interface (CPT edit screen) and syncing it to the global
     * `as_appskit_pro_apps` custom table.
     *
     * @since    1.0.0
     * @param    int $post_id The ID of the post being saved.
     */
    public function save_app_meta_data( $post_id ) {
        // Only run on the main site for the app CPT
        if ( ! is_main_site() || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) || ( ! isset( $_POST['post_type'] ) || 'as_appskit_app' !== $_POST['post_type'] ) ) {
            return;
        }

        // Verify nonce
        if ( ! isset( $_POST['as_appskit_pro_app_nonce'] ) || ! wp_verify_nonce( $_POST['as_appskit_pro_app_nonce'], 'as_appskit_pro_save_app_data' ) ) {
            return;
        }

        // Sanitize and save core app data to post meta
        $app_slug = sanitize_title( $_POST['as_appskit_pro_app_slug'] ?? '' );
        update_post_meta( $post_id, '_as_appskit_pro_app_slug', $app_slug );
        update_post_meta( $post_id, '_as_appskit_pro_theme_id', sanitize_text_field( $_POST['as_appskit_pro_theme_id'] ?? '' ) );
        update_post_meta( $post_id, '_as_appskit_pro_layout_id', sanitize_text_field( $_POST['as_appskit_pro_layout_id'] ?? '' ) );
        update_post_meta( $post_id, '_as_appskit_pro_app_owner_id', absint( $_POST['as_appskit_pro_app_owner_id'] ?? 0 ) );
        update_post_meta( $post_id, '_as_appskit_pro_app_status', sanitize_text_field( $_POST['as_appskit_pro_app_status'] ?? 'draft' ) );
        // The module data is complex; use wp_kses_post if it's HTML, or json_decode/encode with validation
        update_post_meta( $post_id, '_as_appskit_pro_module_data', wp_kses_post( wp_unslash( $_POST['as_appskit_pro_module_data'] ?? '' ) ) );

        // Sanitize and save PWA settings to post meta
        update_post_meta( $post_id, '_as_appskit_pro_pwa_app_name', sanitize_text_field( $_POST['as_appskit_pro_pwa_app_name'] ?? '' ) );
        update_post_meta( $post_id, '_as_appskit_pro_pwa_short_name', sanitize_text_field( $_POST['as_appskit_pro_pwa_short_name'] ?? '' ) );
        update_post_meta( $post_id, '_as_appskit_pro_pwa_start_url', esc_url_raw( $_POST['as_appskit_pro_pwa_start_url'] ?? '' ) );
        update_post_meta( $post_id, '_as_appskit_pro_pwa_theme_color', sanitize_hex_color( $_POST['as_appskit_pro_pwa_theme_color'] ?? '' ) );
        update_post_meta( $post_id, '_as_appskit_pro_pwa_background_color', sanitize_hex_color( $_POST['as_appskit_pro_pwa_background_color'] ?? '' ) );
        update_post_meta( $post_id, '_as_appskit_pro_pwa_display_mode', sanitize_text_field( $_POST['as_appskit_pro_pwa_display_mode'] ?? 'standalone' ) );
        update_post_meta( $post_id, '_as_appskit_pro_pwa_orientation', sanitize_text_field( $_POST['as_appskit_pro_pwa_orientation'] ?? 'any' ) );
        update_post_meta( $post_id, '_as_appskit_pro_pwa_icon_url', esc_url_raw( $_POST['as_appskit_pro_pwa_icon_url'] ?? '' ) );
        update_post_meta( $post_id, '_as_appskit_pro_pwa_splash_icon_url', esc_url_raw( $_POST['as_appskit_pro_pwa_splash_icon_url'] ?? '' ) );
        update_post_meta( $post_id, '_as_appskit_pro_pwa_maskable_icon', isset( $_POST['as_appskit_pro_pwa_maskable_icon'] ) ? 1 : 0 );
        update_post_meta( $post_id, '_as_appskit_pro_pwa_monochrome_icon', isset( $_POST['as_appskit_pro_pwa_monochrome_icon'] ) ? 1 : 0 );


        // --- Sync data to the global custom table `as_appskit_pro_apps` ---
        // This keeps the primary app data table in sync with CPT data for quick lookups
        // and consistency across the network.
        global $wpdb;
        $table_name_apps = $wpdb->base_prefix . 'as_appskit_pro_apps';

        // Gather all settings into a single JSON object for the 'settings' column in the global table
        $all_app_settings = array(
            'theme_id'           => get_post_meta( $post_id, '_as_appskit_pro_theme_id', true ),
            'layout_id'          => get_post_meta( $post_id, '_as_appskit_pro_layout_id', true ),
            'module_data'        => json_decode( get_post_meta( $post_id, '_as_appskit_pro_module_data', true ), true ), // Decode for manipulation if needed
            'pwa_settings'       => array(
                'app_name'           => get_post_meta( $post_id, '_as_appskit_pro_pwa_app_name', true ),
                'short_name'         => get_post_meta( $post_id, '_as_appskit_pro_pwa_short_name', true ),
                'start_url'          => get_post_meta( $post_id, '_as_appskit_pro_pwa_start_url', true ),
                'theme_color'        => get_post_meta( $post_id, '_as_appskit_pro_pwa_theme_color', true ),
                'background_color'   => get_post_meta( $post_id, '_as_appskit_pro_pwa_background_color', true ),
                'display_mode'       => get_post_meta( $post->ID, '_as_appskit_pro_pwa_display_mode', true ),
                'orientation'        => get_post_meta( $post->ID, '_as_appskit_pro_pwa_orientation', true ),
                'icon_url'           => get_post_meta( $post->ID, '_as_appskit_pro_pwa_icon_url', true ),
                'splash_icon_url'    => get_post_meta( $post->ID, '_as_appskit_pro_pwa_splash_icon_url', true ),
                'maskable_icon'      => get_post_meta( $post->ID, '_as_appskit_pro_pwa_maskable_icon', true ),
                'monochrome_icon'    => get_post_meta( $post->ID, '_as_appskit_pro_pwa_monochrome_icon', true ),
                // Add other PWA settings here
            ),
            // Add other top-level settings like native app options, analytics settings etc.
        );

        $app_data = array(
            'app_post_id'  => $post_id,
            'user_id'      => get_post_meta( $post_id, '_as_appskit_pro_app_owner_id', true ),
            'app_slug'     => get_post_meta( $post_id, '_as_appskit_pro_app_slug', true ),
            'app_name'     => sanitize_text_field( $_POST['post_title'] ), // Use the CPT title as app name
            'theme_id'     => get_post_meta( $post_id, '_as_appskit_pro_theme_id', true ),
            'layout_id'    => get_post_meta( $post_id, '_as_appskit_pro_layout_id', true ),
            'settings'     => wp_json_encode( $all_app_settings ), // Store all settings as JSON
            'status'       => get_post_meta( $post_id, '_as_appskit_pro_app_status', true ),
            'last_updated' => current_time( 'mysql' ),
        );

        $existing_entry = $wpdb->get_row( $wpdb->prepare( "SELECT id FROM $table_name_apps WHERE app_post_id = %d", $post_id ) );

        if ( $existing_entry ) {
            $wpdb->update( $table_name_apps, $app_data, array( 'app_post_id' => $post_id ) );
        } else {
            $wpdb->insert( $table_name_apps, $app_data );
        }
    }
}