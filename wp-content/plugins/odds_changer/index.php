<?php
/**
 * Plugin Name: Odds changer
 * Version: 1.0
 * Author: anton
 **/

function odds_changer_initPlugin()
{
    //adding page to dashboard menu
    add_menu_page("Odds Changer", 'Odds Changer', 'administrator', "Odds Changer", 'displaySettingsPage', 'dashicons-sos', 26);

    //showing front end component if plugin active
    if (function_exists('displaySettingsPage')) {
        odds_changer_inject();
    }
}
add_action('admin_menu', 'odds_changer_initPlugin', 9);

function odds_changer_inject()
{
    if(!is_admin()) {
        $class = get_option('odds_changer_setting_odds_class')['odds_class'];
        require_once 'partials/odds_change_component.php';
    }
}
add_action('get_footer', 'odds_changer_inject');

function odds_changer_enqueue_script() {
    wp_enqueue_style( 'odds_changer_style', plugin_dir_url( __FILE__ ) . 'src/odds_plugin_style.css');
    wp_enqueue_script( 'odds_changer_script', plugin_dir_url( __FILE__ ) . 'src/odds_plugin_script.js', array(), time() );
}
add_action('wp_enqueue_scripts', 'odds_changer_enqueue_script');

//displaying form
function displaySettingsPage()
{
    require_once 'partials/settings.php';
}

//registering sections and text fields
function register_settings()
{
    register_setting('odds_changer_options', 'odds_changer_setting_odds_class');
    add_settings_section('odds_changer_settings', 'Odds Changer Settings', 'odds_changer_section_text_callback', 'odds_changer');

    add_settings_field('odds_changer_setting_odds_class', 'Odds Class', 'odds_changer_setting_odds_class', 'odds_changer', 'odds_changer_settings');
}

add_action('admin_init', 'register_settings');

function odds_changer_section_text_callback()
{
    echo 'Put the class name of the odds to change.';
}

//text field settings for class name
function odds_changer_setting_odds_class()
{
    $settings = (array)get_option('odds_changer_setting_odds_class');
    $field = "odds_class";
    $value = esc_attr($settings[$field]);

    echo "<input type='text' name='odds_changer_setting_odds_class[$field]' value='$value' />";
}

//input for field in wp_options
function odds_changer_options_submit($input)
{
    $output['odds_class'] = sanitize_text_field($input ['odds_class']);

    return $output;
}
