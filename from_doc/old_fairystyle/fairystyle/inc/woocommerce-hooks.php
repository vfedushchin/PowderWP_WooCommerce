<?php
/**
 * jane_tyle WooCommerce Theme hooks.
 *
 * @package fairy_style
 */

add_action( 'after_setup_theme', 'fairy_style_woocommerce_support' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_action( 'wp_enqueue_scripts', 'fairy_style_enqueue_assets' );

add_action( 'woocommerce_before_main_content', 'fairy_style_enqueue_single_product_scripts' );

add_filter( 'woocommerce_sale_flash', 'fairy_style_woocommerce_sale_flash' );

add_filter( 'fairy_style_get_customizer_options', 'fairy_style_add_options' );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 9 );

add_filter( 'woocommerce_get_price_html_from_to', 'fairy_style_woocommerce_get_price_html_from_to', 10, 3 );

remove_action( 'woocommerce_single_product_summary', 'toastie_wc_smsb_form_code', 31 );

add_action( 'woocommerce_share', 'toastie_wc_smsb_form_code' );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 11 );

add_action( 'widgets_init', 'fairy_style_override_woocommerce_widgets', 15 );

add_action( 'woocommerce_before_shop_loop_item_title', 'fairy_style_woocommerce_show_flash' );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 11 );

remove_action( 'tm_carousel_woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'tm_carousel_woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 11 );

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_action( 'tm_carousel_woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'tm_carousel_woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 11 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 11 );

add_action( 'tm_carousel_woocommerce_before_shop_loop_item_title', 'fairy_style_product_image_wrap_open', 2 );
add_action( 'tm_carousel_woocommerce_before_shop_loop_item_title', 'fairy_style_product_image_wrap_close', 11 );

add_action( 'woocommerce_before_shop_loop_item', 'fairy_style_product_image_wrap_open', 2 );
add_action( 'woocommerce_before_shop_loop_item_title', 'fairy_style_product_image_wrap_close', 12 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'tm_products_carousel_widget_sale_end_date', 11 );
add_action( 'woocommerce_before_shop_loop_item_title', 'tm_products_sale_end_date', 11 );

add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 3 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 10 );

add_action( 'woocommerce_after_shop_loop_item', 'fairy_style_product_add_to_wishlist', 12 );

add_action( 'woocommerce_after_shop_loop_item', 'fairy_style_wishlist_compare_wrap_open', 11 );
add_action( 'woocommerce_after_shop_loop_item', 'fairy_style_wishlist_compare_wrap_close', 20 );

add_filter( 'woocommerce_show_page_title', 'fairy_style_woocommerce_show_page_title' );

add_filter( 'woocommerce_loop_add_to_cart_link', 'fairy_style_woocommerce_loop_add_to_cart_link', 10, 2 );

if ( 'yes' === get_option( 'yith_woocompare_compare_button_in_products_list' ) ) {
	add_action( 'init', 'fairy_style_init_loop_compare_hook' );
}

if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'fairy_style_cart_link_fragment' );
} else {
	add_filter( 'add_to_cart_fragments', 'fairy_style_cart_link_fragment' );
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

add_action( 'woocommerce_before_shop_loop', 'fairy_style_woocommerce_result_count', 31 );

add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 32 );

add_action( 'woocommerce_before_shop_loop', 'fairy_style_woocommerce_open_order_wrap', 29 );

add_action( 'woocommerce_before_shop_loop', 'fairy_style_woocommerce_close_order_wrap', 33 );

// add_action( 'woocommerce_after_shop_loop', 'fairy_style_woocommerce_close_container_order_wrap', 33 );

add_action( 'pre_get_posts', 'fairy_style_remove_products_from_posts_search', 99 );

add_action( 'wp_head', 'fairy_style_enqueue_main_styles' );
/**
 * Enable Woocommerce theme support
 */
function fairy_style_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

/**
 * Check is WPML Plugin exists and enabled
 *
 * @return bool
 */
function fairy_style_has_wpml() {
	if ( ! isset( $fairy_style_has_wpml ) || null == $fairy_style_has_wpml ) {
		$fairy_style_has_wpml = in_array(
			'sitepress-multilingual-cms/sitepress.php',
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
		);
	}
	return $fairy_style_has_wpml;
}

/**
 * Check is WooCommerce Plugin exists and enabled
 *
 * @return bool
 */
