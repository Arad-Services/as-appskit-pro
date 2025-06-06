<?php
/**
 * Template for the "Choose Your App Layout" (Step 2) page in the app creation funnel.
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
        // Include the partial for Step 2 content
        include AS_APPSKIT_PRO_PLUGIN_DIR . 'admin/partials/as-appskit-pro-onboarding-step2-partial.php';
        ?>
    </div></div><?php
get_footer(); // Use WordPress theme footer