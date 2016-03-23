<?php
/**
 * Menus configuration.
 *
 * @package __Tm
 */

add_action( 'after_setup_theme', 'fairy_style_register_menus', 5 );
function fairy_style_register_menus() {

	// This theme uses wp_nav_menu() in four locations.
	register_nav_menus( array(
		'top'    => esc_html__( 'Top', 'fairy_style' ),
		'main'   => esc_html__( 'Main', 'fairy_style' ),
		'footer' => esc_html__( 'Footer', 'fairy_style' ),
		'social' => esc_html__( 'Social', 'fairy_style' ),
	) );
}
