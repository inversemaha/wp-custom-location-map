<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Register Custom Post Type for Locations
function clmp_register_location_cpt() {
    $labels = array(
        'name' => 'Locations',
        'singular_name' => 'Location',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Location',
        'edit_item' => 'Edit Location',
        'new_item' => 'New Location',
        'all_items' => 'All Locations',
        'view_item' => 'View Location',
        'search_items' => 'Search Locations',
        'not_found' => 'No locations found',
        'not_found_in_trash' => 'No locations found in Trash',
        'menu_name' => 'Locations'
    );
    $args = array(
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-location-alt',
        'supports' => array( 'title' ),
    );
    register_post_type( 'clmp_location', $args );
}
add_action( 'init', 'clmp_register_location_cpt' );

// Add meta boxes
function clmp_add_location_meta_boxes() {
    add_meta_box(
        'clmp_location_fields',
        'Location Details',
        'clmp_location_fields_callback',
        'clmp_location',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'clmp_add_location_meta_boxes' );

function clmp_location_fields_callback( $post ) {
    wp_nonce_field( 'clmp_save_location', 'clmp_location_nonce' );
    $lat = get_post_meta( $post->ID, '_clmp_lat', true );
    $lng = get_post_meta( $post->ID, '_clmp_lng', true );
    $address = get_post_meta( $post->ID, '_clmp_address', true );
    $image_id = get_post_meta( $post->ID, '_clmp_image_id', true );
    $gmaps = get_post_meta( $post->ID, '_clmp_gmaps', true );
    $website = get_post_meta( $post->ID, '_clmp_website', true );
    ?>
    <p>
        <label for="clmp_lat">Latitude:</label><br>
        <input type="text" id="clmp_lat" name="clmp_lat" value="<?php echo esc_attr($lat); ?>" style="width:100%;" required />
    </p>
    <p>
        <label for="clmp_lng">Longitude:</label><br>
        <input type="text" id="clmp_lng" name="clmp_lng" value="<?php echo esc_attr($lng); ?>" style="width:100%;" required />
    </p>
    <p>
        <label for="clmp_address">Address:</label><br>
        <textarea id="clmp_address" name="clmp_address" style="width:100%;" required><?php echo esc_textarea($address); ?></textarea>
    </p>
    <p>
        <label for="clmp_image">Image:</label><br>
        <?php
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
        ?>
        <input type="hidden" id="clmp_image_id" name="clmp_image_id" value="<?php echo esc_attr($image_id); ?>" />
        <img id="clmp_image_preview" src="<?php echo esc_url($image_url); ?>" style="max-width:200px;display:<?php echo $image_url ? 'block':'none'; ?>" /><br>
        <button type="button" class="button" id="clmp_image_upload">Select Image</button>
        <button type="button" class="button" id="clmp_image_remove" style="<?php echo $image_url ? '':'display:none;'; ?>">Remove Image</button>
    </p>
    <p>
        <label for="clmp_gmaps">Directions Link:</label><br>
        <input type="url" id="clmp_gmaps" name="clmp_gmaps" value="<?php echo esc_url($gmaps); ?>" style="width:100%;" placeholder="https://www.google.com/maps/dir/?api=1&destination=..." />
    </p>
    <p>
        <label for="clmp_website">Website:</label><br>
        <input type="url" id="clmp_website" name="clmp_website" value="<?php echo esc_url($website); ?>" style="width:100%;" placeholder="https://example.com" />
    </p>
    <?php
}

// Save meta box data securely
function clmp_save_location_meta( $post_id ) {
    if ( ! isset( $_POST['clmp_location_nonce'] ) || ! wp_verify_nonce( $_POST['clmp_location_nonce'], 'clmp_save_location' ) ) return;
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset($_POST['clmp_lat']) ) update_post_meta( $post_id, '_clmp_lat', sanitize_text_field($_POST['clmp_lat']) );
    if ( isset($_POST['clmp_lng']) ) update_post_meta( $post_id, '_clmp_lng', sanitize_text_field($_POST['clmp_lng']) );
    if ( isset($_POST['clmp_address']) ) update_post_meta( $post_id, '_clmp_address', sanitize_textarea_field($_POST['clmp_address']) );
    if ( isset($_POST['clmp_image_id']) ) update_post_meta( $post_id, '_clmp_image_id', absint($_POST['clmp_image_id']) );
    if ( isset($_POST['clmp_gmaps']) ) update_post_meta( $post_id, '_clmp_gmaps', esc_url_raw($_POST['clmp_gmaps']) );
    if ( isset($_POST['clmp_website']) ) update_post_meta( $post_id, '_clmp_website', esc_url_raw($_POST['clmp_website']) );
}
add_action( 'save_post', 'clmp_save_location_meta' );