<?php
/**
 * Manages app layouts and templates for as-appskit-pro.
 * These are conceptually "app themes" that can be applied to new sub-sites.
 *
 * @since    1.0.0
 */
class AS_Appskit_Pro_App_Themes {

    /**
     * The ID of this plugin.
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Stores available layouts.
     * @access   private
     * @var      array    $layouts
     */
    private $layouts;

    /**
     * Stores available templates.
     * @access   private
     * @var      array    $templates
     */
    private $templates;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        $this->plugin_name = 'as-appskit-pro';
        $this->version = '1.0.0';
        $this->define_app_layouts();
        $this->define_app_templates();
    }

    /**
     * Defines the available app layouts.
     * In a real scenario, these could be loaded from JSON files or a database.
     * For now, conceptually defines 100 layouts.
     * @since 1.0.0
     */
    private function define_app_layouts() {
        $this->layouts = array();
        $base_layout_path = plugin_dir_path( __FILE__ ) . '../templates/layouts/';
        $preview_image_base_url = plugin_dir_url( __FILE__ ) . '../assets/placeholders/layout-preview-';

        for ($i = 1; $i <= 100; $i++) { // Define 100 layouts
            $preview_image_index = (($i - 1) % 5) + 1; // Cycles from 1 to 5
            $layout_file_index = (($i - 1) % 1) + 1; // Points to layout-1.php for now

            $this->layouts['layout-' . $i] = array(
                'name'  => 'Layout ' . $i . ( ($i % 5 == 0) ? ' (Popular)' : '' ), // Add some variation
                'description' => 'A unique structural layout design for your app. This layout provides a distinct arrangement for your content and modules.',
                'preview_image' => $preview_image_base_url . $preview_image_index . '.png',
                // This path is conceptual. In a real scenario, `layout-{i}.php` would exist.
                // For now, all point to layout-1.php as a placeholder base render file.
                'path'  => $base_layout_path . 'layout-' . $layout_file_index . '.php',
            );
        }
    }

    /**
     * Defines the available app templates.
     * These define visual styles and potentially initial content.
     * For now, conceptually defines 100 templates.
     * @since 1.0.0
     */
    private function define_app_templates() {
        $this->templates = array();
        $base_template_path = plugin_dir_path( __FILE__ ) . '../templates/app-templates/';
        $preview_image_base_url = plugin_dir_url( __FILE__ ) . '../assets/placeholders/template-preview-';

        for ($i = 1; $i <= 100; $i++) { // Define 100 templates
            $preview_image_index = (($i - 1) % 5) + 1; // Cycles from 1 to 5
            $template_file_index = (($i - 1) % 1) + 1; // Points to template-1.php for now

            $this->templates['template-' . $i] = array(
                'name'  => 'Template ' . $i . ( ($i % 10 == 0) ? ' (Premium)' : '' ), // Add some variation
                'description' => 'A beautiful design template that defines the visual style, colors, and fonts for your app.',
                'preview_image' => $preview_image_base_url . $preview_image_index . '.png',
                // This path is conceptual. In a real scenario, `template-{i}.php` would exist.
                // For now, all point to template-1.php as a placeholder base render file.
                'path'  => $base_template_path . 'template-' . $template_file_index . '.php',
            );
        }
    }

    /**
     * Get all defined layouts.
     * @since 1.0.0
     * @return array
     */
    public function get_all_layouts() {
        return $this->layouts;
    }

    /**
     * Get all defined templates.
     * @since 1.0.0
     * @return array
     */
    public function get_all_templates() {
        return $this->templates;
    }

    /**
     * Get a specific layout by ID.
     * @since 1.0.0
     * @param string $layout_id
     * @return array|null
     */
    public function get_layout( $layout_id ) {
        return isset( $this->layouts[ $layout_id ] ) ? $this->layouts[ $layout_id ] : null;
    }

    /**
     * Get a specific template by ID.
     * @since 1.0.0
     * @param string $template_id
     * @return array|null
     */
    public function get_template( $template_id ) {
        return isset( $this->templates[ $template_id ] ) ? $this->templates[ $template_id ] : null;
    }

    /**
     * Applies a selected app template and layout to the current blog context.
     * This function should be called after `switch_to_blog()`.
     * @since 1.0.0
     * @param string $template_id The ID of the app template.
     * @param string $layout_id The ID of the app layout.
     * @return bool
     */
    public function apply_app_template_to_site( $template_id, $layout_id ) {
        $template_data = $this->get_template( $template_id );
        $layout_data = $this->get_layout( $layout_id );

        if ( ! $template_data || ! $layout_data ) {
            error_log( 'as-appskit-pro: Invalid template or layout ID provided to apply_app_template_to_site. Template: ' . $template_id . ', Layout: ' . $layout_id );
            return false;
        }

        // --- Core logic for applying template/layout ---
        // This is where you would activate a specific theme or child theme for the new site.
        // For example, if you have a base theme named 'as-app-base-theme'
        // and your templates are child themes or configurations of it:
        // switch_theme( 'as-app-base-theme' );
        // Then, apply template-specific options:
        // update_option( 'as_app_template_id', $template_id );
        // update_option( 'as_app_layout_id', $layout_id );

        // Example: Create a dummy page and set it as homepage for the new site
        $homepage_title = sprintf( __( 'Welcome to My %s App!', 'as-appskit-pro' ), $template_data['name'] );
        // Embed layout and template info as HTML comments for future editor parsing
        $homepage_content = '';
        $homepage_content .= '';
        $homepage_content .= '<div class="as-app-content-wrapper">'; // Placeholder for content area
        $homepage_content .= '<p>This is your new app\'s homepage, generated with <strong>' . esc_html($template_data['name']) . '</strong> template and <strong>' . esc_html($layout_data['name']) . '</strong> layout.</p>';
        $homepage_content .= '<p>You can edit this content using the as-appskit-pro editor!</p>';
        $homepage_content .= '</div>'; // Close content wrapper


        $homepage_id = wp_insert_post( array(
            'post_title'    => $homepage_title,
            'post_content'  => $homepage_content,
            'post_status'   => 'publish',
            'post_type'     => 'page',
        ) );

        if ( $homepage_id && ! is_wp_error( $homepage_id ) ) {
            // Set the newly created page as the front page
            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $homepage_id );
            // Update the blog name to match the app title for consistency
            update_option( 'blogname', $homepage_title );

            // Example: Add a sample module to the homepage (conceptual for now)
            // This is conceptual. The drag & drop editor will manage this more granularly.
            // update_post_meta( $homepage_id, '_as_appskit_pro_page_modules', array( 'module-header', 'text_block' ) );

            error_log( 'as-appskit-pro: Applied template ' . $template_id . ' and layout ' . $layout_id . ' to new site ID ' . get_current_blog_id() . ' with homepage ID ' . $homepage_id );
        } else {
            error_log( 'as-appskit-pro: Failed to create homepage for new site: ' . print_r($homepage_id, true) );
        }

        return true;
    }


    /**
     * Run the app themes actions.
     * @since    1.0.0
     */
    public function run() {
        // No direct actions for now, mainly public methods.
        // In a more advanced version, this would include hooks for theme registration, etc.
    }
}