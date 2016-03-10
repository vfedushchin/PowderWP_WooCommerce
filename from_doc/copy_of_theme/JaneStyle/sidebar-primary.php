<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package jane_style
 */
$sidebar_position = get_theme_mod( 'sidebar_position' );

if ( 'fullwidth' === $sidebar_position || ! is_active_sidebar( 'sidebar-primary' ) || is_singular( 'product' ) ) {
	return;
}

 ?>

<?php do_action( 'jane_style_render_widget_area', 'sidebar-primary' ); ?>