<?php
/**
 * Plugin Name: Get The Image
 * Plugin URI: http://justintadlock.com/archives/2008/05/27/get-the-image-wordpress-plugin
 * Description: This is a highly intuitive script that can grab an image by custom field input, post attachment, or extracting it from the post's content.
 * Version: 0.4
 * Author: Justin Tadlock
 * Author URI: http://justintadlock.com
 *
 * Get the Image was created to solve a problem in the WordPress community about how to handle
 * post-specific images. It was created to be a highly-intuitive image script that loads images that are 
 * related to specific posts in some way.  It creates an image-based representation of a WordPress 
 * post (or any post type).
 *
 * @copyright 2008 - 2009
 * @version 0.4
 * @author Justin Tadlock
 * @link http://justintadlock.com/archives/2008/05/27/get-the-image-wordpress-plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package GetTheImage
 */

/* Adds theme support for post images. */
add_theme_support( 'post-thumbnails' );

/**
 * This is a highly intuitive function that gets images.  It first calls for custom field keys. If no 
 * custom field key is set, check for the_post_thumbnail().  If no post image, check for images 
 * attached to post. Check for image order if looking for attached images.  Scan the post for 
 * images if $image_scan = true.  Check for default image if $default_image = true. If an image 
 * is found, call display_the_image() to format it.
 *
 * @since 0.1
 * @global $post The current post's DB object.
 * @param array $args Parameters for what image to get.
 * @return string|array The HTML for the image. | Image attributes in an array.
 */
function get_the_image( $args = array() ) {
	global $post;

	/* Set the default arguments. */
	$defaults = array(
		'custom_key' => array( 'Thumbnail', 'thumbnail' ),
		'post_id' => $post->ID,
		'attachment' => true,
		'the_post_thumbnail' => true, // WP 2.9+ image function
		'default_size' => 'thumbnail',
		'default_image' => false,
		'order_of_image' => 1,
		'link_to_post' => true,
		'image_class' => false,
		'image_scan' => false,
		'width' => false,
		'height' => false,
		'format' => 'img',
		'echo' => true
	);

	/* Allow plugins/themes to filter the arguments. */
	$args = apply_filters( 'get_the_image_args', $args );

	/* Merge the input arguments and the defaults. */
	$args = wp_parse_args( $args, $defaults );

	/* Extract the array to allow easy use of variables. */
	extract( $args );

	/* If a custom field key (array) is defined, check for images by custom field. */
	if ( $custom_key )
		$image = image_by_custom_field( $args );

	/* If no image found and $the_post_thumbnail is set to true, check for a post image (WP feature). */
	if ( !$image && $the_post_thumbnail )
		$image = image_by_the_post_thumbnail( $args );

	/* If no image found and $attachment is set to true, check for an image by attachment. */
	if ( !$image && $attachment )
		$image = image_by_attachment( $args );

	/* If no image found and $image_scan is set to true, scan the post for images. */
	if ( !$image && $image_scan )
		$image = image_by_scan( $args );

	/* If no image found and a $default_image is set, get the default image. */
	if ( !$image && $default_image )
		$image = image_by_default( $args );

	/* If an image is returned, run it through the display function. */
	if ( $image )
		$image = display_the_image( $args, $image );

	/* Allow plugins/theme to override the final output. */
	$image = apply_filters( 'get_the_image', $image );

	/* Display the image if $echo is set to true and the $format isn't an array. Else, return the image. */
	if ( $echo && 'array' !== $format )
		echo $image;
	else
		return $image;
}

/* Internal Functions */

/**
 * Calls images by custom field key.  Script loops through multiple custom field keys.
 * If that particular key is found, $image is set and the loop breaks.  If an image is 
 * found, it is returned.
 *
 * @since 0.3
 * @param array $args
 * @return array|bool
 */
function image_by_custom_field( $args = array() ) {

	/* If $custom_key is a string, we want to split it by spaces into an array. */
	if ( !is_array( $args['custom_key'] ) )
		$args['custom_key'] = preg_split( '#\s+#', $args['custom_key'] );

	/* If $custom_key is set, loop through each custom field key, searching for values. */
	if ( isset( $args['custom_key'] ) ) {
		foreach ( $args['custom_key'] as $custom ) {
			$image = get_metadata( 'post', $args['post_id'], $custom, true );
			if ( $image )
				break;
		}
	}

	/* If a custom key value has been given for one of the keys, return the image URL. */
	if ( $image )
		return array( 'url' => $image );

	return false;
}

/**
 * Checks for images using a custom version of the WordPress 2.9+ get_the_post_thumbnail()
 * function.  If an image is found, return it and the $post_thumbnail_id.  The WordPress function's
 * other filters are later added in the display_the_image() function.
 *
 * @since 0.4
 * @param array $args
 * @return array|bool
 */
function image_by_the_post_thumbnail( $args = array() ) {

	/* Check for a post image ID (set by WP as a custom field). */
	$post_thumbnail_id = get_post_thumbnail_id( $args['post_id'] );

	/* If no post image ID is found, return false. */
	if ( empty( $post_thumbnail_id ) )
		return false;

	/* Apply filters on post_thumbnail_size because this is a default WP filter used with its image feature. */
	$size = apply_filters( 'post_thumbnail_size', $args['default_size'] );

	/* Get the attachment image source.  This should return an array. */
	$image = wp_get_attachment_image_src( $post_thumbnail_id, $size );

	/* Return both the image URL and the post thumbnail ID. */
	return array( 'url' => $image[0], 'post_thumbnail_id' => $post_thumbnail_id );
}

