<div class="wrap as-appskit-pro-admin-wrap">
    <h1><?php esc_html_e( 'as-appskit-pro Settings', 'as-appskit-pro' ); ?></h1>

    <form method="post" action="options.php">
        <?php
        settings_fields( 'as_appskit_pro_options_group' ); // Outputs nonce, action, and option_page fields
        do_settings_sections( 'as-appskit-pro' );           // Outputs all registered sections and fields for 'as-appskit-pro' page
        submit_button();                                   // Outputs a submit button
        ?>
    </form>
</div>