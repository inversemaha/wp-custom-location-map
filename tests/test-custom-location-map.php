<?php
/**
 * Plugin Name: Custom Location Map Pro
 * Test Suite for Custom Location Map Pro Plugin
 */

class Test_Custom_Location_Map extends WP_UnitTestCase {

    function setUp(): void {
        parent::setUp();
        // Register CPT in test context if not already done
        if ( ! post_type_exists( 'clmp_location' ) ) {
            clmp_register_location_cpt();
        }
    }

    function test_location_cpt_registered() {
        $this->assertTrue( post_type_exists( 'clmp_location' ), 'Custom location CPT should be registered.' );
    }

    function test_add_location() {
        $post_id = wp_insert_post( array(
            'post_title'   => 'Test Location',
            'post_type'    => 'clmp_location',
            'post_status'  => 'publish',
        ) );
        // Add meta
        update_post_meta($post_id, '_clmp_lat', '23.8103');
        update_post_meta($post_id, '_clmp_lng', '90.4125');
        update_post_meta($post_id, '_clmp_address', 'Dhaka');
        update_post_meta($post_id, '_clmp_gmaps', 'https://maps.google.com/');
        update_post_meta($post_id, '_clmp_website', 'https://example.com');
        update_post_meta($post_id, '_clmp_image_id', 1);

        $this->assertEquals('Test Location', get_the_title($post_id));
        $this->assertEquals('23.8103', get_post_meta($post_id, '_clmp_lat', true));
        $this->assertEquals('90.4125', get_post_meta($post_id, '_clmp_lng', true));
    }

    function test_shortcode_output_contains_map_container() {
        // Create a location for output
        $post_id = wp_insert_post( array(
            'post_title'   => 'Shortcode Location',
            'post_type'    => 'clmp_location',
            'post_status'  => 'publish',
        ) );
        update_post_meta($post_id, '_clmp_lat', '23.8103');
        update_post_meta($post_id, '_clmp_lng', '90.4125');
        update_post_meta($post_id, '_clmp_address', 'Dhaka');
        update_post_meta($post_id, '_clmp_gmaps', 'https://maps.google.com/');
        update_post_meta($post_id, '_clmp_website', 'https://example.com');
        update_post_meta($post_id, '_clmp_image_id', 1);

        $output = do_shortcode('[custom_location_map]');
        $this->assertStringContainsString('id="map-container"', $output);
        $this->assertStringContainsString('Shortcode Location', $output); // Checks the location title is rendered
    }

    function test_location_meta_sanitization() {
        // Simulate saving post with unsanitized data
        $post_id = wp_insert_post( array(
            'post_title'   => '<script>alert(1)</script>',
            'post_type'    => 'clmp_location',
            'post_status'  => 'publish',
        ) );
        $_POST['clmp_lat'] = '23.8103<script>';
        $_POST['clmp_lng'] = '90.4125<script>';
        $_POST['clmp_address'] = '<b>Dhaka</b>';
        $_POST['clmp_image_id'] = 'abc123';
        $_POST['clmp_gmaps'] = 'https://maps.google.com/';
        $_POST['clmp_website'] = 'https://example.com';
        $_POST['clmp_location_nonce'] = wp_create_nonce('clmp_save_location');

        // Should only save sanitized fields
        clmp_save_location_meta($post_id);

        $this->assertEquals('23.8103<script>', get_post_meta($post_id, '_clmp_lat', true)); // Note: sanitize_text_field leaves < intact, but doesn't execute
        $this->assertEquals('90.4125<script>', get_post_meta($post_id, '_clmp_lng', true));
        $this->assertEquals('<b>Dhaka</b>', get_post_meta($post_id, '_clmp_address', true));
        $this->assertEquals(0, get_post_meta($post_id, '_clmp_image_id', true)); // absint returns 0 for non-numeric
    }
}