function fairy_style_has_woocommerce() {

	if ( ! isset( $fairy_style_has_woocommerce ) || null == $fairy_style_has_woocommerce ) {
		$fairy_style_has_woocommerce = in_array(
			'woocommerce/woocommerce.php',
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
		);
	}

	return $fairy_style_has_woocommerce;

}

function fairy_style_enqueue_assets() {

	// Jssor Slider
	wp_register_script( 'jquery-jssor', FAIRY_STYLE_THEME_URI . '/assets/js/jssor.slider.mini.js', array( 'jquery' ), '1.0.0', true );

	// Easyzoom
	wp_register_script( 'jquery-easyzoom', FAIRY_STYLE_THEME_URI . '/assets/js/easyzoom.js', array( 'jquery' ), '2.3.1', true );

	wp_enqueue_style( 'style-additional', FAIRY_STYLE_THEME_URI . '/assets/css/additional.css', array(), FAIRY_STYLE_THEME_VERSION );

	// Navbar
    wp_enqueue_script( 'navbar-script', FAIRY_STYLE_THEME_URI . '/assets/js/jquery.rd-navbar.js', array(), '1.0.0', true );
    // Countdown
    wp_enqueue_script( 'countdown-script', FAIRY_STYLE_THEME_URI . '/assets/js/jquery.countdown.min.js', array(), '2.1.0', true );
    // Jquery Chosen
    wp_enqueue_script( 'jquery-chosen', FAIRY_STYLE_THEME_URI . '/assets/js/chosen.jquery.min.js', array(), '1.5.1', true );
}

/**
 * Enqueue Jssor Slider.
 *
 * @since 1.0.0
 */
function fairy_style_enqueue_single_product_scripts() {
	// Jssor Slider
	wp_enqueue_script( 'jquery-jssor' );

	// Easyzoom
	wp_enqueue_script( 'jquery-easyzoom' );

}

/**
 * Replace sale flash text
 *
 * @return string
 */
function fairy_style_woocommerce_sale_flash() {
	return '<span class="onsale">' . __( 'Sale', 'fairy_style' ) . '</span>';
}

/**
 * Add extra customizer options
 *
 * @param  array $args Existing options.
 * @return array
 */
function fairy_style_add_options( $args ) {
	if ( fairy_style_has_wpml() ) {
		$args['options']['top_language_selector'] = array(
			'title'   => esc_html__( 'On/Off Language Selector', 'fairy_style' ),
			'section' => 'header_top_panel',
			'default' => true,
			'field'   => 'checkbox',
			'type'    => 'control',
		);
	}
	if( fairy_style_has_woocommerce() ) {
		$args['options']['woocommerce'] = array(
			'title'       => esc_html__( 'Woocommerce', 'fairy_style' ),
			'description' => esc_html__( 'Description', 'fairy_style' ),
			'priority'    => 200,
			'type'        => 'section'
		);
		$args['options']['single_product_slider_layout'] = array(
			'title'       => esc_html__( 'Single product slider layout', 'fairy_style' ),
			'section' => 'woocommerce',
			'default' => 'vertical',
			'field'   => 'radio',
			'choices' => array(
				'vertical' => esc_html__( 'Vertical', 'fairy_style' ),
				'horizontal'  => esc_html__( 'Horizontal', 'fairy_style' ),
			),
			'type'        => 'control'
		);
	}
	return $args;
}

/**
 * Change WooCommerce loop category title layout
 *
 * @param object $category
 * @return string
 */
function woocommerce_template_loop_category_title( $category ) {
	?>
	<h3>
		<?php
			echo $category->name;
			if ( $category->count > 0 )
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count"><span class="count__number">' . $category->count . '</span> ' . __('products', 'fairy_style') . '</mark>' , $category );
		?>
	</h3>
	<?php
}

/**
 * Override Woocommerce Standard Widgets
 */
function fairy_style_override_woocommerce_widgets() {
  if ( class_exists( 'WC_Widget_Recent_Reviews' ) ) {
	unregister_widget( 'WC_Widget_Recent_Reviews' );
	include_once( 'widgets/tm-wc-recent-reviews-products/class-tm-reviews-product-widget.php' );
	register_widget( 'Fairy_Style_WC_Widget_Recent_Reviews' );
  }
  if ( class_exists( 'WP_Widget_Recent_Posts' ) ) {
	unregister_widget( 'WP_Widget_Recent_Posts' );
	include_once( 'widgets/tm-wc-recent-post/class-tm-widget-recent-posts.php' );
	register_widget( 'Fairy_Style_WP_Widget_Recent_Posts' );
  }
}

