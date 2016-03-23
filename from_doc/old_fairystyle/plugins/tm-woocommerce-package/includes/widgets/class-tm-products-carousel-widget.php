<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WC_Widget_Products' ) ) {

	class __TM_Products_Carousel_Widget extends WC_Widget_Products {

		public $tm_wc;

		public function __construct() {
			parent::__construct();
			$tm_wc = new TM_Woocommerce;
			$this->widget_cssclass    = '__tm_products_carousel_widget';
			$this->widget_description = __( 'TM widget to create products carousel', 'tm-woocommerce-package' );
			$this->widget_id          = '__tm_products_carousel_widget';
			$this->widget_name        = __( 'TM Products Carousel Widget', 'tm-woocommerce-package' );

			$this->settings['tm_filter_by_category'] = array(
				'type'  => 'select',
				'std'   => 'all-categories',
				'options' => $tm_wc->tm_get_products_cats(),
				'label' => __( 'Filter by category', 'tm-woocommerce-package' )
			);

			$this->settings['tm_filter_by_tag'] = array(
				'type'  => 'select',
				'std'   => 'all-tags',
				'options' => $tm_wc->tm_get_products_tags(),
				'label' => __( 'Filter by tag', 'tm-woocommerce-package' )
			);

			$this->settings['tm_products_carousel_widget_visible'] = array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 4,
				'label' => __( 'Number of visible products', 'tm-woocommerce-package' )
			);

			$this->settings['tm_products_carousel_widget_meta'] = array(
				'type'  => 'label',
			'std' => '',
				'label' => __( 'Product Meta', 'tm-woocommerce-package' )
			);

			$this->settings['tm_products_carousel_widget_title'] = array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Title', 'tm-woocommerce-package' )
			);

			$this->settings['tm_products_carousel_widget_price'] = array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Price', 'tm-woocommerce-package' )
			);

			$this->settings['tm_products_carousel_widget_desc'] = array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Description', 'tm-woocommerce-package' )
			);

			$this->settings['tm_products_carousel_widget_desc_limit'] = array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 0,
				'max'   => '',
				'std'   => 10,
				'label' => __( 'Description Limit', 'tm-woocommerce-package' )
			);

			$this->settings['tm_products_carousel_widget_tag'] = array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Tag', 'tm-woocommerce-package' )
			);

			$this->settings['tm_products_carousel_widget_cat'] = array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Category', 'tm-woocommerce-package' )
			);

			$this->settings['tm_products_carousel_widget_navigation'] = array(
				'type'  => 'label',
			'std' => '',
				'label' => __( 'Navigation', 'tm-woocommerce-package' )
			);

			$this->settings['tm_products_carousel_widget_arrows'] = array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Arrows', 'tm-woocommerce-package' )
			);

			$this->settings['tm_products_carousel_widget_pagination'] = array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Pagination', 'tm-woocommerce-package' )
			);

			WC_Widget::__construct();
		}

		public function __tm_products_carousel_widget_enqueue_files() {

			wp_enqueue_style( 'tm-products-carousel-widget-styles' );

			wp_enqueue_script( 'jquery-swiper' );

			wp_enqueue_script( 'jquery-countdown' );

			wp_enqueue_script( 'tm-products-carousel-widget-init' );

			include_once( plugin_dir_path( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'woocommerce/includes/class-wc-frontend-scripts.php' );

			if ( $enqueue_styles = WC_Frontend_Scripts::get_styles() ) {
				foreach ( $enqueue_styles as $handle => $args ) {
					wp_enqueue_style($handle, $args['src'], $args['deps'], $args['version'], $args['media']);
				}
			}

		}

		public function tm_products_carousel_widget_desc () {

			$content = get_the_content();

			$instances = $this->get_settings();
			if ( array_key_exists( $this->number, $instances ) ) {
				$instance = $instances[ $this->number ];
				$limit = ! empty( $instance['tm_products_carousel_widget_desc_limit'] ) ? $instance['tm_products_carousel_widget_desc_limit'] : 0;
				if(  0 < $limit ) {
					$content = implode( ' ', array_slice( explode( ' ', trim ( strip_tags( get_the_content() ) ) ), 0, $limit ) );
				}
			}
			echo '<div class="tm_products_carousel_widget_product_desc">' . $content . '</div>';
		}

		public function widget( $args, $instance ) {
			if ( $this->get_cached_widget( $args ) ) {
				return;
			}

			ob_start();

			if ( ( $products = $this->get_products( $args, $instance ) ) && $products->have_posts() ) {

				// Include swiper styles, jquery plugin and init to page
				self::__tm_products_carousel_widget_enqueue_files();

				$this->widget_start( $args, $instance );

				$uniqid = uniqid();

				if (0 === $instance['tm_products_carousel_widget_title']) {
					remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
				}

				if (0 === $instance['tm_products_carousel_widget_price']) {
					remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
				}

				if (1 === $instance['tm_products_carousel_widget_desc']) {

					$desc_action = apply_filters( 'tm_products_carousel_widget_desc_action', 'woocommerce_after_shop_loop_item_title' );
					$desc_priority = apply_filters( 'tm_products_carousel_widget_desc_priority', 0 );

					add_action( $desc_action, array( $this, 'tm_products_carousel_widget_desc' ), $desc_priority );
				}

				if (1 === $instance['tm_products_carousel_widget_cat']) {

					$cat_action = apply_filters( 'tm_products_carousel_widget_cat_action', 'woocommerce_after_shop_loop_item' );
					$cat_priority = apply_filters( 'tm_products_carousel_widget_cat_priority', 6 );

					add_action( $cat_action, 'tm_products_carousel_widget_cat', $cat_priority );
				}

				if (1 === $instance['tm_products_carousel_widget_tag']) {

					$tag_action = apply_filters( 'tm_products_carousel_widget_cat_action', 'woocommerce_after_shop_loop_item' );
					$tag_priority = apply_filters( 'tm_products_carousel_widget_cat_priority', 6 );

					add_action( $tag_action, 'tm_products_carousel_widget_tag', $tag_priority );
				}

				$between = apply_filters( 'tm_products_carousel_widget_spece_between_slides', 30 );

				$data_attrs[] = 'data-uniq-id="swiper-carousel-' . $uniqid . '"';
				$data_attrs[] = 'data-slides-per-view="' . $instance['tm_products_carousel_widget_visible'] . '"';
				$data_attrs[] = 'data-slides-per-group="1"';
				$data_attrs[] = 'data-slides-per-column="1"';
				$data_attrs[] = 'data-space-between-slides="' . $between . '"';
				$data_attrs[] = 'data-duration-speed="500"';
				$data_attrs[] = 'data-swiper-loop="false"';
				$data_attrs[] = 'data-free-mode="false"';
				$data_attrs[] = 'data-grab-cursor="true"';
				$data_attrs[] = 'data-mouse-wheel="false"';

				$start_html[] = '<div class="woocommerce swiper-container tm-products-carousel-widget-container" id="swiper-carousel-' . $uniqid . '" ' . implode ( " ", $data_attrs ) . '>';
				$start_html[] = '<div class="swiper-wrapper tm-products-carousel-widget-wrapper products">';
				echo implode ( "\n", $start_html );

				while ( $products->have_posts() ) {

					$products->the_post();

					wc_get_template( 'tm-carousel-widget-product.php', array(), '', tm_wc()->plugin_dir() . '/templates/' );

				}

				$arrows = ( ! empty( $instance['tm_products_carousel_widget_arrows'] ) ) ? $instance['tm_products_carousel_widget_arrows'] : 0;
				$pagination = ( ! empty( $instance['tm_products_carousel_widget_pagination'] ) ) ? $instance['tm_products_carousel_widget_pagination'] : 0;
				$end_html[] = '</div>';
				if($pagination){
					$end_html[] = '<div id="swiper-carousel-'. $uniqid . '-pagination" class="swiper-pagination tm-products-carousel-widget-pagination"></div>';
				}

				if($arrows){
					$end_html[] = '<div id="swiper-carousel-'. $uniqid . '-next" class="swiper-button-next tm-products-carousel-widget-button-next"><i class="material-icons">navigate_next</i></div>';
					$end_html[] = '<div id="swiper-carousel-'. $uniqid . '-prev" class="swiper-button-prev tm-products-carousel-widget-button-prev"><i class="material-icons">navigate_before</i></div>';
				}
				$end_html[] = '</div>';
				echo implode ( "\n", $end_html );
				$this->widget_end( $args );
			}

			wp_reset_postdata();

			echo $this->cache_widget( $args, ob_get_clean() );
		}

		public function get_products( $args, $instance ) {

			$number  = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
			$show    = ! empty( $instance['show'] ) ? sanitize_title( $instance['show'] ) : $this->settings['show']['std'];
			$orderby = ! empty( $instance['orderby'] ) ? sanitize_title( $instance['orderby'] ) : $this->settings['orderby']['std'];
			$order   = ! empty( $instance['order'] ) ? sanitize_title( $instance['order'] ) : $this->settings['order']['std'];

			$query_args = array(
				'posts_per_page' => $number,
				'post_status'    => 'publish',
				'post_type'      => 'product',
				'no_found_rows'  => 1,
				'order'          => $order,
				'meta_query'     => array()
			);

			if ( empty( $instance['show_hidden'] ) ) {
				$query_args['meta_query'][] = WC()->query->visibility_meta_query();
				$query_args['post_parent']  = 0;
			}

			if ( ! empty( $instance['hide_free'] ) ) {
				$query_args['meta_query'][] = array(
					'key'     => '_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'DECIMAL',
				);
			}

			$query_args['meta_query'][] = WC()->query->stock_status_meta_query();
			$query_args['meta_query']   = array_filter( $query_args['meta_query'] );

			if( 'all-categories' !== $instance['tm_filter_by_category'] ) {
				$query_args['tax_query'] = array(
					array(
						'taxonomy' => 'product_cat',
						'field' => 'term_taxonomy_id',
						'terms' => $instance['tm_filter_by_category']
					)
				);
			}

			if( 'all-tags' !== $instance['tm_filter_by_tag'] ) {
				$query_args['product_tag'] = $instance['tm_filter_by_tag'];
			}

			switch ( $show ) {
				case 'featured' :
					$query_args['meta_query'][] = array(
						'key'   => '_featured',
						'value' => 'yes'
					);
					break;
				case 'onsale' :
					$product_ids_on_sale    = wc_get_product_ids_on_sale();
					$product_ids_on_sale[]  = 0;
					$query_args['post__in'] = $product_ids_on_sale;
					break;
			}

			switch ( $orderby ) {
				case 'price' :
					$query_args['meta_key'] = '_price';
					$query_args['orderby']  = 'meta_value_num';
					break;
				case 'rand' :
					$query_args['orderby']  = 'rand';
					break;
				case 'sales' :
					$query_args['meta_key'] = 'total_sales';
					$query_args['orderby']  = 'meta_value_num';
					break;
				default :
					$query_args['orderby']  = 'date';
			}

			return new WP_Query( apply_filters( 'tm_products_carousel_widget_query_args', $query_args ) );

		}

	}

}

?>