/**
 * Check for attachment images.  Uses get_children() to check if the post has images 
 * attached.  If image attachments are found, loop through each.  The loop only breaks 
 * once $order_of_image is reached.
 *
 * @since 0.3
 * @param array $args
 * @return array|bool
 */
function image_by_attachment( $args = array() ) {

	/* Get attachments for the inputted $post_id. */
	$attachments = get_children( array( 'post_parent' => $args['post_id'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) );

	/* If no attachments are found, return false. */
	if ( empty( $attachments ) )
		return false;

	/* Loop through each attachment. Once the $order_of_image (default is '1') is reached, break the loop. */
	foreach ( $attachments as $id => $attachment ) {
		if ( ++$i == $args['order_of_image'] ) {
			$image = wp_get_attachment_image_src( $id, $args['default_size'] );
			break;
		}
	}

	/* Return the image URL. */
	return array( 'url' => $image[0] );
}

/**
 * Scans the post for images within the content.  Not called by default with get_the_image().
 * Shouldn't use if using large images within posts, better to use the other options.
 *
 * @since 0.3
 * @global $post The current post's DB object.
 * @param array $args
 * @return array|bool
 */
function image_by_scan( $args = array() ) {

	/* Search the post's content for the <img /> tag and get its URL. */
	preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $args['post_id'] ), $matches );

	/* If there is a match for the image, return its URL. */
	if ( isset( $matches ) && $matches[1][0] )
		return array( 'url' => $matches[1][0] );

	return false;
}

/**
 * Used for setting a default image.  The function simply returns the image URL it was
 * given in an array.  Not used with get_the_image() by default.
 *
 * @since 0.3
 * @param array $args
 * @return array
 */
function image_by_default( $args = array() ) {
	return array( 'url' => $args['default_image'] );
}

/**
 * Formats an image with appropriate alt text and class.  Adds a link to the post if argument 
 * is set.  Should only be called if there is an image to display, but will handle it if not.
 *
 * @since 0.1
 * @param array $args
 * @param array $image Array of image info ($image, $classes, $alt, $caption).
 * @return string $image Formatted image (w/link to post if the option is set).
 */
function display_the_image( $args = array(), $image = false ) {

	/* If there is no image URL, return false. */
	if ( empty( $image['url'] ) )
		return false;

	/* Extract the arguments for easy-to-use variables. */
	extract( $args );

	/* If there is a width or height, set them as HMTL-ready attributes. */
	if ( $width )
		$width = ' width="' . $width . '"';
	if ( $height )
		$height = ' height="' . $height . '"';

	/* Loop through the custom field keys and add them as classes. */
	if ( is_array( $custom_key ) ) {
		foreach ( $custom_key as $key )
			$classes[] = str_replace( ' ', '-', strtolower( $key ) );
	}

	/* Add the $default_size and any user-added $image_class to the class. */
	$classes[] = $default_size;
	$classes[] = $image_class;

	/* Join all the classes into a single string. */
	$class = join( ' ', $classes );

	/* If $format should be an array, return the attributes in array format. */
	if ( 'array' == $format )
		return array( 'url' => $image['url'], 'alt' => esc_attr( strip_tags( get_post_field( 'post_title', $post_id ) ) ), 'class' => $class, 'link' => get_permalink( $post_id ) );

	/* If there is a $post_thumbnail_id, apply the WP filters normally associated with get_the_post_thumbnail(). */
	if ( $image['post_thumbnail_id'] )
		do_action( 'begin_fetch_post_thumbnail_html', $post_id, $image['post_thumbnail_id'], $default_size );

	/* Add the image attributes to the <img /> element. */
	$html = '<img src="' . $image['url'] . '" alt="' . esc_attr( strip_tags( get_post_field( 'post_title', $post_id ) ) ) . '" class="' . $class . '"' . $width . $height . ' />';

	/* If $link_to_post is set to true, link the image to its post. */
	if ( $link_to_post )
		$html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . $html . '</a>';

	/* If there is a $post_thumbnail_id, apply the WP filters normally associated with get_the_post_thumbnail(). */
	if ( $image['post_thumbnail_id'] )
		do_action( 'end_fetch_post_thumbnail_html', $post_id, $image['post_thumbnail_id'], $default_size );

	/* If there is a $post_thumbnail_id, apply the WP filters normally associated with get_the_post_thumbnail(). */
	if ( $image['post_thumbnail_id'] )
		$html = apply_filters( 'post_thumbnail_html', $html, $post_id, $image['post_thumbnail_id'], $default_size, $attr );

	return $html;
}

/**
 * Get the image with a link to the post.  Use get_the_image() instead.
 *
 * @since 0.1
 * @deprecated 0.3
 */
function get_the_image_link( $deprecated = '', $deprecated_2 = '', $deprecated_3 = '' ) {
	get_the_image();
}

?>