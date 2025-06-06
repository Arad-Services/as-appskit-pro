<?php
/**
 * Template for the "Publish Your New App" (Step 4) page in the app creation funnel.
 *
 * This is the final step where the user can publish their app or download packages.
 *
 * @package As_Appskit_Pro
 * @subpackage Public/Views
 * @version 4.0.1
 */

get_header(); // Use WordPress theme header
?>

<div class="wrap as-appskit-pro-onboarding-page">
    <div class="container py-5" id="publish-app-section">
        <?php
        // Include the partial for Step 4 content
        include AS_APPSKIT_PRO_PLUGIN_DIR . 'admin/partials/as-appskit-pro-onboarding-step4-partial.php';
        ?>
    </div></div><?php
get_footer(); // Use WordPress theme footer