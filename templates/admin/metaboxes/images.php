<?php
/**
 * This file controls the property images meta box.
 */

# Exit if accessed directly
defined('ABSPATH') or exit;

// Include the global post object.
global $post;

// Ensure that $post is an instance of WP_Post.
if (!$post instanceof WP_Post) {
    return;  // Exit early if $post isn't valid.
}

// Create nonce field.
wp_nonce_field('wpea', 'wpea_images_nonce');

// Get edit link.
$edit_link = esc_url(get_upload_iframe_src('image', $post->ID));

// Get the images.
$images = json_decode(get_post_meta(get_the_ID(), 'wpea_images', true));
?>

<ul class="wpea-img-container">
<?php
if (!empty($images)) :
    foreach ($images as $img_id) : ?>
        <li class="wpea-img" id="img-<?php echo $img_id; ?>">
            <a class="wpea-button-delete ir" href="javascript:void(0);"><?php _e('Delete', WPEA_PLUGIN_NAME); ?></a>
            <?php echo wp_get_attachment_image($img_id, 'thumbnail'); ?>
        </li>
    <?php endforeach;
endif; ?>
</ul>

<input class="wpea-img-ids" name="wpea-images-ids" type="hidden" value="<?php echo is_array($images) ? implode(',', $images) : ''; ?>" />
<a href="javascript:void(0);" class="alignright button wpea-button-add"><?php _e('Add images', WPEA_PLUGIN_NAME); ?></a>

<?php
/**
 * Save meta box content.
 */
function wpea_save_property_images($post_id) {

    // Check if our nonce is set.
    if (!isset($_POST['wpea_images_nonce'])) {
        return $post_id;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['wpea_images_nonce'], 'wpea')) {
        return $post_id;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // Save/update the meta data
    if (isset($_POST['wpea-images-ids'])) {
        $image_ids = explode(',', sanitize_text_field($_POST['wpea-images-ids']));
        update_post_meta($post_id, 'wpea_images', json_encode($image_ids));
    }
}
add_action('save_post', 'wpea_save_property_images');
