<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package powder
 */

/**
 * Set post specific sidebar position
 *
 * @param  string $position Default sidebar position.
 * @return string
 */
function powder_set_sidebar_position( $position ) {
	$queried_obj = apply_filters( 'powder_queried_object_id', false );
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
add_filter( 'theme_mod_sidebar_position', 'powder_set_sidebar_position' );

/**
 * Render existing macros in passed string.
 *
 * @since  1.0.0
 * @param  string $string String to parse.
 * @return string
 */
function powder_render_macros( $string ) {

	$macros = apply_filters( 'powder_data_macros', array(
		'/%%year%%/' => date( 'Y' ),
		'/%%date%%/' => date( get_option( 'date_format' ) ),
	) );

	return preg_replace( array_keys( $macros ), array_values( $macros ), $string );

}

/**
 * Render font icons in content
 *
 * @param  string $content content to render
 * @return string
 */
function powder_render_icons( $content ) {

	$icons     = powder_get_render_icons_set();
	$icons_set = implode( '|', array_keys( $icons ) );

	$regex = '/icon:(' . $icons_set . ')?:?([a-zA-Z0-9-_]+)/';

	return preg_replace_callback( $regex, 'powder_render_icons_callback', $content );
}

/**
 * Callback for icons render.
 *
 * @param  array $matches Search matches array.
 * @return string
 */
function powder_render_icons_callback( $matches ) {

	if ( empty( $matches[1] ) && empty( $matches[2] ) ) {
		return $matches[0];
	}

	if ( empty( $matches[1] ) ) {
		return sprintf( '<i class="fa fa-%s"></i>', $matches[2] );
	}

	$icons = powder_get_render_icons_set();

	if ( ! isset( $icons[ $matches[1] ] ) ) {
		return $matches[0];
	}

	return sprintf( $icons[ $matches[1] ], $matches[2] );
}

/**
 * Get list of icons to render
 *
 * @return array
 */
function powder_get_render_icons_set() {
	return apply_filters( 'powder_render_icons_set', array(
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
function powder_render_theme_url( $url ) {
	return sprintf( $url, get_stylesheet_directory_uri() );
}
