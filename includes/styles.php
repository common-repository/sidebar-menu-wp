<?php 

if ( ! defined( 'ABSPATH' ) ) exit;



// Enqueue styles and scripts
if(!function_exists('csms_sidebar_menu_enqueue_scripts')){
    function csms_sidebar_menu_enqueue_scripts() {
        $version = '1.0.4'; // Use plugin version here or file version

        // Frontend styles and scripts
        wp_register_style(
            'wp-sidebar-menu-style', 
            plugin_dir_url(__FILE__) . '../css/style.css', 
            array(), // Dependencies
            $version // Version number
        );
        
        wp_register_style(
            'wp-sidebar-menu-fix', 
            plugin_dir_url(__FILE__) . '../css/fix.css', 
            array(), 
            $version
        );
        
        wp_register_script(
            'wp-sidebar-menu-script', 
            plugin_dir_url(__FILE__) . '../js/script.js', 
            array('jquery'), 
            $version, // Version number
            true // Load in footer
        );

        wp_enqueue_style('wp-sidebar-menu-style');
        wp_enqueue_style('wp-sidebar-menu-fix');
        wp_enqueue_script('wp-sidebar-menu-script');
    }

    add_action('wp_enqueue_scripts', 'csms_sidebar_menu_enqueue_scripts');
}


// Admin styles and scripts (only for settings page)
if(!function_exists('csms_admin_enqueue_scripts')){
    function csms_admin_enqueue_scripts(){
        wp_enqueue_style('wp-color-picker');

        // Dynamically set the version based on the file's last modification time
        $script_version = filemtime(plugin_dir_path(__FILE__) . '../js/settings-color.js');

        wp_register_script(
            'wp-sidebar-menu-color-script', 
            plugin_dir_url(__FILE__) . '../js/settings-color.js', 
            array('wp-color-picker'), 
            $script_version,  // Version number based on file modification time
            true // Load in footer
        );

        wp_enqueue_script('wp-sidebar-menu-color-script');
    }

    add_action('admin_enqueue_scripts', 'csms_admin_enqueue_scripts');
}
