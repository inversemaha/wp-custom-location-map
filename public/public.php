<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Shortcode to display map
function clmp_map_shortcode() {
    $locations = get_posts( array(
        'post_type' => 'clmp_location',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ));
    $data = array();
    foreach( $locations as $loc ) {
        $data[] = array(
            'name'    => esc_html($loc->post_title),
            'lat'     => esc_attr(get_post_meta($loc->ID, '_clmp_lat', true)),
            'lng'     => esc_attr(get_post_meta($loc->ID, '_clmp_lng', true)),
            'address' => esc_html(get_post_meta($loc->ID, '_clmp_address', true)),
            'image'   => get_post_meta($loc->ID, '_clmp_image_id', true) ? esc_url(wp_get_attachment_image_url(get_post_meta($loc->ID, '_clmp_image_id', true), 'medium')) : '',
            'gmaps'   => esc_url(get_post_meta($loc->ID, '_clmp_gmaps', true)),
            'website' => esc_url(get_post_meta($loc->ID, '_clmp_website', true)),
        );
    }
    ob_start();
    include CLMP_PATH . 'templates/map-modal.php';
    return ob_get_clean();
}
add_shortcode('custom_location_map', 'clmp_map_shortcode');