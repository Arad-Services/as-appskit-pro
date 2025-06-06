<?php
/**
 * Template for the "Add and Edit Your App Modules" (Step 3) page in the app creation funnel.
 *
 * This page will contain the core drag-and-drop app builder interface.
 *
 * @package As_Appskit_Pro
 * @subpackage Public/Views
 * @version 4.0.1
 */

get_header(); // Use WordPress theme header
?>

<div class="wrap as-appskit-pro-onboarding-page">
    <div class="container py-5">
        <?php
        // Include the partial for Step 3 content
        include AS_APPSKIT_PRO_PLUGIN_DIR . 'admin/partials/as-appskit-pro-onboarding-step3-partial.php';
        ?>
    </div></div><?php
get_footer(); // Use WordPress theme footer