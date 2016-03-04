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
class Powder_WC_Widget_Product_Categories extends WC_Widget_Product_Categories {
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

		$this->widget_cssclass    = 'woocommerce widget_product_categories_image';
		$this->widget_description = __( 'A list of product image categories.', 'woocommerce' );
		$this->widget_id          = 'woocommerce_image_product_categories';
		$this->widget_name        = __( 'TM Product categories with thumbnail', 'woocommerce' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Product Categories', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' )
			),
			'orderby' => array(
				'type'  => 'select',
				'std'   => 'name',
				'label' => __( 'Order by', 'woocommerce' ),
				'options' => array(
					'order' => __( 'Category Order', 'woocommerce' ),
					'name'  => __( 'Name', 'woocommerce' )
				)
			),
			'count' => array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Show product counts', 'woocommerce' )
			),
			'hierarchical' => array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Show hierarchy', 'woocommerce' )
			),
			'hide_empty' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Hide empty categories', 'woocommerce' )
			)
		);

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

		$count              = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
		$orderby            = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];
		$hide_empty         = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];
		$list_args          = array( 'show_count' => $count, 'taxonomy' => 'product_cat', 'hide_empty' => $hide_empty );

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

		include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );
			$list_args['pad_counts']                 = 1;
			echo '<ul class="product-categories-thumbnail row">';

			$cats = get_categories( $list_args );
			foreach ($cats as $cat) {
				$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id' );
				$image = wp_get_attachment_url( $thumbnail_id );
				if( !$image ) {
					$image = wc_placeholder_img_src();
				}
				$cat_name = $cat->name;
				echo '<li class="col-lg-3 col-md-3 col-sm-6 col-xs-6"><a href="' . get_term_link( $cat ) . '">
						<figure><img src=" ' . $image .' " alt=""></figure>
						<div class="title_count">';
						do_action( 'powder_category_cat_name' , printf( '<h5>%s</h5>', $cat_name ), $cat_name );
						if ( $count ) {
							echo ' <span class="count"> ' . $cat->count . ' <em> ' .__('products', 'powder'). ' </em></span>';
						}
						echo "</div>";
				echo '</a></li>';
			}




			echo '</ul>';

		$this->widget_end( $args );
		}
	}