<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Add settings page to the admin menu
if(!function_exists('csms_sidebar_menu_add_settings_page')){
    function csms_sidebar_menu_add_settings_page() {
    add_options_page(
        'WP Sidebar Menu Settings', // Page title
        'Sidebar Menu', // Menu title
        'manage_options', // Capability
        'csms-sidebar-menu', // Menu slug
        'csms_sidebar_menu_render_settings_page' // Callback function
        );
    }

    add_action('admin_menu', 'csms_sidebar_menu_add_settings_page');
}

// Render settings page content
if(!function_exists('csms_sidebar_menu_render_settings_page')){
    function csms_sidebar_menu_render_settings_page() {
        ?>
        <div class="wrap">
            <h1>WP Sidebar Menu Settings</h1>
            <p>To display the sidebar menu on your site, use the following shortcode:</p>
            <pre><code>[csms_sidebar_menu]</code></pre>
            <p>Select the menu you want to display from the dropdown below. This menu will be used to populate the sidebar menu on your site.</p>
            <form method="post" action="options.php">
                <?php
                settings_fields('csms_sidebar_menu_options');
                do_settings_sections('csms-sidebar-menu');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}

// Register settings
if(!function_exists('csms_sidebar_menu_register_settings')){
    function csms_sidebar_menu_register_settings() {
        // Register the menu selection setting
        register_setting('csms_sidebar_menu_options', 'csms_sidebar_menu_selected_menu');
        
        // Register color settings
        register_setting('csms_sidebar_menu_options', 'csms_sidebar_menu_colors');

        // Add main section
        add_settings_section(
            'csms_sidebar_menu_main_section',
            'Main Settings',
            null,
            'csms-sidebar-menu'
        );

        // Add menu select field
        add_settings_field(
            'csms_sidebar_menu_selected_menu',
            'Select Menu',
            'csms_sidebar_menu_menu_select_callback',
            'csms-sidebar-menu',
            'csms_sidebar_menu_main_section'
        );

        // Add color settings section
        add_settings_section(
            'csms_sidebar_menu_colors_section',
            'Design Options',
            'csms_sidebar_menu_colors_section_callback',
            'csms-sidebar-menu'
        );

        // Add Main Menu Color Settings heading
        add_settings_section(
            'csms_sidebar_menu_main_menu_color_section',
            'Main Menu Color Settings',
            null,
            'csms-sidebar-menu'
        );

        // Add color fields for main menu
        $main_menu_color_fields = [
            'main_menu_bg' => 'Main Menu Background Color',
            'main_menu_text' => 'Main Menu Text Color',
            'main_menu_hover_bg' => 'Main Menu Hover Background Color',
            'main_menu_hover_text' => 'Main Menu Hover Text Color',
        ];

        foreach ($main_menu_color_fields as $field => $label) {
            add_settings_field(
                "csms_sidebar_menu_colors[$field]",
                $label,
                'csms_sidebar_menu_color_picker_callback',
                'csms-sidebar-menu',
                'csms_sidebar_menu_main_menu_color_section',
                [
                    'label_for' => "csms_sidebar_menu_colors_$field",
                    'option_name' => 'csms_sidebar_menu_colors',
                    'field_name' => $field
                ]
            );
        }

        // Add Submenu Color Settings heading
        add_settings_section(
            'csms_sidebar_menu_submenu_color_section',
            'Submenu Color Settings',
            null,
            'csms-sidebar-menu'
        );

        // Add color fields for submenu
        $submenu_color_fields = [
            'submenu_bg' => 'Submenu Background Color',
            'submenu_text' => 'Submenu Text Color',
            'submenu_hover_bg' => 'Submenu Hover Background Color',
            'submenu_hover_text' => 'Submenu Hover Text Color',
        ];

        foreach ($submenu_color_fields as $field => $label) {
            add_settings_field(
                "csms_sidebar_menu_colors[$field]",
                $label,            
                'csms_sidebar_menu_color_picker_callback',
                'csms-sidebar-menu',
                'csms_sidebar_menu_submenu_color_section',
                [
                    'label_for' => "csms_sidebar_menu_colors_$field",
                    'option_name' => 'csms_sidebar_menu_colors',
                    'field_name' => $field
                ]
            );
        }
    }

    add_action('admin_init', 'csms_sidebar_menu_register_settings');
}

// Callback for menu select dropdown
if(!function_exists('csms_sidebar_menu_menu_select_callback')){
    function csms_sidebar_menu_menu_select_callback() {
        $menus = wp_get_nav_menus();
        $selected_menu = get_option('csms_sidebar_menu_selected_menu');
        echo '<select name="csms_sidebar_menu_selected_menu">';
        foreach ($menus as $menu) {
            $selected = ($menu->term_id == $selected_menu) ? 'selected="selected"' : '';
            echo '<option value="' . esc_attr( $menu->term_id ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $menu->name ) . '</option>';
        }
        echo '</select>';
    }
}


// Callback for colors section description
if(!function_exists('csms_sidebar_menu_colors_section_callback')){
    function csms_sidebar_menu_colors_section_callback() {
        echo '<p>Customize the colors for the main menu and submenu items.</p>';
    }
}

// Callback for color picker fields
if(!function_exists('csms_sidebar_menu_color_picker_callback')){
    function csms_sidebar_menu_color_picker_callback($args) {
        $option_name = $args['option_name'];
        $field_name = $args['field_name'];
        $options = get_option($option_name);
        $value = isset($options[$field_name]) ? $options[$field_name] : '';

        echo '<input type="text" id="' . esc_attr($args['label_for']) . '" name="' . esc_attr($option_name) . '[' . esc_attr($field_name) . ']' . '" value="' . esc_attr($value) . '" class="wp-color-picker-field" />';
    }
}
