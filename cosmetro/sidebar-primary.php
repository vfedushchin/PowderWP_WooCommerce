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
if ( is_404() ) {
	return;
}
 ?>

<?php do_action( 'cosmetro_render_widget_area', 'sidebar-primary' ); ?>
