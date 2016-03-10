<?php
/**
 * Thumbnails configuration.
 *
 * @package    jane_style
 * @subpackage Config
 * @author     Cherry Team <cherryframework@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Registers custom image sizes for the theme.
add_action( 'init', '_tm_register_image_sizes' );
function _tm_register_image_sizes() {

	if ( ! current_theme_supports( 'post-thumbnails' ) ) {
		return;
	}

	set_post_thumbnail_size( 370, 230, true );

	// Registers a new image sizes.
	add_image_size( '_tm-thumb-s', 150, 150, true );
	add_image_size( '_tm-thumb-241-84', 241, 84, true );
	add_image_size( '_tm-thumb-370-270', 370, 270, true );
	add_image_size( '_tm-thumb-m', 400, 400, true );
	add_image_size( '_tm-thumb-560-350', 560, 350, true );
	add_image_size( '_tm-thumb-770-562', 770, 562, true );
	add_image_size( '_tm-post-thumbnail-large', 770, 480, true );
	add_image_size( '_tm-thumb-l', 1170, 780, true );
	add_image_size( '_tm-thumb-xl', 1920, 1080, true );
}