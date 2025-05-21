<?php
/*
Plugin Name: Custom Location Map Pro
Description: Displays a Google Map with dynamic locations managed in WP admin, each with a custom modal. Use [custom_location_map] shortcode.
Version: 1.0
Author: Your Name
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define('CLMP_PATH', plugin_dir_path(__FILE__));
define('CLMP_URL', plugin_dir_url(__FILE__));

// Admin and frontend
require_once CLMP_PATH . 'admin/admin.php';
require_once CLMP_PATH . 'public/public.php';

// Enqueue assets
function clmp_enqueue_assets() {
    // Frontend
    if (!is_admin()) {
        wp_enqueue_style('clmp-style', CLMP_URL . 'assets/style.css', array(), '1.0');
        wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBD_app7H1gXu6DgyeEvf4KI6BSYxWSiwY', array(), null, true);
        wp_enqueue_script('clmp-map', CLMP_URL . 'assets/map.js', array('google-maps-api'), '1.0', true);
    }
    // Admin
    if (is_admin()) {
        wp_enqueue_script('clmp-admin', CLMP_URL . 'assets/admin.js', array('jquery'), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'clmp_enqueue_assets');
add_action('admin_enqueue_scripts', 'clmp_enqueue_assets');