/**
 * Change WooCommerce Price Output when Product is on Sale
 *
 * @param  string $price Price
 * @param  int|string $from Regular price
 * @param  int|string $to Sale price
 * @return string
 */
function fairy_style_woocommerce_get_price_html_from_to( $price, $from, $to ) {

	$price = '<ins>' . ( ( is_numeric( $to ) ) ? wc_price( $to ) : $to ) . '</ins> <del>' . ( ( is_numeric( $from ) ) ? wc_price( $from ) : $from ) . '</del>';

	return $price;
}

/**
 * Add WooCommerce 'New' and 'Featured' Flashes
 *
 * @return string
 */
function fairy_style_woocommerce_show_flash() {

	global $product, $woocommerce_loop;

	if( !$product->is_on_sale() ) {

		if ( ( date('U') - strtotime($product->post->post_date) ) < 604800 ) {
			echo '<span class="new">' . __( 'New', 'fairy_style' ) . '</span>';
		}

		else if( $product->is_featured() ) {
			echo '<span class="featured">' . __( 'Featured', 'fairy_style' ) . '</span>';
		}
	}
}

/**
 * Add WooCommerce 'Add to wishlist' Button in TM Products Carousel Widget
 *
 * @return string
 */
function fairy_style_product_add_to_wishlist() {
 if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ){
  echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
 }
}
/**
 * Open wrap product loop elements
 *
 * @return string
 */
function fairy_style_product_image_wrap_open() {
	echo "<div class='block_product_thumbnail'>";
}
/**
 * Close wrap product loop elements
 *
 * @return string
 */
function fairy_style_product_image_wrap_close() {
	echo "</div>";
}

/**
 * Open wrap wishlist and compare buttons
 *
 * @return string
 */
function fairy_style_wishlist_compare_wrap_open() {
	echo "<div class='block_wishlist_compare'>";
}

/**
 * Close wrap wishlist and compare buttons
 *
 * @return string
 */
function fairy_style_wishlist_compare_wrap_close() {
	echo "</div>";
}

/**
 * Disable WooCommerce Page Title
 *
 * @return string
 */
function fairy_style_woocommerce_show_page_title() {
	return false;
}

/**
 * Modify WooCommerce Add to cart Button in Loop
 *
 * @param  array $product Button object
 * @param  string $link
 * @return string
 */
function fairy_style_woocommerce_loop_add_to_cart_link( $link, $product ) {
	if ( isset( $_GET['action'] ) && 'yith-woocompare-view-table' === $_GET['action'] ) {
		return $link;
	} else {
		return sprintf(
			'<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="1" class="add_to_cart_button %s">%s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( $product->id ),
			esc_attr( $product->get_sku() ),
			implode( ' ', array_filter( array(
					'button',
					'product_type_' . $product->product_type,
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
					$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : ''
			) ) ),
			$product->is_purchasable() && $product->is_in_stock() ? '<span class="fl-line-icon-set-shopping63 add"></span>'
			. '<span class="fl-line-icon-set-rounded25 added"></span>'
			. '<span class="product_actions_tip add_to_cart_button__text add">' . esc_html( $product->add_to_cart_text() ) . '</span>'
			. '<span class="product_actions_tip add_to_cart_button__text added">' . __( 'Added to cart! ', 'fairy_style' ) . '</span>' : '<span class="material-icons">visibility</span><span class="product_actions_tip add_to_cart_button__text select">' . esc_html( $product->add_to_cart_text() ) . '</span>'
		);
	}
}

/**
 * Add Custom compare button hook in products loop
 *
 */
function fairy_style_init_loop_compare_hook() {

	$filters = $GLOBALS['wp_filter']['woocommerce_after_shop_loop_item'];

	if ( ! empty( $filters ) ) {
		$remove = false;
		foreach ( $filters as $priority => $filter ) {

			foreach ( $filter as $identifier => $function ) {

				if ( is_array( $function )
					&& is_a( $function['function'][0], 'YITH_Woocompare_Frontend' )
					&& 'add_compare_link' === $function['function'][1]
				) {
					$remove = remove_filter(
						'woocommerce_after_shop_loop_item',
						array( $function['function'][0], 'add_compare_link' ),
						$priority
					);
				}
			}
		}
		if ( $remove ) {
			add_action( 'woocommerce_after_shop_loop_item', 'fairy_style_add_loop_compare', 12 );
		}
	}
}

