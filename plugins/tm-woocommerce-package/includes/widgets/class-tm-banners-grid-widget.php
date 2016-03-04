<?php

if ( class_exists( 'WC_Widget' ) ) {

	class __TM_Banners_Grid_Widget extends WC_Widget {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->widget_cssclass    = 'woocommerce __tm_banners_grid_widget';
			$this->widget_description = __( 'TM widget to create banners grid', 'tm-woocommerce-package' );
			$this->widget_id          = '__tm_banners_grid_widget';
			$this->widget_name        = __( 'TM Banners Grid Widget', 'tm-woocommerce-package' );

			//Bannres Grid admin
			wp_register_script( 'tm-banners-grid-admin', plugins_url( '/assets/js/tm-banners-grid-widget-admin.js', dirname( dirname( __FILE__ ) ) ), array( 'jquery' ), '1.0', true );

			// jQuery Validation
			wp_register_script( 'jquery-validation',  plugins_url( '/assets/js/jquery.validate.min.js', dirname( dirname( __FILE__ ) ) ), array(  ), '1.14.0', true );
			wp_register_script( 'jquery-validation-additional',  plugins_url( '/assets/js/additional-methods.min.js', dirname( dirname( __FILE__ ) ) ), array( 'jquery' ), '1.14.0', true );
			parent::__construct();
		}

		/**
		 * Outputs the settings update form.
		 *
		 * @see   WP_Widget->form
		 * @param array $instance
		 */
		public function form( $instance ) {

			wp_enqueue_script( 'jquery-validation' );
			wp_enqueue_script( 'jquery-validation-additional' );
			wp_enqueue_script( 'tm-banners-grid-admin' );

			wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css' );
			wp_enqueue_style( 'bootstrap-grid', plugins_url( '/assets/css/grid.css', dirname( dirname( __FILE__ ) ) ), array(  ) );
			wp_enqueue_style( 'tm-banners-grid-admin', plugins_url( '/assets/css/tm-banners-grid-widget-admin.css', dirname( dirname( __FILE__ ) ) ), array(  ) );

			$banners_grids = array(
				array(
					array(
						array( 'w' => 12, 'h' => 1 )
					)
				),
				array(
					array(
						array( 'w' => 6, 'h' => 1 ),
						array( 'w' => 6, 'h' => 1 )
					),
					array(
						array( 'w' => 4, 'h' => 1 ),
						array( 'w' => 8, 'h' => 1 )
					),
					array(
						array( 'w' => 8, 'h' => 1 ),
						array( 'w' => 4, 'h' => 1 )
					)
				),
				array(
					array(
						array( 'w' => 4, 'h' => 1 ),
						array( 'w' => 4, 'h' => 1 ),
						array( 'w' => 4, 'h' => 1 )
					),
					array(
						array( 'w' => 6, 'h' => 1 ),
						array( 'w' => 3, 'h' => 1 ),
						array( 'w' => 3, 'h' => 1 )
					),
					array(
						array( 'w' => 8, 'h' => 2 ),
						array(
							'w' => 4,
							'h' => array( 1, 1 )
						)
					)
				),
				array(
					array(
						array( 'w' => 5, 'h' => 2 ),
						array(
							'w' => 7,
							'h' => array(
								1,
								array(
									array( 'w' => 6, 'h' => 1 ),
									array( 'w' => 6, 'h' => 1 )
								)
							)
						)
					),
					array(
						array( 'w' => 4, 'h' => 2 ),
						array(
							'w' => 4,
							'h' => array( 1, 1 )
						),
						array( 'w' => 4, 'h' => 2 )
					)
				),
				array(
					array(
						array(
							'w' => 4,
							'h' => array( 1, 1 )
						),
						array( 'w' => 4, 'h' => 2 ),
						array(
							'w' => 4,
							'h' => array( 1, 1 )
						)
					)
				),
				array(
					array(
						array(
							'w' => 4,
							'h' => array( 1, 1 )
						),
						array(
							'w' => 4,
							'h' => array( 1, 1 )
						),
						array(
							'w' => 4,
							'h' => array( 1, 1 )
						)
					)
				)
			);

			$banners_grids = apply_filters ( 'tm_banners_grid_widget_grids', $banners_grids );

			$translation_array = array(
				'media_frame_title' => __( 'Choose banner image', 'tm-woocommerce-package' ),
				'add_media_title' => sprintf ( __( 'Add banners<br>max: %s', 'tm-woocommerce-package' ), count ( $banners_grids ) ),
				'max_banners' => count ( $banners_grids ),
				'set_link_text' => __( 'Set link', 'tm-woocommerce-package' )
			);

			wp_localize_script( 'tm-banners-grid-admin', 'banners_grid_widget_admin', $translation_array );

			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Banners', 'tm-woocommerce-package' );
			$banners = ! empty( $instance['banners'] ) ? $instance['banners'] : '';
			$banners_links = ! empty( $instance['banners_links'] ) ? $instance['banners_links'] : '';
			$banners_grid_val = ! empty( $instance['banners_grid'] ) ? $instance['banners_grid'] : '';
			if ( '' !== $banners ) {
				$banners_ids = explode( ',', esc_attr( $banners ) );
			}
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<div class="tm_banners_grid_widget_banners_thumbs" id="<?php echo esc_attr( $this->get_field_id( 'banners_thumbs' ) ); ?>">
				<div class="tm_banners_grid_widget_banners_thumbs_inner">
				<?php if ( $banners_ids ) {
					foreach ( $banners_ids as $banner_id ) {
						$banner_src = wp_get_attachment_image_src( $banner_id, 'thumbnail' );
						$html[] = '';
						if ( is_array( $banner_src ) )
						$html[] = '<div class="tm_banners_grid_widget_img_col" data-id="' . $banner_id . '">';
						$html[] = '<div style="background-image: url(' . $banner_src[0] . ');">';
						$html[] = '<span class="fa-stack banner_remove">';
						$html[] = '<i class="fa fa-circle fa-stack-2x"></i>';
						$html[] = '<i class="fa fa-times fa-stack-1x"></i>';
						$html[] = '</span>';
						$html[] = '<span class="fa-stack banner_link" title="' . __( 'Set link', 'tm-woocommerce-package' ) . '">';
						$html[] = '<i class="fa fa-circle fa-stack-2x"></i>';
						$html[] = '<i class="fa fa-link fa-stack-1x"></i>';
						$html[] = '</span>';
						$html[] = '</div>';
						$html[] = '</div>';
					}
					echo implode ( "\n", $html );
				} ?>
				</div>
				<div class="tm_banners_grid_widget_add_media" style="display: none;">
					<span>
						<span><?php printf ( __( 'Add banners<br>max: %s', 'tm-woocommerce-package' ), count ( $banners_grids ) ); ?></span>
					</span>
				</div>
			</div>
			<input type="hidden" autocomplete="off" class="tm_banners_grid_widget_banners" id="<?php echo esc_attr( $this->get_field_id( 'banners' ) ); ?>" name="<?php echo $this->get_field_name( 'banners' ); ?>" value="<?php echo esc_attr( $banners ); ?>">
			<input type="hidden" autocomplete="off" class="tm_banners_grid_widget_banners_links" id="<?php echo esc_attr( $this->get_field_id( 'banners_links' ) ); ?>" name="<?php echo $this->get_field_name( 'banners_links' ); ?>" value="<?php echo esc_attr( $banners_links ); ?>">
			<div class="banner_link_wrapper hide" id="<?php echo esc_attr( $this->get_field_id( 'banner_link_wrapper' ) ); ?>">
				<div class="inline-elem">
					<div><input type="url" autocomplete="off" class="widefat tm_banners_grid_widget_banner_link" id="<?php echo esc_attr( $this->get_field_id( 'banner_link' ) ); ?>" name="<?php echo $this->get_field_name( 'banner_link' ); ?>"></div>
					<div class="btns">
						<button type="button" class="button button-primary button-submit"><?php _e( 'Ok', 'tm-woocommerce-package' ) ?></button>
						<button type="button" class="button button-primary button-cancel"><?php _e( 'Cancel', 'tm-woocommerce-package' ) ?></button>
					</div>
				</div>
			</div>
			<div class="tm_banners_grid_widget_banners_grids" id="<?php echo esc_attr( $this->get_field_id( 'banners_grids' ) ); ?>">
			<?php
				foreach ( $banners_grids as $key => $banners_grid ) { ?>
				<div class="tm_banners_grid_widget_banners_grid tm_banners_grid_widget_banners_grid_<?php echo $key; ?>">
					<?php foreach ( $banners_grid as $k => $banner ) { ?>
					<input type="radio" autocomplete="off" name="<?php echo esc_attr( $this->get_field_name( 'banners_grid' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'banners_grid_' . $key . '_' . $k ) ); ?>" value='<?php echo json_encode( $banner ); ?>' <?php if( json_encode( $banner ) == $banners_grid_val ) echo 'checked'; ?>>
					<label for="<?php echo esc_attr( $this->get_field_id( 'banners_grid_' . $key . '_' . $k ) ); ?>">
						<?php echo $this->build_row($banner); ?>
					</label>
					<?php } ?>
				</div>
				<?php }
			?>
			</div>
			<p></p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {

			$instance = $new_instance;

			$this->flush_widget_cache();

			return $instance;
		}

		protected function build_banner($height, $banners = false, $links = false, &$i = 0) {
			$banner[] = '<div class="tm_banners_grid_widget_banner_height_' . $height . '">';
			if ( !$banners ) {
				$banner[] = '<span>'. ( $i + 1 ) .'</span>' . __( 'Banner', 'tm-woocommerce-package' );
			} else {
				if ( !$links || !isset ( $links[$banners[$i]] ) || $links[$banners[$i]] == '' ) {
					$banner[] = wp_get_attachment_image ( $banners[$i], 'original' );
				} else {
					$banner[] = '<a target="_blank" href="' . base64_decode ( $links[$banners[$i]] ) . '">';
					$banner[] = wp_get_attachment_image ( $banners[$i], 'original' );
					$banner[] = '</a>';
				}
			}
			$banner[] = '</div>';
			$i++;
			return implode ( "\n", $banner );
		}

		protected function build_row($arr, $banners = false, $links = false, &$i = 0) {
			$block[] = '<div class="row">';
			foreach ( $arr as $col ) {
				$block[] = '<div class="col-sm-' . $col['w'] . '">';
				if( is_array ( $col['h'] ) ) {
					foreach ( $col['h'] as $row ) {
						if( is_array ( $row ) ) {
							$block[] = $this->build_row ($row, $banners, $links, $i);
						} else {
							$block[] = $this->build_banner ($row, $banners, $links, $i);
						}
					}
				} else {
					$block[] = $this->build_banner ($col['h'], $banners, $links, $i);
				}
				$block[] = '</div>';
			}
			$block[] = '</div>';
			return implode ( "\n", $block );
		}

		public function widget( $args, $instance ) {
			$banners = ! empty( $instance['banners'] ) ? explode( ',', $instance['banners'] ) : false;
			$banners_grid = ! empty( $instance['banners_grid'] ) ? json_decode( $instance['banners_grid'], true ) : '';
			$links = ! empty( $instance['banners_links'] ) ? json_decode ( $instance['banners_links'], true ) : false;
			if ( is_array( $banners ) ) {
			 ?>
			<div class="tm_banners_grid_widget_banners_grid tm_banners_grid_widget_banners_grid_">
				<?php echo $this->build_row($banners_grid, $banners, $links); ?>
			</div><?php
			}
		}

	}

}

?>