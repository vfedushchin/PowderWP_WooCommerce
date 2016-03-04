<?php
/**
 * powder WooCommerce Theme hooks.
 *
 * @package powder
 */

add_action( 'after_setup_theme', 'powder_woocommerce_support' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_action( 'wp_enqueue_scripts', 'powder_enqueue_assets' );

add_action( 'woocommerce_before_main_content', 'powder_enqueue_single_product_scripts' );

add_filter( 'woocommerce_sale_flash', 'powder_woocommerce_sale_flash' );

add_filter( 'powder_get_customizer_options', 'powder_add_options' );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 9 );

add_filter( 'woocommerce_get_price_html_from_to', 'powder_woocommerce_get_price_html_from_to', 10, 3 );

remove_action( 'woocommerce_single_product_summary', 'toastie_wc_smsb_form_code', 31 );

add_action( 'woocommerce_share', 'toastie_wc_smsb_form_code' );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 11 );

add_action( 'widgets_init', 'powder_override_woocommerce_widgets', 15 );

add_action( 'woocommerce_before_shop_loop_item_title', 'powder_woocommerce_show_flash' );

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

add_action( 'tm_carousel_woocommerce_before_shop_loop_item_title', 'powder_product_image_wrap_open', 2 );
add_action( 'tm_carousel_woocommerce_before_shop_loop_item_title', 'powder_product_image_wrap_close', 11 );

add_action( 'woocommerce_before_shop_loop_item', 'powder_product_image_wrap_open', 2 );
add_action( 'woocommerce_before_shop_loop_item_title', 'powder_product_image_wrap_close', 12 );

add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 3 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 10 );

add_action( 'woocommerce_after_shop_loop_item', 'powder_product_add_to_wishlist', 12 );

add_action( 'woocommerce_after_shop_loop_item', 'powder_wishlist_compare_wrap_open', 11 );
add_action( 'woocommerce_after_shop_loop_item', 'powder_wishlist_compare_wrap_close', 20 );

add_filter( 'woocommerce_show_page_title', 'powder_woocommerce_show_page_title' );

add_filter( 'woocommerce_loop_add_to_cart_link', 'powder_woocommerce_loop_add_to_cart_link', 10, 2 );

if ( 'yes' === get_option( 'yith_woocompare_compare_button_in_products_list' ) ) {
	add_action( 'init', 'powder_init_loop_compare_hook' );
}

if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'powder_cart_link_fragment' );
} else {
	add_filter( 'add_to_cart_fragments', 'powder_cart_link_fragment' );
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

add_action( 'woocommerce_before_shop_loop', 'powder_woocommerce_result_count', 31 );

add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 32 );

add_action( 'woocommerce_before_shop_loop', 'powder_woocommerce_open_order_wrap', 29 );

add_action( 'woocommerce_before_shop_loop', 'powder_woocommerce_close_order_wrap', 33 );

/**
 * Enable Woocommerce theme support
 */
function powder_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

/**
 * Check is WPML Plugin exists and enabled
 *
 * @return bool
 */
function powder_has_wpml() {
	if ( ! isset( $powder_has_wpml ) || null == $powder_has_wpml ) {
		$powder_has_wpml = in_array(
			'sitepress-multilingual-cms/sitepress.php',
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
		);
	}
	return $powder_has_wpml;
}

/**
 * Check is WooCommerce Plugin exists and enabled
 *
 * @return bool
 */
function powder_has_woocommerce() {

	if ( ! isset( $powder_has_woocommerce ) || null == $powder_has_woocommerce ) {
		$powder_has_woocommerce = in_array(
			'woocommerce/woocommerce.php',
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
		);
	}

	return $powder_has_woocommerce;

}

function powder_enqueue_assets() {

	// Jssor Slider
	wp_register_script( 'jquery-jssor', POWDER_THEME_URI . '/assets/js/jssor.slider.mini.js', array( 'jquery' ), '1.0.0', true );

	// Easyzoom
	wp_register_script( 'jquery-easyzoom', POWDER_THEME_URI . '/assets/js/easyzoom.js', array( 'jquery' ), '2.3.1', true );

	wp_enqueue_style( 'blank-style-woo', POWDER_THEME_URI . '/assets/css/pulicapus.css', array(), POWDER_THEME_VERSION );

	wp_enqueue_style( 'blank-style-morpeh', POWDER_THEME_URI . '/assets/css/morpeh.css', array(), POWDER_THEME_VERSION );

	// Navbar
    wp_enqueue_script( 'navbar-script', POWDER_THEME_URI . '/assets/js/jquery.rd-navbar.js', array(), '1.0.0', true );
}

/**
 * Enqueue Jssor Slider.
 *
 * @since 1.0.0
 */
