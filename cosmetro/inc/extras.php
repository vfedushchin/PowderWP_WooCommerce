<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package __Tm
 */

/**
 * Set post specific sidebar position
 *
 * @param  string $position Default sidebar position.
 * @return string
 */
function cosmetro_set_sidebar_position( $position ) {
	$queried_obj = apply_filters( 'cosmetro_queried_object_id', false );

	if ( ! $queried_obj ) {

		if ( ! is_singular() ) {
			return $position;
		}

		if ( is_front_page() && 'page' !== get_option( 'show_on_front' ) ) {
			return $position;
		}

	}

	$queried_obj = ( ! $queried_obj ) ? get_the_id() : $queried_obj;

	if ( ! $queried_obj ) {
		return $position;
	}

	$post_position = get_post_meta( $queried_obj, '_tm_sidebar_position', true );

	if ( ! $post_position || 'inherit' === $post_position ) {
		return $position;
	}

	return $post_position;

}
add_filter( 'theme_mod_sidebar_position', 'cosmetro_set_sidebar_position' );

/**
 * Render existing macros in passed string.
 *
 * @since  1.0.0
 * @param  string $string String to parse.
 * @return string
 */
function cosmetro_render_macros( $string ) {
	$macros = apply_filters( 'cosmetro_data_macros', array(
		'/%%year%%/' => date( 'Y' ),
		'/%%date%%/' => date( get_option( 'date_format' ) ),
		'/%%privacy-policy%%/' => cosmetro_get_privacy_link(),
	) );
	return preg_replace( array_keys( $macros ), array_values( $macros ), $string );
}

/**
 * Get privacy policy link
 *
 * @return string
 */
function cosmetro_get_privacy_link() {
	$page = get_page_by_path( 'privacy-policy' );

	return get_permalink( $page->ID );
}

/**
 * Render font icons in content
 *
 * @param  string $content content to render
 * @return string
 */
function cosmetro_render_icons( $content ) {

	$icons     = cosmetro_get_render_icons_set();
	$icons_set = implode( '|', array_keys( $icons ) );

	$regex = '/icon:(' . $icons_set . ')?:?([a-zA-Z0-9-_]+)/';

	return preg_replace_callback( $regex, 'cosmetro_render_icons_callback', $content );
}

/**
 * Callback for icons render.
 *
 * @param  array $matches Search matches array.
 * @return string
 */
function cosmetro_render_icons_callback( $matches ) {

	if ( empty( $matches[1] ) && empty( $matches[2] ) ) {
		return $matches[0];
	}

	if ( empty( $matches[1] ) ) {
		return sprintf( '<i class="fa fa-%s"></i>', $matches[2] );
	}

	$icons = cosmetro_get_render_icons_set();

	if ( ! isset( $icons[ $matches[1] ] ) ) {
		return $matches[0];
	}

	return sprintf( $icons[ $matches[1] ], $matches[2] );
}

/**
 * Get list of icons to render.
 *
 * @return array
 */
function cosmetro_get_render_icons_set() {
	return apply_filters( 'cosmetro_render_icons_set', array(
		'fa'       => '<i class="fa fa-%s"></i>',
		'material' => '<i class="material-icons">%s</i>',
	) );
}

/**
 * Replace %s with theme URL.
 *
 * @param  string $url Formatted URL to parse.
 * @return string
 */
function cosmetro_render_theme_url( $url ) {
	return sprintf( $url, get_stylesheet_directory_uri() );
}

/**
 * Get thumbnail size depending from seleted layout.
 *
 * @return string
 */
function cosmetro_get_thumbnail_size() {
	$layout = get_theme_mod( 'blog_layout_type', cosmetro_theme()->customizer->get_default( 'blog_layout_type' ) );

	// if ( 'grid-2-cols' === $layout && ! ( is_sticky() && is_home() && ! is_paged() ) ) {
	// 	return 'cosmetro-post-thumbnail-large';
	// }

	// if ( 'grid-3-cols' === $layout && ! ( is_sticky() && is_home() && ! is_paged() ) ) {
	// 	return 'cosmetro-thumb-370-270';
	// }

	// if ( 'default' === $layout && ! ( is_sticky() && is_home() && ! is_paged() ) ) {
	// 	return $size;
	// }

	return 'cosmetro-thumb-1170-854';
}

/**
 * Get image ID by URL.
 *
 * @param  string $image_src Image URL to search it in database.
 * @return int|bool false
 */
function cosmetro_get_image_id_by_url( $image_src ) {
	global $wpdb;

	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
	$id    = $wpdb->get_var( $query );

	return $id;
}

function cosmetro_post_formats_gallery() {
	if ( ! in_array( get_theme_mod( 'blog_layout_type' ), array( 'masonry-2-cols', 'masonry-3-cols' ) ) ) {
		return do_action( 'cherry_post_format_gallery', array(
			// 'size' => cosmetro_get_thumbnail_size(),
		) );
	}

	$images = cosmetro_theme()->get_core()->modules['cherry-post-formats-api']->get_gallery_images(false);

	if ( is_string( $images ) && ! empty( $images ) ) {
		return $images;
	}

	$items             = array();
	$first_item        = null;
	$size              = cosmetro_get_thumbnail_size();
	$format            = '<div class="mini-gallery post-thumbnail--fullwidth">%1$s<div class="post-gallery__slides" style="display: none;">%2$s</div></div>';
	$first_item_format = '<a href="%1$s" class="post-thumbnail__link">%2$s</a>';
	$item_format       = '<a href="%1$s">%2$s</a>';

	foreach( $images as $img ) {

		$image = wp_get_attachment_image( $img, $size );
		$url   = wp_get_attachment_url( $img );

		if ( sizeof( $items ) === 0 ) {
			$first_item = sprintf( $first_item_format, $url, $image );
		}

		$items[] = sprintf( $item_format, $url, $image );
	}

	printf( $format, $first_item, join( "\r\n", $items ) );
}
