<?php

if ( class_exists( 'WC_Widget_Products' ) ) {

	class __TM_Products_Smart_Box_Widget extends WC_Widget_Products {

		public $tm_wc;

		public function __construct() {
			parent::__construct();
			$tm_wc = new TM_Woocommerce;
			$this->widget_cssclass    = '__tm_products_smart_box_widget';
			$this->widget_description = __( 'TM widget to create products Smart Box', 'tm-woocommerce-package' );
			$this->widget_id          = '__tm_products_smart_box_widget';
			$this->widget_name        = __( 'TM Products Smart Box Widget', 'tm-woocommerce-package' );

			unset($this->settings['show']);

			$this->settings['tm_filter_by_category'] = array(
				'type'  => 'multiselect',
				'std'   => 'all-categories',
				'options' => $tm_wc->tm_get_products_cats(),
				'label' => __( 'Filter by category', 'tm-woocommerce-package' )
			);

			WC_Widget::__construct();
		}

		public function __tm_products_smart_box_widget_enqueue_files() {

			wp_enqueue_style( 'jquery-rd-material-tabs' );

			wp_enqueue_script( 'jquery-rd-material-tabs' );

		}

		public function form( $instance ) {

			parent::form( $instance );

			$tm_wc = new TM_Woocommerce;

			$tm_wc->tm_widgets_form_multiselect( $instance, $this );

		}

		public function update( $new_instance, $old_instance ) {
			add_action( 'woocommerce_widget_settings_sanitize_option', 'tm_products_smart_box_widget_settings_sanitize_option', 10, 4 );
			return parent::update( $new_instance, $old_instance );
		}

		public function widget( $args, $instance ) {

			if ( $this->get_cached_widget( $args ) ) {
				return;
			}

			ob_start();

			$tm_filter_by_category = ! empty( $instance['tm_filter_by_category'] ) ? $instance['tm_filter_by_category']: false;

			if ( $tm_filter_by_category && is_array( $tm_filter_by_category ) && !in_array( 'all-categories', $instance['tm_filter_by_category'] ) ) {
				$categories = get_terms( 'product_cat', array( 'include' => implode ( ', ', $instance['tm_filter_by_category'] ) ) );
			} else {
				$categories = get_terms( 'product_cat' );
			}

			$start_html[] = '<!-- RD Material Tabs -->';
			$start_html[] = '<section class="woocommerce rd-material-tabs tm-products-smart-box-widget__rd-material-tabs">';
			$start_html[] = '<div class="row">';
			$start_html[] = '<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">';
			if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base ) ) {
				$start_html[] = $args['before_title'] . $title . $args['after_title'];
			}
			$start_html[] = '<div class="rd-material-tabs__list tm-products-smart-box-widget__rd-material-tabs__list">';
			$start_html[] = '<!-- List of tab headings -->';
			$start_html[] = '<ul>';

			$is_html = false;

			foreach ( $categories as $key => $category ) {

				$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id' );

				$image = wp_get_attachment_url( $thumbnail_id );

				if( !$image ) {
					$image = wc_placeholder_img_src();
				}

				$categories[$key]->thumb = $image;

				$args['category'] = $category->term_taxonomy_id;

				$products[$key] = $this->get_products_category( $args, $instance );

				if ( ( $products[$key] ) && $products[$key]->have_posts() ) {

					$is_html = true;

					$nav_html[] = '<li>';
					$nav_html[] = '<a href="#">' . $category->name . '</a>';
					$nav_html[] = '</li>';

				}

			}

			$nav_html[] = '</ul>';
			$nav_html[] = '</div>';
			$nav_html[] = '</div>';

			$nav_html[] = '<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">';

			$nav_html[] = '<!-- Container for your content -->';
			$nav_html[] = '<div class="rd-material-tabs__container tm-products-smart-box-widget__rd-material-tabs__container">';

			if( $is_html ) {

				// Include rd-material-tabs styles, jquery plugin and init to page
				self::__tm_products_smart_box_widget_enqueue_files();

				echo $args['before_widget'];

				echo implode ( "\n", $start_html );

				echo implode ( "\n", $nav_html );

				foreach ( $categories as $key => $category ) {

					if ( ( $products[$key] ) && $products[$key]->have_posts() ) { ?>

					<div>
						<div class="row">
							<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
								<div class="row">
								<?php while ( $products[$key]->have_posts() ) {

									$products[$key]->the_post();

									wc_get_template( 'tm-smart-box-widget-product.php', array(), '', tm_wc()->plugin_dir() . '/templates/' );

								} ?>
								</div>
							</div>
							<div class="col-lg-4 col-md-12 col-sm-4 col-xs-6">
								<img src="<?php echo $category->thumb; ?>">
							</div>
						</div>
					</div>
					<?php }
				}

				$end_html[] = '</div>';
				$end_html[] = '</div>';
				$end_html[] = '</div>';
				$end_html[] = '</section>';
				$end_html[] = '<!-- END RD Material Tabs-->';

				echo implode ( "\n", $end_html );

				$this->widget_end( $args );

			}

			wp_reset_postdata();

			echo $this->cache_widget( $args, ob_get_clean() );
		}

		public function get_products_category( $args, $instance ) {

			$number  = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
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

			$tax_query = array();

			$tax_query[] = array(
				'taxonomy' => 'product_cat',
				'field' => 'term_taxonomy_id',
				'terms' => $args['category']
			);

			$query_args['tax_query'] = $tax_query;

			$query_args['meta_query'][] = array(
				'key'   => '_featured',
				'value' => 'yes'
			);

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

			return new WP_Query( apply_filters( 'tm_products_smart_box_widget_query_args', $query_args ) );

		}

	}

}

?>