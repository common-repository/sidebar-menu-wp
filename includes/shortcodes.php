<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

// Register shortcode
if(!function_exists('csms_sidebar_menu_shortcode')){
    function csms_sidebar_menu_shortcode($atts) {
        $menu_id = get_option('csms_sidebar_menu_selected_menu'); // Get the selected menu from settings

        if (empty($menu_id)) {
            return '<p>No menu selected. Please select a menu from the settings page.</p>';
        }

        $menu_items = wp_get_nav_menu_items($menu_id);

        if (!$menu_items) {
            return '<p>No menu found!</p>';
        }

        // Build a hierarchical array from menu items
        $menu_tree = array();
        $menu_map = array();

        foreach ($menu_items as $item) {
            $item_id = $item->ID;
            $item_parent_id = $item->menu_item_parent;

            // Initialize item in the map
            if (!isset($menu_map[$item_id])) {
                $menu_map[$item_id] = array(
                    'title' => isset($item->title) ? $item->title : 'No Title',
                    'url' => isset($item->url) ? $item->url : '#',
                    'children' => array()
                );
            }

            if ($item_parent_id == 0) {
                // Root items
                $menu_tree[$item_id] = &$menu_map[$item_id];
            } else {
                // Submenu items
                if (!isset($menu_map[$item_parent_id])) {
                    $menu_map[$item_parent_id] = array(
                        'title' => '',
                        'url' => '',
                        'children' => array()
                    );
                }
                $menu_map[$item_parent_id]['children'][$item_id] = &$menu_map[$item_id];
            }
        }

        if(!function_exists('build_menu_html')){
            function build_menu_html($items, $depth = 0) {
                $html = '';
                if (!empty($items)) {
                    // Apply depth classes starting from depth-1 for submenus
                    $submenu_class = $depth > 0 ? 'submenu level-' . $depth : '';
                    $html .= '<ul' . ($submenu_class ? ' class="' . esc_attr($submenu_class) . '"' : '') . '>';
                    foreach ($items as $item) {
                        $has_children = !empty($item['children']);
                        $html .= '<li class="' . ($has_children ? 'parent-item has-submenu' : 'parent-item') . '">';
                        $html .= '<a href="' . esc_url($item['url']) . '">' . esc_html($item['title']) . '</a>';
                        if ($has_children) {
                            $html .= build_menu_html($item['children'], $depth + 1);
                        }
                        $html .= '</li>';
                    }
                    $html .= '</ul>';
                }
                return $html;
            }
        }
        
        // Get the menu name for adding as a class
        $menu_name = wp_get_nav_menu_object($menu_id)->name;
        $menu_class_name = sanitize_title($menu_name); // Create a safe class name from the menu name
        
        // Build the HTML for root-level menu items
        $menu_html = '<div class="wp-sidebar-menu">';
        $menu_html .= '<div class="main-menu-wrapper ' . esc_attr($menu_class_name) . '">';
        $menu_html .= build_menu_html($menu_tree); // Start with depth 0 for the main menu
        $menu_html .= '</div>'; // Closing the ul for main-menu-wrapper
        $menu_html .= '</div>'; // Closing the div for wp-sidebar-menu
        
        return $menu_html;
    }

    add_shortcode('csms_sidebar_menu', 'csms_sidebar_menu_shortcode');
}


