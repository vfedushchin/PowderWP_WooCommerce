<?php
/**
 * Menu Template Functions.
 *
 * @package __Tm
 */

/**
 * Show main menu.
 *
 * @since  1.0.0
 * @return void
 */
function fairy_style_main_menu() { ?>
	<nav id="site-navigation" class="main-navigation" role="navigation">
		<button class="menu-toggle" aria-controls="main-menu" aria-expanded="false"><i class="material-icons">subject</i></button>
		<?php
			$args = apply_filters( 'fairy_style_main_menu_args', array(
				'theme_location'   => 'main',
				'container'        => '',
				'menu_id'          => 'main-menu',
				'fallback_cb'      => 'fairy_style_set_nav_menu',
				'fallback_message' => esc_html__( 'Set main menu', 'fairy_style' ),
			) );

			wp_nav_menu( $args );
		?>
	</nav><!-- #site-navigation -->
	<?php
}

/**
 * Show footer menu.
 *
 * @since  1.0.0
 * @return void
 */
function fairy_style_footer_menu() { ?>
	<nav id="footer-navigation" class="footer-menu" role="navigation">
	<?php
		$args = apply_filters( 'fairy_style_footer_menu_args', array(
			'theme_location'   => 'footer',
			'container'        => '',
			'menu_id'          => 'footer-menu-items',
			'menu_class'       => 'footer-menu__items inline-list',
			'depth'            => 1,
			'fallback_cb'      => '__return_empty_string',
			'fallback_message' => esc_html__( 'Set footer menu', 'fairy_style' ),
		) );

		wp_nav_menu( $args );
	?>
	</nav><!-- #footer-navigation -->
	<?php
}

/**
 * Show top page menu if active.
 *
 * @since  1.0.0
 * @return void
 */
function fairy_style_top_menu() {

	if ( ! has_nav_menu( 'top' ) ) {
		return;
	}
	?>
	<div class="div_dropdown_top_menu">
		<i class="material-icons material-icons-menu"></i>
	<?php
	wp_nav_menu( array(
		'menu_id'         => 'rd-navbar-shop-menu',
		'theme_location'  => 'top',
		'container'       => 'div',
		'container_class' => 'top-panel__menu',
		'menu_class'      => 'top-panel__menu-list',
		'depth'           => 1,
	) );
	?>
	</div>
	<?php
}

/**
 * Get social nav menu.
 *
 * @since  1.0.0
 * @return string
 */
/**
 * Get social nav menu.
 *
 * @since  1.0.0
 * @since  1.0.0  Added new param - $item.
 * @param  string $context Current post context - 'single' or 'loop'.
 * @param  string $type    Content type - icon, text or both.
 * @return string
 */
function fairy_style_get_social_list( $context, $type = 'icon' ) {
	static $instance = 0;
	$instance++;

	$container_class = array( 'social-list' );

	if ( ! empty( $context ) ) {
		$container_class[] = sprintf( 'social-list--%s', sanitize_html_class( $context ) );
	}

	$container_class[] = sprintf( 'social-list--%s', sanitize_html_class( $type ) );

	$args = apply_filters( 'fairy_style_social_list_args', array(
		'theme_location'   => 'social',
		'container'        => 'div',
		'container_class'  => join( ' ', $container_class ),
		'menu_id'          => "social-list-{$instance}",
		'menu_class'       => 'social-list__items inline-list',
		'depth'            => 1,
		'link_before'      => ( 'icon' == $type ) ? '<span class="screen-reader-text">' : '',
		'link_after'       => ( 'icon' == $type ) ? '</span>' : '',
		'echo'             => false,
		'fallback_cb'      => 'fairy_style_set_nav_menu',
		'fallback_message' => esc_html__( 'Set social menu', 'fairy_style' ),
	) );

	return wp_nav_menu( $args );
}

/**
 * Set fallback callback for nav menu.
 *
 * @param  array $args Nav menu arguments.
 * @return void
 */
function fairy_style_set_nav_menu( $args ) {

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return null;
	}

	$format = '<div class="set-menu %3$s"><a href="%2$s" target="_blank" class="set-menu_link">%1$s</a></div>';
	$label  = $args['fallback_message'];
	$url    = esc_url( admin_url( 'nav-menus.php' ) );

	printf( $format, $label, $url, $args['container_class'] );
}
