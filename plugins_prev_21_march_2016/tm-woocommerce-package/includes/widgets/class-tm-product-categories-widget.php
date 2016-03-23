<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Woocommerce Image Product Categories
 *
 * @author   WooThemes
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.3.0
 * @extends  WC_Widget
 */

/*Extend widget Woocommerce Product Categories*/

include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );

class __TM_Product_Categories_Widget extends WC_Widget_Product_Categories {
	/**
	 * Category ancestors.
	 *
	 * @var array
	 */
	public $cat_ancestors;

	/**
	 * Current Category.
	 *
	 * @var bool
	 */
	public $current_cat;

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->widget_cssclass    = 'woocommerce widget_product_categories_image';
		$this->widget_description = __( 'A list of product image categories.', 'tm-woocommerce-package' );
		$this->widget_id          = 'woocommerce_image_product_categories';
		$this->widget_name        = __( 'TM Product categories with thumbnail', 'tm-woocommerce-package' );

		$this->settings['tm_products_carousel_widget_visible'] = array(
			'type'  => 'number',
			'step'  => 1,
			'min'   => 1,
			'max'   => '',
			'std'   => 4,
			'label' => __( 'Number of visible products', 'tm-woocommerce-package' )
		);

		$this->settings['tm_categories_carousel_widget_navigation'] = array(
			'type'  => 'label',
			'label' => __( 'Navigation', 'tm-woocommerce-package' )
		);

		$this->settings['tm_categories_carousel_widget_arrows'] = array(
			'type'  => 'checkbox',
			'std'   => 1,
			'label' => __( 'Arrows', 'tm-woocommerce-package' )
		);

		$this->settings['tm_categories_carousel_widget_pagination'] = array(
			'type'  => 'checkbox',
			'std'   => 0,
			'label' => __( 'Pagination', 'tm-woocommerce-package' )
		);

		unset( $this->settings['dropdown'] );
		unset( $this->settings['hierarchical'] );
		unset( $this->settings['show_children_only'] );

		WC_Widget::__construct();
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		global $wp_query, $post;

		wp_enqueue_script( 'jquery-swiper' );

		wp_enqueue_script( 'tm-categories-carousel-widget-init' );

		$count              = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
		$hierarchical       = false;
		$dropdown           = false;
		$orderby            = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];
		$hide_empty         = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];
		$list_args          = array( 'show_count' => $count, 'hierarchical' => $hierarchical, 'taxonomy' => 'product_cat', 'hide_empty' => $hide_empty );
		$visible = isset( $instance['tm_products_carousel_widget_visible'] ) ? $instance['tm_products_carousel_widget_visible'] : 4;

		// Menu Order
		$list_args['menu_order'] = false;
		if ( $orderby == 'order' ) {
			$list_args['menu_order'] = 'asc';
		} else {
			$list_args['orderby']    = 'title';
		}

		// Setup Current Category
		$this->current_cat   = false;
		$this->cat_ancestors = array();

		if ( is_tax( 'product_cat' ) ) {

			$this->current_cat   = $wp_query->queried_object;
			$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );

		} elseif ( is_singular( 'product' ) ) {

			$product_category = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent' ) );

			if ( $product_category ) {
				$this->current_cat   = end( $product_category );
				$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );
			}

		}

		$this->widget_start( $args, $instance );

		$uniqid = uniqid();

		$list_args['walker']                     = new TM_WC_Product_Cat_List_Walker;
		$list_args['title_li']                   = '';
		$list_args['pad_counts']                 = 1;
		$list_args['show_option_none']           = __('No product categories exist.', 'woocommerce' );
		$list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';
		$list_args['current_category_ancestors'] = $this->cat_ancestors;

		$cats = get_terms( 'product_cat', $list_args );

		if( count( $cats ) < $visible ) {
			$visible = count( $cats );
		}

		$data_attrs[] = 'data-uniq-id="swiper-carousel-' . $uniqid . '"';
		$data_attrs[] = 'data-slides-per-view="' . $visible . '"';
		$data_attrs[] = 'data-slides-per-group="1"';
		$data_attrs[] = 'data-slides-per-column="1"';
		$data_attrs[] = 'data-space-between-slides="60"';
		$data_attrs[] = 'data-duration-speed="500"';
		$data_attrs[] = 'data-swiper-loop="false"';
		$data_attrs[] = 'data-free-mode="false"';
		$data_attrs[] = 'data-grab-cursor="true"';
		$data_attrs[] = 'data-mouse-wheel="false"';

		$start_html[] = '<div class="woocommerce swiper-container tm-categories-carousel-widget-container" id="swiper-carousel-' . $uniqid . '" ' . implode ( " ", $data_attrs ) . '>';
		$start_html[] = '<div class="swiper-wrapper tm-categories-carousel-widget-wrapper">';

		echo implode ( "\n", $start_html );

		wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );

		$arrows = ( ! empty( $instance['tm_categories_carousel_widget_arrows'] ) ) ? $instance['tm_categories_carousel_widget_arrows'] : 0;
		$pagination = ( ! empty( $instance['tm_categories_carousel_widget_pagination'] ) ) ? $instance['tm_categories_carousel_widget_pagination'] : 0;
		$end_html[] = '</div>';
		if($pagination){
			$end_html[] = '<div id="swiper-carousel-'. $uniqid . '-pagination" class="swiper-pagination tm-categories-carousel-widget-pagination"></div>';
		}
		if($arrows){
			$end_html[] = '<div id="swiper-carousel-'. $uniqid . '-next" class="swiper-button-next tm-categories-carousel-widget-button-next"></div>';
			$end_html[] = '<div id="swiper-carousel-'. $uniqid . '-prev" class="swiper-button-prev tm-categories-carousel-widget-button-prev"></div>';
		}
		$end_html[] = '</div>';

		echo implode ( "\n", $end_html );

		$this->widget_end( $args );
	}
}

class TM_WC_Product_Cat_List_Walker extends WC_Product_Cat_List_Walker {

	public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {

		$html = array();

		$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id' );
		$image = wp_get_attachment_image_src( $thumbnail_id,  apply_filters( 'tm_categories_carousel_widget_thumb_size', 'shop_catalog' ) );

		if( !is_array( $image ) ) {
			$image = wc_placeholder_img_src();
		} else {
			$image = $image[0];
		}

		$cat_name = $cat->name;

		$html[] ='<div class="swiper-slide tm-categories-carousel-widget-slide">';
		$html[] ='<a class="tm-categories-carousel-widget-link" href="' . get_term_link( (int) $cat->term_id ) . '">';
		$html[] ='<img class="tm-categories-carousel-widget-thumb" src="' . $image .'" alt="' . $cat_name . '">';
		$html[] ='<div class="tm-categories-carousel-widget-title__wrapper">';
		$html[] = apply_filters( 'tm_categories_carousel_widget_name' , sprintf( '<h5 class="tm-categories-carousel-widget-title">%s</h5>', $cat_name ), $cat_name );

		if ( $args['show_count'] ) {
			$cat_count = $cat->count;
			$html[] = apply_filters( 'tm_categories_carousel_widget_count', sprintf( '<span class="tm-categories-carousel-widget-count"><span class="tm-categories-carousel-widget-count__number">%s</span> %s</span>', $cat_count, __( 'products', 'tm-woocommerce-package' ) ), $cat_count );
		}

		$html[] ='</div>';

		$output .= implode ( "\n", $html );
	}

	public function end_el( &$output, $cat, $depth = 0, $args = array() ) {
		$output .= "</a>\n</div>\n";
	}
}