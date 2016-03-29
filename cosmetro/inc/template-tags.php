<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package __Tm
 */

/**
 * Show top panel message.
 *
 * @since  1.0.0
 * @param  string $format Output formatting.
 * @return void
 */
function cosmetro_top_message( $format = '%s' ) {
	$message = get_theme_mod( 'top_panel_text', cosmetro_theme()->customizer->get_default( 'top_panel_text' ) );

	if ( ! $message ) {
		return;
	}

	printf( $format, wp_kses( $message, wp_kses_allowed_html( 'post' ) ) );
}

/**
 * Show top panel search.
 *
 * @since  1.0.0
 * @param  string $format Output formatting.
 * @return void
 */
function cosmetro_top_search( $format = '%s' ) {
	$is_enabled = get_theme_mod( 'top_panel_search', cosmetro_theme()->customizer->get_default( 'top_panel_search' ) );

	if ( ! $is_enabled ) {
		return;
	}

	printf( $format, do_action('cosmetro_menu_shop_header') );
}
/**
 * Display Product Search
 * @since  1.0.0
 * @uses  is_woocommerce_activated() check if WooCommerce is activated
 * @return void
 */
if ( ! function_exists( 'cosmetro_product_search' ) ) {
	function cosmetro_product_search() {
		if ( is_woocommerce_activated() ) { ?>
			<div class="site-search">
				<?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
			</div>
		<?php
		}
	}
}
add_action( 'cosmetro_menu_shop_header', 'cosmetro_product_search', 	40 );
/***WOOCOMMERCE PART***/
/**
 * Show top Currency Switcher
 *
 * @param  string $format Output formatting.
 * @return void
 */
function cosmetro_top_currency_switcher( $format = '%s' ) {

	$is_enabled = get_theme_mod( 'top_currency_switcher', cosmetro_theme()->customizer->get_default( 'top_currency_switcher' ) );

	if ( ! $is_enabled ) {
		return;
	}

	printf( $format, cosmetro_currency_switcher() );

}

/**
 * Show top Language Selector
 *
 * @param  string $format Output formatting.
 * @return void
 */

function cosmetro_top_language_selector( $format = '%s' ) {
	$is_enabled = get_theme_mod( 'top_language_selector', cosmetro_theme()->customizer->get_default( 'top_language_selector' ) );
	if ( ! $is_enabled ) {
		return;
	}
	printf( $format, do_action('wpml_add_language_selector') );
}

/**
 * Query WooCommerce activation
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		return class_exists( 'woocommerce' ) ? true : false;
	}
}

/**
 * Query WC_Jetpack activation
 */
if ( ! function_exists( 'is_wc_jetpack' ) ) {
 function is_wc_jetpack() {
  return class_exists( 'WC_Jetpack' ) ? true : false;
 }
}

/**
 * Display Currency Switcher
 * @since  1.0.0
 * @uses  is_woocommerce_activated() check if WooCommerce is activated
 * @return void
 */
if ( ! function_exists( 'cosmetro_currency_switcher' ) ) {
 function cosmetro_currency_switcher() {
  if ( is_wc_jetpack() ) { ?>
   <div class="currency_switcher">
    <?php the_widget( 'WCJ_Widget_Multicurrency' ,'title=') ?>
   </div>
  <?php
  }
 }
}


/**
 * Cart Link
 * Displayed a link to the cart including the number of items present and the cart total
 * @param  array $settings Settings
 * @return array           Settings
 * @since  1.0.0
 */
if ( ! function_exists( 'cosmetro_cart_link' ) ) {
	function cosmetro_cart_link() {
		?>
		<div class="cart-contents">
			<span class="count"><i class="fl-flat-icons-set-2-shopping191"></i><span><?php echo WC()->cart->get_cart_contents_count();?></span></span>
		</div>
		<?php
	}
}

