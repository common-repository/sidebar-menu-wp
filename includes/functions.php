<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Include settings page
require_once plugin_dir_path(__FILE__) . './settings-page.php';

// Include dynamic color settings file
require_once plugin_dir_path(__FILE__) . './submenu-dynamic-color.php';

// Include shortcodes
require_once plugin_dir_path(__FILE__) . './shortcodes.php';

// Add settings link to plugin action links
if(!function_exists('csms_sidebar_menu_add_action_links')){
    // Current Plugin Base File
    $plugin_file = dirname(plugin_basename(__DIR__)).'/wp-sidebar-menu.php';
    function csms_sidebar_menu_add_action_links($links) {
        // Add the settings link
        $settings_link = '<a href="options-general.php?page=csms-sidebar-menu">' . __('Settings') . '</a>';
        
        // Add the settings link before the "Deactivate" link
        array_unshift($links, $settings_link);
        
        return $links;
    }
    
    add_filter('plugin_action_links_' . $plugin_file, 'csms_sidebar_menu_add_action_links');
}





