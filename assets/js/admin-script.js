/**
 * Admin-specific JavaScript for as-appskit-pro Plugin (Version 4.0.1)
 *
 * This file handles functionalities specific to the WordPress Network Admin area,
 * including media uploader integration for image fields and color picker initialization.
 */

jQuery(document).ready(function($) {

    // Initialize WordPress Media Uploader for image fields
    $(document).on('click', '.as-appskit-pro-upload-button', function(e) {
        e.preventDefault();

        var button = $(this);
        var targetField = $(button.data('target-field')); // Input field to store URL
        var targetImage = $(button.data('target-image')); // Image tag for preview

        var customUploader = wp.media({
            title: 'Select Image',
            library: { type: 'image' }, // Restrict to image files
            button: { text: 'Select' },
            multiple: false // Allow only one image to be selected
        }).on('select', function() {
            var attachment = customUploader.state().get('selection').first().toJSON();
            targetField.val(attachment.url); // Set the URL in the input field
            if (targetImage.length) {
                targetImage.attr('src', attachment.url).show(); // Update and show image preview
            }
        }).open();
    });

    // Initialize WordPress Color Picker for color input fields
    $('.as-appskit-pro-color-picker').wpColorPicker();

    // Handle tab switching for the settings page (if using manual tabs like in settings.php)
    $('.nav-tab-wrapper a').on('click', function(e) {
        // Prevent default tab behavior if it's not a link to another page
        // e.preventDefault(); // Uncomment if you want JS to handle content loading/showing
        // If clicking on a tab just changes the URL (like current setup), no JS needed here beyond initial active state.
        // The PHP handles which partial to include based on $_GET['tab']
    });

    // You can add more admin-specific JS here, e.g., for form validation, dynamic elements
    // For instance, if you have conditional fields based on checkboxes, you'd add that logic here.
});