/**
 * Display Header Cart
 * @since  1.0.0
 * @uses  is_woocommerce_activated() check if WooCommerce is activated
 * @return void
 */
if ( ! function_exists( 'cosmetro_header_cart' ) ) {
	function cosmetro_header_cart() {
		if ( is_woocommerce_activated() ) {
			if ( is_cart() ) {
				$class = 'current-menu-item';
			} else {
				$class = '';
			}
		?>
		<ul class="site-header-cart navbar-header-cart menu">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php cosmetro_cart_link(); ?>
			</li>
			<li class="header-cart-dropdown">
				<div class="shopping_cart-dropdown-wrap">
					<h4><?php echo __( 'Cart', 'cosmetro' ) ?></h4>
					<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
				</div>
			</li>
		</ul>
		<?php
		}
	}
}

/**
 * Show footer copyright text.
 *
 * @return void
 */
function cosmetro_footer_text_center() {

	$centerText = get_theme_mod( 'footer_text_center', cosmetro_theme()->customizer->get_default( 'footer_text_center' ) );
	$format    = '<div class="footer-text-center">%s</div>';

	if ( ! empty( $centerText ) ) {
		printf( $format, wp_kses( cosmetro_render_macros( $centerText ), wp_kses_allowed_html( 'post' ) ) );
		return;
	}
}



/***END WOOCOMMERCE PART***/


/**
 * Show footer logo, uploaded from customizer.
 *
 * @since  1.0.0
 * @return void
 */
function cosmetro_footer_logo() {

	$logo_url = get_theme_mod( 'footer_logo_url' );

	if ( ! $logo_url ) {
		return;
	}

	$url      = esc_url( home_url( '/' ) );
	$alt      = esc_attr( get_bloginfo( 'name' ) );
	$logo_url = esc_url( cosmetro_render_theme_url( $logo_url ) );
	$logo_id  = cosmetro_get_image_id_by_url( cosmetro_render_theme_url( $logo_url ) );
	$logo_src = wp_get_attachment_image_src( $logo_id, 'full' );

	if ( $logo_id && $logo_src ) {
		$atts = ' width="' . $logo_src[1] . '" height="' . $logo_src[2] . '"';
	} else {
		$atts = '';
	}

	$logo_format = apply_filters(
		'cosmetro_footer_logo_format',
		'<div class="footer-logo"><a href="%2$s" class="footer-logo_link"><img src="%1$s" alt="%3$s" class="footer-logo_img" %4$s></a></div>'
	);

	printf( $logo_format, $logo_url, $url, $alt, $atts );

}

/**
 * Show footer copyright text.
 *
 * @since  1.0.0
 * @return void
 */
function cosmetro_footer_copyright() {
	$copyright = get_theme_mod( 'footer_copyright', cosmetro_theme()->customizer->get_default( 'footer_copyright' ) );
	$format    = '<div class="footer-copyright">%s</div>';

	if ( empty( $copyright ) ) {
		return;
	}

	printf( $format, wp_kses( cosmetro_render_macros( $copyright ), wp_kses_allowed_html( 'post' ) ) );
}

/**
 * Show Social list.
 *
 * @since  1.0.0
 * @since  1.0.1 Added new param - $type.
 * @return void
 */
function cosmetro_social_list( $context = '', $type = 'icon' ) {
	$visibility_in_header = get_theme_mod( 'header_social_links', cosmetro_theme()->customizer->get_default( 'header_social_links' ) );
	$visibility_in_footer = get_theme_mod( 'footer_social_links', cosmetro_theme()->customizer->get_default( 'footer_social_links' ) );

	if ( ! $visibility_in_header && ( 'header' === $context ) ) {
		return;
	}

	if ( ! $visibility_in_footer && ( 'footer' === $context ) ) {
		return;
	}

	echo cosmetro_get_social_list( $context, $type );
}

/**
 * Show sticky menu label grabbed from options.
 *
 * @since  1.0.0
 * @return void
 */
