<?php
/**
 * Menus configuration.
 *
 * @package __Tm
 */

add_action( 'after_setup_theme', 'cosmetro_register_menus', 5 );
function cosmetro_register_menus() {

	// This theme uses wp_nav_menu() in four locations.
	register_nav_menus( array(
		'top'    => esc_html__( 'Top', 'cosmetro' ),
		'main'   => esc_html__( 'Main', 'cosmetro' ),
		'footer' => esc_html__( 'Footer', 'cosmetro' ),
		'social' => esc_html__( 'Social', 'cosmetro' ),
	) );
}
