<?php
/**
 * App Module: Header
 * This is a placeholder for a reusable module.
 *
 * @since 1.0.0
 * @param array $args Arguments passed to the module (e.g., ['title' => 'My App Header'])
 */
$title = isset( $args['title'] ) ? $args['title'] : 'Default Module Header';
?>
<div class="as-appskit-pro-module-header">
    <h2><?php echo esc_html( $title ); ?></h2>
    <p>This is a custom header module content.</p>
</div>