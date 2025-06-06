<?php
class As_Appskit_Pro_User_Dashboard {
    private $plugin_name;
    private $version;
    public function __construct($plugin_name, $version) { /* ... */ }
    public function enqueue_onboarding_styles() { /* ... */ }
    public function enqueue_onboarding_scripts() { /* ... */ }
    public function ajax_save_app_config() { /* ... */ wp_die(); }
    public function ajax_trigger_native_build() { /* ... */ wp_die(); }
    public function ajax_submit_support_ticket() { /* ... */ wp_die(); }
    public function ajax_submit_support_ticket_nopriv() { /* ... */ wp_die(); }
}