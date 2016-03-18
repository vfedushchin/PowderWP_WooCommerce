<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package __Tm
 */
$sidebar_position = get_theme_mod( 'sidebar_position' );

if ( 'fullwidth' === $sidebar_position || ! is_active_sidebar( 'sidebar-primary' ) || is_singular( 'product' ) ) {
	return;
}
if( function_exists('is_shop') ) {
	if ( is_shop() ) {
		return;
	}
}
 ?>

<?php do_action( 'fairy_style_render_widget_area', 'sidebar-primary' ); ?>
