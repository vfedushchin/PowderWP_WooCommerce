<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package powder
 */
$sidebar_position = get_theme_mod( 'sidebar_position' );

if ( 'fullwidth' === $sidebar_position || ! is_active_sidebar( 'sidebar-primary' ) || is_singular( 'product' ) ) {
	return;
}

 ?>

<?php do_action( 'powder_render_widget_area', 'sidebar-primary' ); ?>
