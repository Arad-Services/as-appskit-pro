<?php
class As_Appskit_Pro_i18n {
    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'as-appskit-pro',
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );
    }
}