function powder_enqueue_single_product_scripts() {

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
function powder_woocommerce_sale_flash() {
	return '<span class="onsale">' . __( 'Sale', 'child-theme-domain' ) . '</span>';
}

/**
 * Add extra customizer options
 *
 * @param  array $args Existing options.
 * @return array
 */
function powder_add_options( $args ) {
	if ( powder_has_wpml() ) {
		$args['options']['top_language_selector'] = array(
			'title'   => esc_html__( 'On/Off Language Selector', 'powder' ),
			'section' => 'header_top_panel',
			'default' => true,
			'field'   => 'checkbox',
			'type'    => 'control',
		);
	}
	if( powder_has_woocommerce() ) {
		$args['options']['woocommerce'] = array(
			'title'       => esc_html__( 'Woocommerce', 'powder' ),
			'description' => esc_html__( 'Description', 'powder' ),
			'priority'    => 200,
			'type'        => 'section'
		);
		$args['options']['single_product_slider_layout'] = array(
			'title'       => esc_html__( 'Single product slider layout', 'powder' ),
			'section' => 'woocommerce',
			'default' => 'vertical',
			'field'   => 'radio',
			'choices' => array(
				'vertical' => esc_html__( 'Vertical', 'powder' ),
				'horizontal'  => esc_html__( 'Horizontal', 'powder' ),
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
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count"><span class="count__number">' . $category->count . '</span> ' . __('products', 'powder') . '</mark>' , $category );
		?>
	</h3>
	<?php
}

/**
 * Override Woocommerce Standard Widgets
 */
function powder_override_woocommerce_widgets() {
  if ( class_exists( 'WC_Widget_Recent_Reviews' ) ) {
	unregister_widget( 'WC_Widget_Recent_Reviews' );
	include_once( 'widgets/tm-wc-recent-reviews-products/class-tm-reviews-product-widget.php' );
	register_widget( 'Powder_WC_Widget_Recent_Reviews' );
  }
  if ( class_exists( 'WP_Widget_Recent_Posts' ) ) {
	unregister_widget( 'WP_Widget_Recent_Posts' );
	include_once( 'widgets/tm-wc-recent-post/class-tm-widget-recent-posts.php' );
	register_widget( 'Powder_WP_Widget_Recent_Posts' );
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
function powder_woocommerce_get_price_html_from_to( $price, $from, $to ) {

	$price = '<ins>' . ( ( is_numeric( $to ) ) ? wc_price( $to ) : $to ) . '</ins> <del>' . ( ( is_numeric( $from ) ) ? wc_price( $from ) : $from ) . '</del>';

	return $price;
}

/**
 * Add WooCommerce 'New' and 'Featured' Flashes
 *
 * @return string
 */
function powder_woocommerce_show_flash() {

	global $product, $woocommerce_loop;

	if( !$product->is_on_sale() ) {

		if ( ( date('U') - strtotime($product->post->post_date) ) < 604800 ) {
			echo '<span class="new">' . __( 'New', 'powder' ) . '</span>';
		}

		else if( $product->is_featured() ) {
			echo '<span class="featured">' . __( 'Featured', 'powder' ) . '</span>';
		}
	}
}

/**
 * Add WooCommerce 'Add to wishlist' Button in TM Products Carousel Widget
 *
 * @return string
 */
function powder_product_add_to_wishlist() {
	echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
}

/**
 * Open wrap product loop elements
 *
 * @return string
 */
function powder_product_image_wrap_open() {
	echo "<div class='block_product_thumbnail'>";
}
/**
 * Close wrap product loop elements
 *
 * @return string
 */
function powder_product_image_wrap_close() {
	echo "</div>";
}

/**
 * Open wrap wishlist and compare buttons
 *
 * @return string
 */
function powder_wishlist_compare_wrap_open() {
	echo "<div class='block_wishlist_compare'>";
}

/**
 * Close wrap wishlist and compare buttons
 *
 * @return string
 */
function powder_wishlist_compare_wrap_close() {
	echo "</div>";
}

/**
 * Disable WooCommerce Page Title
 *
 * @return string
 */
function powder_woocommerce_show_page_title() {
	return false;
}

/**
 * Modify WooCommerce Add to cart Button in Loop
 *
 * @param  array $product Button object
 * @param  string $link
 * @return string
 */
function powder_woocommerce_loop_add_to_cart_link( $link, $product ) {
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
		. '<span class="product_actions_tip add_to_cart_button__text added">' . __( 'Added to cart! ', 'child-theme-domain' ) . '</span>' : '<span class="material-icons">visibility</span><span class="product_actions_tip add_to_cart_button__text select">' . esc_html( $product->add_to_cart_text() ) . '</span>'
	);
}

/**
 * Add Custom compare button hook in products loop
 *
 */
function powder_init_loop_compare_hook() {

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
			add_action( 'woocommerce_after_shop_loop_item', 'powder_add_loop_compare', 12 );
		}
	}
}

/**
 * Print compare button in products loop
 *
 * @return string
 */
function powder_add_loop_compare() {

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

	$wp_query->query_vars['powder_wc_compare_button'] = array(
		'url'         => $url,
		'is_button'   => $is_button,
		'product_id'  => $product_id,
		'button_text' => $button_text,
	);

	get_template_part( 'woocommerce/compare', 'button' );
	unset( $wp_query->query_vars['powder_wc_compare_button'] );
}

function powder_cart_link_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	powder_cart_link();

	$fragments['div.cart-contents'] = ob_get_clean();

	return $fragments;
}

function powder_woocommerce_result_count() {
	echo '</div><div class="col-lg-8">';
}

function powder_woocommerce_open_order_wrap(){
	echo '<div class="row"><div class="col-lg-4">';
}

function powder_woocommerce_close_order_wrap() {
	echo '</div></div>';
}