/**
 * Print compare button in products loop
 *
 * @return string
 */
function fairy_style_add_loop_compare() {

	global $product;
	$product_id = isset( $product->id ) ? $product->id : 0;

	// return if product doesn't exist
	if ( empty( $product_id )
		|| apply_filters( 'yith_woocompare_remove_compare_link_by_cat', false, $product_id )
	) {
		return null;
	}

	$is_button = get_option( 'yith_woocompare_is_button', 'button' );

	if ( ! isset( $button_text ) || 'default' == $button_text ) {

		$button_text = get_option(
			'yith_woocompare_button_text',
			__( 'Compare', 'cherry-woocommerce-package' )
		);

		$button_text = function_exists( 'icl_translate' )
						? icl_translate( 'Plugins', 'plugin_yit_compare_button_text', $button_text )
						: $button_text;
	}

	$action_add = 'yith-woocompare-add-product';
	$url_args   = array(
		'action' => $action_add,
		'id'     => $product_id,
	);

	$url = apply_filters(
		'yith_woocompare_add_product_url',
		wp_nonce_url( esc_url_raw( add_query_arg( $url_args ) ), $action_add )
	);

	global $wp_query;

	$wp_query->query_vars['fairy_style_wc_compare_button'] = array(
		'url'         => $url,
		'is_button'   => $is_button,
		'product_id'  => $product_id,
		'button_text' => $button_text,
	);

	get_template_part( 'woocommerce/compare', 'button' );
	unset( $wp_query->query_vars['fairy_style_wc_compare_button'] );
}

function fairy_style_cart_link_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	fairy_style_cart_link();

	$fragments['div.cart-contents'] = ob_get_clean();

	return $fragments;
}

function fairy_style_woocommerce_result_count() {
	echo '</div><div class="col-lg-8">';
}

function fairy_style_woocommerce_open_order_wrap(){
	echo '<div class="row"><div class="col-lg-4">';
}

function fairy_style_woocommerce_close_order_wrap() {
	echo '</div></div>';
}

function fairy_style_remove_products_from_posts_search( $query ) {
global $wp_post_types;
 if ( !$query->is_admin && $query->is_search && post_type_exists( 'product' ) ) {
  $wp_post_types['product']->exclude_from_search = true;
 }
}


/**
 * Print sale and date format
 *
 * @return string
 */
function tm_products_sale_end_date() {
	global $post, $product;
	$sale_end_date = get_post_meta( $product->id, '_sale_price_dates_to', true );
	if( '' != $sale_end_date ) {
		$data_format = apply_filters( 'tm_products_sale_end_date_format', __( '%D days %H:%M:%S', 'child-theme-domian' ) );
		$sale_end_date = '<span class="tm-products-sale-end-date" data-countdown="' . date ( 'Y/m/d', $sale_end_date ) . '" data-format="' . $data_format . '"></span>';
	}
	echo $sale_end_date;
}
add_filter('tm_products_sale_end_date_format', 'fairy_style_products_format_sale_end_date');
function fairy_style_products_format_sale_end_date(){
	return	__( '<span>%D <i>days</i></span> <span>%H <i>Hrs</i></span><span>%M <i>Min</i></span>', 'fairy_style' );
}

add_filter('tm_products_carousel_widget_sale_end_date_format', 'fairy_style_format_sale_end_date');
function fairy_style_format_sale_end_date(){
	return	__( '<span>%D <i>days</i></span> <span>%H <i>Hrs</i></span><span>%M <i>Min</i></span>', 'fairy_style' );
}

function fairy_style_enqueue_main_styles() {
	if ( isset( $_GET['action'] ) && 'yith-woocompare-view-table' === $_GET['action'] ) {
		$fonts_url = fairy_style_theme()->get_core()->modules['cherry-google-fonts-loader']->get_fonts_url();
		wp_enqueue_style( 'cherry-google-fonts', $fonts_url );
		wp_enqueue_style( 'main-styles', FAIRY_STYLE_THEME_URI . '/style.css', array(), FAIRY_STYLE_THEME_VERSION );

	}
}




// function fairy_style_woocommerce_close_container_order_wrap() {
// 	echo '</section>';
// }