function cosmetro_sticky_label() {

	if ( ! is_sticky() || ! is_home() || is_paged() ) {
		return;
	}

	$sticky_label = get_theme_mod( 'blog_sticky_label' );

	if ( empty( $sticky_label ) ) {
		return;
	}

	printf( '<span class="sticky__label">%s</span>', cosmetro_render_icons( $sticky_label ) );
}

/**
 * Display the header logo.
 *
 * @since  1.0.0
 * @return void
 */
function cosmetro_header_logo() {
	$logo = cosmetro_get_site_title_by_type( get_theme_mod( 'header_logo_type', cosmetro_theme()->customizer->get_default( 'header_logo_type' ) ) );

	if ( is_front_page() && is_home() ) {
		$tag = 'h1';
	} else {
		$tag = 'div';
	}

	$format = apply_filters(
		'cosmetro_header_logo_format',
		'<%1$s class="site-logo"><a class="site-logo__link" href="%2$s" rel="home">%3$s</a></%1$s>'
	);

	printf( $format, $tag, esc_url( home_url( '/' ) ), $logo );
}

/**
 * Retrieve the site title (image or text).
 *
 * @since  1.0.0
 * @return string
 */
function cosmetro_get_site_title_by_type( $type ) {

	if ( ! in_array( $type, array( 'text', 'image' ) ) ) {
		$type = 'text';
	}

	$logo = get_bloginfo( 'name' );

	if ( 'text' === $type ) {
		return "<span class='site-logo-text'>" . $logo . '</span>';
	}

	$logo_url = get_theme_mod( 'header_logo_url', cosmetro_theme()->customizer->get_default( 'header_logo_url' ) );

	if ( ! $logo_url ) {
		return $logo;
	}

	$logo_url = cosmetro_render_theme_url( $logo_url );

	$retina_logo     = '';
	$retina_logo_url = get_theme_mod( 'retina_header_logo_url' );
	$retina_logo_url = cosmetro_render_theme_url( $retina_logo_url );

	$logo_id = cosmetro_get_image_id_by_url( $logo_url );

	if ( $retina_logo_url ) {
		$retina_logo = sprintf( 'srcset="%s 2x"', esc_url( $retina_logo_url ) );
	}

	$logo_src = wp_get_attachment_image_src( $logo_id, 'full' );

	if ( $logo_id && $logo_src ) {
		$atts = ' width="' . $logo_src[1] . '" height="' . $logo_src[2] . '"';
	} else {
		$atts = '';
	}

	$format_image = apply_filters( 'cosmetro_header_logo_image_format',
		'<img src="%1$s" alt="%2$s" class="site-link__img" %3$s%4$s>'
	);

	return sprintf( $format_image, esc_url( $logo_url ), esc_attr( $logo ), $retina_logo, $atts );
}

/**
 * Display the site description.
 *
 * @since  1.0.0
 * @return void
 */
function cosmetro_site_description() {
	$show_desc = get_theme_mod( 'show_tagline', cosmetro_theme()->customizer->get_default( 'show_tagline' ) );

	if ( ! $show_desc ) {
		return;
	}

	$description = get_bloginfo( 'description', 'display' );

	if ( ! ( $description || is_customize_preview() ) ) {
		return;
	}

	$format = apply_filters( 'cosmetro_site_description_format', '<div class="site-description">%s</div>' );

	printf( $format, $description );
}

/**
 * Dispaply box with information about author.
 *
 * @since  1.0.0
 * @return void
 */
function cosmetro_post_author_bio() {
	$is_enabled = get_theme_mod( 'single_author_block', cosmetro_theme()->customizer->get_default( 'single_author_block' ) );

	if ( ! $is_enabled ) {
		return;
	}

	get_template_part( 'template-parts/content', 'author-bio' );

}

