<?php
// Applying the Colors in CSS: saved color settings dynamically:

if ( ! defined( 'ABSPATH' ) ) exit;

// test 01
if(!function_exists('csms_sidebar_menu_dynamic_css')){
    function csms_sidebar_menu_dynamic_css() {
        $colors = get_option('csms_sidebar_menu_colors');

        if ( ! $colors ) {
            return;
        }

        $colors_css = '';

        // Main Menu Colors
        if ( ! empty( $colors['main_menu_bg'] ) ) {
            $colors_css .= '.wp-sidebar-menu .parent-item > a { background-color: ' . esc_attr( $colors['main_menu_bg'] ) . '; }';
        }

        if ( ! empty( $colors['main_menu_text'] ) ) {
            $colors_css .= '.wp-sidebar-menu .parent-item > a { color: ' . esc_attr( $colors['main_menu_text'] ) . '; }';
        }
        if ( ! empty( $colors['main_menu_hover_bg'] ) ) {
            $colors_css .= '.wp-sidebar-menu .parent-item > a:hover { background-color: ' . esc_attr( $colors['main_menu_hover_bg'] ) . '; }';
        }
        if ( ! empty( $colors['main_menu_hover_text'] ) ) {
            $colors_css .= '.wp-sidebar-menu .parent-item > a:hover { color: ' . esc_attr( $colors['main_menu_hover_text'] ) . '; }';
        }

        // Submenu Colors
        if ( ! empty( $colors['submenu_bg'] ) ) {
            $colors_css .= '.wp-sidebar-menu .submenu li a { background-color: ' . esc_attr( $colors['submenu_bg'] ) . '; }';
        }
        if ( ! empty( $colors['submenu_text'] ) ) {
            $colors_css .= '.wp-sidebar-menu .submenu li a { color: ' . esc_attr( $colors['submenu_text'] ) . '; }';
        }
        if ( ! empty( $colors['submenu_hover_bg'] ) ) {
            $colors_css .= '.wp-sidebar-menu .submenu li a:hover { background-color: ' . esc_attr( $colors['submenu_hover_bg'] ) . '; }';
        }
        if ( ! empty( $colors['submenu_hover_text'] ) ) {
            $colors_css .= '.wp-sidebar-menu .submenu li a:hover { color: ' . esc_attr( $colors['submenu_hover_text'] ) . '; }';
        }

        if ( $colors_css ) {
            wp_add_inline_style( 'wp-sidebar-menu-style', $colors_css );
        }
    }

    add_action( 'wp_enqueue_scripts', 'csms_sidebar_menu_dynamic_css' );
}

