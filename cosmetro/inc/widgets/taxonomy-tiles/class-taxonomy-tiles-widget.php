<?php
/**
 * Taxonomy Tiles widget.
 *
 * @package __Tm
 */

if ( ! class_exists( 'Cosmetro_Taxonomy_Tiles_Widget' ) ) {

	class Cosmetro_Taxonomy_Tiles_Widget extends Cherry_Abstract_Widget {

		public $tiles_matrix = array(
			array( 'tile-xl-x', 'tile-xl-y' ),
			array( 'tile-md-x', 'tile-md-y' ),
			array( 'tile-md-x', 'tile-md-y' ),
			array( 'tile-md-x', 'tile-md-y' ),
			array( 'tile-md-x', 'tile-md-y' ),
			array( 'tile-sm-x', 'tile-sm-y' ),
			array( 'tile-sm-x', 'tile-sm-y' ),
			array( 'tile-sm-x', 'tile-sm-y' ),
			array( 'tile-sm-x', 'tile-sm-y' ),
			array( 'tile-sm-x', 'tile-sm-y' ),
			array( 'tile-sm-x', 'tile-sm-y' ),
		);

		/**
		 * Taxonomy Tiles widget constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->widget_name			= esc_html__( 'Taxonomy Tiles', 'cosmetro' );
			$this->widget_description	= esc_html__( 'This widget displays images from taxonomy.', 'cosmetro' );
			$this->widget_id			= 'widget-taxonomy-tiles';
			$this->widget_cssclass		= 'widget-taxonomy-tiles';

			$this->settings = array(
				'title'	=> array(
					'type'				=> 'text',
					'value'				=> 'Taxonomy Tiles Widget',
					'label'				=> esc_html__( 'Widget title', 'cosmetro' ),
				),
				'terms_type' => array(
					'type'				=> 'radio',
					'value'				=> 'category',
					'options'			=> array(
						'category' => array(
							'label'		=> esc_html__( 'Category', 'cosmetro' ),
							'slave'		=> 'terms_type_post_category',
						),
						'post_tag' => array(
							'label'		=> esc_html__( 'Tag', 'cosmetro' ),
							'slave'		=> 'terms_type_post_tag',
						),
					),
					'label'				=> esc_html__( 'Choose taxonomy type', 'cosmetro' ),
				),
				'category'=> array(
					'type'				=> 'select',
					'multiple'			=> true,
					'value'				=> '',
					'options'			=> false,
					'options_callback'	=> array( $this, 'get_terms_list' ),
					'label'				=> esc_html__( 'Select category to show', 'cosmetro' ),
					'master'			=> 'terms_type_post_category',
				),
				'post_tag' => array(
					'type'				=> 'select',
					'multiple'			=> true,
					'value'				=> '',
					'options'			=> false,
					'options_callback'	=> array( $this, 'get_terms_list', array('post_tag') ),
					'label'				=> esc_html__( 'Select tags to show', 'cosmetro' ),
					'master'			=> 'terms_type_post_tag',
				),
				'description_length' => array(
					'type'				=> 'stepper',
					'value'				=> '0',
					'max_value'			=> '500',
					'min_value'			=> '0',
					'step_value'		=> '1',
					'label'				=> esc_html__( 'Description words length ( Set 0 to hide description. )', 'cosmetro' ),
				),
				'show_post_count' => array(
					'type'				=> 'checkbox',
					'value'			=> array(
						'show_post_count_check' => 'true',
					),
					'options'		=> array(
						'show_post_count_check' => esc_html__( 'Show post count', 'cosmetro' ),
					),
				),
				'layout_type' => array(
					'type'				=> 'radio',
					'value'				=> 'grid',
					'options'			=> array(
						'grid' => array(
							'label'		=> esc_html__( 'Grid', 'cosmetro' ),
						),
						'tiles' => array(
							'label'		=> esc_html__( 'Tiles', 'cosmetro' ),
						),
					),
					'label'				=> esc_html__( 'Choose Layout Type', 'cosmetro' ),
				),
				'columns_number' => array(
					'type'				=> 'stepper',
					'value'				=> '2',
					'max_value'			=> '4',
					'min_value'			=> '1',
					'step_value'		=> '1',
					'label'				=> esc_html__( 'Columns number ( layout type grid )', 'cosmetro' ),
				),
				'items_padding' => array(
					'type'				=> 'stepper',
					'value'				=> '5',
					'max_value'			=> '50',
					'min_value'			=> '0',
					'step_value'		=> '1',
					'label'				=> esc_html__( 'Items padding ( size in pixels )', 'cosmetro' ),
				),
			);

			parent::__construct();
		}

		/**
		 * Return terms list.
		 *
		 * @since  1.0.0
		 * @return array
		 */
		public function get_terms_list ( $tax = 'category', $args = array( 'hide_empty' => 0, 'hierarchical' => 0 ) ) {

			if( ! array_key_exists( 'include', $args ) ) {
				$args['include'] = array();
			}

			$terms = $this->get_terms( $tax, $args );
			$output_terms = array();

			if ( $terms ) {
				foreach ( $terms as $term ) {
					$output_terms[ $term->term_id ] = $term->name . sprintf( _n( ' ( 1 post )', ' ( %s posts )', $term->count, 'cosmetro' ), $term->count );
				}
			}

			return $output_terms;
		}

		/**
		 * Return terms.
		 *
		 * @since  1.0.0
		 * @return array
		 */
		public function get_terms( $tax, $args ) {
			return get_terms( $tax, $args );
		}

		/**
		 * Get term title.
		 *
		 * @since  1.0.0
		 * @return string
		 */
		public function get_term_title( $term ) {
			return $term->name;
		}

		/**
		 * Get term link.
		 *
		 * @since  1.0.0
		 * @return string
		 */
		public function get_term_link( $term ) {
			return get_category_link( $term->term_id );
		}

		/**
		 * Get term post count.
		 *
		 * @since  1.0.0
		 * @return string
		 */
		public function get_term_post_count( $term, $visible ) {
			return ( 'false' === $visible ) ? '' : '<span class="post-count">' . sprintf( _n( '1 post', '%s posts', $term->count, 'cosmetro' ), $term->count ) . '</span>';
		}

		/**
		 * Get term description.
		 *
		 * @since  1.0.0
		 * @return string
		 */
		public function get_term_description( $term, $lenght ) {
			$lenght = intval( $lenght );

			return ( 0 === $lenght || ! $term->description ) ? '' : '<p class="post-desc">' . wp_trim_words( $term->description, $lenght, '&hellip;' ) . '</p>';
		}

		/**
		 * Get image size.
		 *
		 * @since  1.0.0
		 * @return array
		 */
		private function get_image_size( $wp_image_size ) {
			global $_wp_additional_image_sizes;

			return $_wp_additional_image_sizes[ $wp_image_size ];
		}
		/**
		 * Get term image.
		 *
		 * @since  1.0.0
		 * @return string
		 */
		public function get_term_image( $term, $image_size = '_tm-thumb-m', $image_mobile_size = '_tm-thumb-s', $image_type = 'img' ) {
			$id         = get_term_meta( $term->term_id, '_tm_thumb' , true );
			$size       = wp_is_mobile() ? $image_mobile_size : $image_size;
			$size_array = $this->get_image_size( $size );

			if ( $id ) {
				$src = wp_get_attachment_image_url( $id, $size );

			} else {

				// Place holder defaults attr
				$placeholder_attr = apply_filters( 'cosmetro_taxonomy_tiles_widget_placeholder_default_args', array(
					'width'			=> $size_array['width'],
					'height'		=> $size_array['height'],
					'background'	=> $this->hex_to_string( get_theme_mod( 'regular_accent_color_1', cosmetro_theme()->customizer->get_default( 'regular_accent_color_1' ) ) ),
					'foreground'	=> $this->hex_to_string( get_theme_mod( 'regular_accent_color_2', cosmetro_theme()->customizer->get_default( 'regular_accent_color_2' ) ) ),
					'title'			=> $size_array['width'] . 'x' . $size_array['height'],
				) );

				$placeholder_attr = array_map( 'esc_attr', $placeholder_attr );

				$src = 'http://fakeimg.pl/' . $placeholder_attr['width'] . 'x' . $placeholder_attr['height'] . '/'. $placeholder_attr['background'] .'/'. $placeholder_attr['foreground'] . '/?text=' . $placeholder_attr['title'] . '';
			}

			if ( 'img' === $image_type ) {
				return '<img class="term-img" src="' . esc_url( $src ) . '" alt="' . esc_attr( $term->name ) . '">';
			} else {
				return '<span class="term-img" style="background-image: url(\'' . esc_url( $src ) . '\');"></span>';
			}
		}

		/**
		 * Widget function.
		 *
		 * @see WP_Widget
		 *
		 * @since 1.0.0
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			if ( $this->get_cached_widget( $args ) ) {
				return;
			}

			ob_start();

			extract( $instance, EXTR_OVERWRITE );

			$this->setup_widget_data( $args, $instance );
			$this->widget_start( $args, $instance );

			if ( array_key_exists( $terms_type, $instance ) ) {

				$taxonomy = $instance[ $terms_type ];

				if ( $taxonomy ) {
					$terms = $this->get_terms( $terms_type, array('include' => $taxonomy, 'hide_empty' => false ) );
				}
			}

			if ( isset( $terms ) && $terms ) {
				$image_size        = apply_filters( 'cosmetro_taxonomy_tiles_widget_size', '_tm-thumb-m', $this->instance );
				$image_mobile_size = apply_filters( 'cosmetro_taxonomy_tiles_widget_size_mobile', '_tm-thumb-s', $this->instance );

				$columns_class = 4 < $columns_number ? 3 : ( int ) ( 12 / $columns_number ) ;
				$inline_style  = '';
				$counter       = 0;

				if ( 'grid' === $layout_type ) {

					$class        = 'col-xs-6 col-sm-6 col-md-4 col-lg-' . $columns_class . ' col-xl-' . $columns_class;
					$inline_style = 'style="margin: 0 0 ' . $items_padding . 'px ' . $items_padding . 'px;"';

				} else {

					$inline_style = 'style="width:calc(100% - ' . $items_padding . 'px); height:calc(100% - ' . $items_padding . 'px); margin: 0 0 ' . $items_padding . 'px ' . $items_padding . 'px;"';
				}

				echo apply_filters( 'cosmetro_taxonomy_tiles_widget_before',
					'<div class="row grid ' . $layout_type . '-columns columns-number-' . $columns_number . '" style="margin: 0 0 0 -' . $items_padding . 'px" >',
					$this->instance
				);

				$view_dir = locate_template( 'inc/widgets/taxonomy-tiles/views/taxonomy-tiles-view.php' );

				if ( $view_dir ) {

					foreach ( $terms as $term_key => $term ) {
						$title       = $this->get_term_title( $term );
						$permalink   = $this->get_term_link( $term );
						$count       = $this->get_term_post_count( $term, $show_post_count['show_post_count_check'] );
						$description = $this->get_term_description( $term, $description_length );

						if ( 'grid' === $layout_type ) {
							$image_type = 'img';
						} else {
							$image_type = 'span';
							$class = $this->tiles_matrix[ $counter ][0] . ' ' . $this->tiles_matrix[ $counter ][1];
						}

						$image = $this->get_term_image( $term, $image_size, $image_mobile_size, $image_type );
						require( $view_dir );

						if ( isset( $this->tiles_matrix[ $counter + 1 ] ) ) {
							$counter++;
						} else {
							$counter = 0;
						}
					}
				}

				echo apply_filters( 'cosmetro_taxonomy_tiles_widget_after', '</div>', $this->instance );
			}

			$this->widget_end( $args );
			$this->reset_widget_data();

			echo $this->cache_widget( $args, ob_get_clean() );
		}

		/**
		 * Trim `hex`-symbol in string.
		 *
		 * @since  1.0.1
		 * @param  string $hex String in hex-format.
		 * @return string
		 */
		function hex_to_string( $hex ) {
			$hex = trim( $hex );

			/** Strip recognized prefixes. */
			if ( 0 === strpos( $hex, '#' ) ) {
				$string = substr( $hex, 1 );
			} elseif ( 0 === strpos( $hex, '%23' ) ) {
				$string = substr( $hex, 3 );
			} else {
				$string = $hex;
			}

			return $string;
		}
	}

	add_action( 'widgets_init', 'cosmetro_register_taxonomy_tiles_widget' );
	function cosmetro_register_taxonomy_tiles_widget() {
		register_widget( 'Cosmetro_Taxonomy_Tiles_Widget' );
	}
}
