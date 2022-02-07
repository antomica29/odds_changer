<?php
/**
 * Plugin Name: Odds changer
 * Version: 1.0
 * Author: anton
 **/

//adding page to dashboard menu
function addPluginAdminMenu() {
    add_menu_page(  "Odds Changer", 'Odds Changer', 'administrator', "Odds Changer", 'displaySettingsPage', 'dashicons-sos', 26 );
}
add_action('admin_menu', 'addPluginAdminMenu', 9);

//displaying form
function displaySettingsPage() {
    require_once 'partials/settings.php';
}

//registering sections and text fields
function register_settings() {
    register_setting( 'odds_changer_options', 'odds_changer_setting_odds_class');
    add_settings_section( 'odds_changer_settings', 'Odds Changer Settings', 'odds_changer_section_text_callback', 'odds_changer' );

    add_settings_field( 'odds_changer_setting_odds_class', 'Odds Class', 'odds_changer_setting_odds_class', 'odds_changer', 'odds_changer_settings' );
}
add_action( 'admin_init', 'register_settings' );

function odds_changer_section_text_callback() {
    echo 'Put the class name of the odds to change.';
}

//text field settings for class name
function odds_changer_setting_odds_class() {
    $settings = (array) get_option( 'odds_changer_setting_odds_class' );
    $field = "odds_class";
    $value = esc_attr( $settings[$field] );

    echo "<input type='text' name='odds_changer_setting_odds_class[$field]' value='$value' />";
}

//input for field in wp_options
function odds_changer_options_submit($input ){
    $output['odds_class'] = sanitize_text_field( $input ['odds_class'] );

    return $output;
}