/**
 * Display a link to all posts by an author.
 *
 * @since  1.0.0
 * @param  array $args Arguments.
 * @return string      An HTML link to the author page.
 */
function cosmetro_get_the_author_posts_link() {
	ob_start();
	the_author_posts_link();
	$author = ob_get_clean();

	return $author;
}

/**
 * Display the breadcrumbs.
 *
 * @since  1.0.0
 * @return void
 */
function cosmetro_site_breadcrumbs() {
	$breadcrumbs_visibillity       = get_theme_mod( 'breadcrumbs_visibillity', cosmetro_theme()->customizer->get_default( 'breadcrumbs_visibillity' ) );
	$breadcrumbs_page_title        = get_theme_mod( 'breadcrumbs_page_title', cosmetro_theme()->customizer->get_default( 'breadcrumbs_page_title' ) );
	$breadcrumbs_path_type         = get_theme_mod( 'breadcrumbs_path_type', cosmetro_theme()->customizer->get_default( 'breadcrumbs_path_type' ) );
	$breadcrumbs_front_visibillity = get_theme_mod( 'breadcrumbs_front_visibillity', cosmetro_theme()->customizer->get_default( 'breadcrumbs_front_visibillity' ) );
/*<div class="breadcrumbs__title">%1$s</div>   for line 429*/
	$breadcrumbs_settings = apply_filters( 'cosmetro_breadcrumbs_settings', array(
		'wrapper_format'    => '<div class="container">

		<div class="breadcrumbs__items">%2$s</div><div class="clear"></div></div>',
		'page_title_format' => '<h5 class="page-title">%s</h5>',
		'show_title'        => $breadcrumbs_page_title,
		'path_type'         => $breadcrumbs_path_type,
		'show_on_front'     => $breadcrumbs_front_visibillity,
		'labels'            => array(
			'browse' => '',
		),
		'css_namespace' => array(
			'module'    => 'breadcrumbs',
			'content'   => 'breadcrumbs__content',
			'wrap'      => 'breadcrumbs__wrap',
			'browse'    => 'breadcrumbs__browse',
			'item'      => 'breadcrumbs__item',
			'separator' => 'breadcrumbs__item-sep',
			'link'      => 'breadcrumbs__item-link',
			'target'    => 'breadcrumbs__item-target',
		)
	) );

	if ( $breadcrumbs_visibillity ) {
		cosmetro_theme()->get_core()->init_module( 'cherry-breadcrumbs', $breadcrumbs_settings );
		do_action('cherry_breadcrumbs_render');
	}

}

/**
 * Display the page preloader.
 *
 * @since  1.0.0
 * @return void
 */
function cosmetro_get_page_preloader() {
	$page_preloader = get_theme_mod( 'page_preloader', cosmetro_theme()->customizer->get_default( 'page_preloader' ) );

	if ( $page_preloader ) {
		echo '<div class="page-preloader-cover"><div class="tm-folding-cube">
				<div class="tm-cube1 tm-cube"></div>
				<div class="tm-cube2 tm-cube"></div>
				<div class="tm-cube4 tm-cube"></div>
				<div class="tm-cube3 tm-cube"></div>
			</div>
		</div>';
	}
}

/**
 * Check if top panele visible or not
 *
 * @return bool
 */
function cosmetro_is_top_panel_visible() {

	$message = get_theme_mod( 'top_panel_text', cosmetro_theme()->customizer->get_default( 'top_panel_text' ) );
	$search  = get_theme_mod( 'top_panel_search', cosmetro_theme()->customizer->get_default( 'top_panel_search' ) );
	$menu    = has_nav_menu( 'top' );

	$conditions = apply_filters( 'cosmetro_top_panel_visibility_conditions', array( $message, $search, $menu ) );

	$is_visible = false;

	foreach ( $conditions as $condition ) {
		if ( ! empty( $condition ) ) {
			$is_visible = true;
		}
	}

	return $is_visible;
}
