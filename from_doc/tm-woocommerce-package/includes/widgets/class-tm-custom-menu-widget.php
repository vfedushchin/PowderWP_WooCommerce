<?php

if ( class_exists( 'WP_Nav_Menu_Widget' ) ) {

	class __TM_Custom_Menu_Widget extends WP_Nav_Menu_Widget {

		/**
		 * Sets up a new Custom Menu widget instance.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function __construct() {

			//Bannres Grid admin
			wp_register_script( 'tm-custom-menu-widget-admin', plugins_url( '/assets/js/tm-custom-menu-widget-admin.js', dirname( dirname( __FILE__ ) ) ), array( 'jquery' ), '1.0', true );

			$widget_ops = array( 'description' => __('Add a custom menu with background.') );
			WP_Widget::__construct( '__tm_custom_menu_widget', __('TM Custom Menu with Background'), $widget_ops );
		}

		/**
		 * Outputs the content for the current TM Custom Menu widget instance.
		 *
		 * @since 1.0
		 * @access public
		 *
		 * @param array $args     Display arguments including 'before_title', 'after_title',
		 *                        'before_widget', and 'after_widget'.
		 * @param array $instance Settings for the current TM Custom Menu widget instance.
		 */
		public function widget( $args, $instance ) {
			wp_enqueue_style( 'tm-custom-menu-widget-styles' );
			$id = ! empty( $instance['id'] ) ? $instance['id'] : '';
			$img = '';
			if ( '' !== $id ) {
				$img = wp_get_attachment_image_src ( $id, 'original' );
			}
		 ?>
			
			<div class="tm_custom_menu_widget"<?php if ( '' !== $id && is_array ( $img ) ) echo ' style="background-image: url(' . $img[0] . ');"'; ?>>

			<?php parent::widget( $args, $instance ); ?>

			</div>

		<?php }

		/**
		 * Outputs the settings form for the Custom Menu widget.
		 *
		 * @since 1.0
		 * @access public
		 *
		 * @param array $instance Current settings.
		 */
		public function form( $instance ) {

			parent::form( $instance );

			$menus = wp_get_nav_menus();

			if ( !empty( $menus ) ) {
				wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css' );
				wp_enqueue_style( 'tm-custom-menu-widget-admin', plugins_url( '/assets/css/tm-custom-menu-widget-admin.css', dirname( dirname( __FILE__ ) ) ) );
				$translation_array = array(
					'media_frame_title' => __( 'Choose background image', 'tm-woocommerce-package' ),
					'add_media_title' => __( 'Add image', 'tm-woocommerce-package' )
				);

				wp_enqueue_script( 'tm-custom-menu-widget-admin' );

				wp_localize_script( 'tm-custom-menu-widget-admin', 'custom_menu_widget_admin', $translation_array );

				$id = ! empty( $instance['id'] ) ? $instance['id'] : '';
				$img = '';
				if ( '' !== $id ) {
					$img = wp_get_attachment_image_src ( $id, 'thumbnail' );
				}
			 ?>
			<div class="tm-custom-menu-widget-form-controls">
				<div class="tm_custom_menu_widget_img"<?php if ( '' === $id ) { ?> style="display: none;"<?php } ?>>
					<div<?php if ( '' !== $id && is_array ( $img ) ) echo ' style="background-image: url(' . $img[0] . ');"'; ?>>
						<span class="fa-stack banner_remove">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-times fa-stack-1x"></i>
						</span>
					</div>
				</div>
				<div class="tm_custom_menu_widget_add_media"<?php if ( '' !== $id ) { ?> style="display: none;"<?php } ?>>
					<span>
						<span><?php _e( 'Choose background image', 'tm-woocommerce-package' ); ?></span>
					</span>
				</div>
				<input class="tm_custom_menu_widget_id" type="hidden" id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo esc_attr( $id ); ?>">
			</div>
		<?php }

		}

		/**
		 * Handles updating settings for the current TM Custom Menu widget instance.
		 *
		 * @since 2.0
		 * @access public
		 *
		 * @param array $new_instance New settings for this instance as input by the user via
		 *                            WP_Widget::form().
		 * @param array $old_instance Old settings for this instance.
		 * @return array Updated settings to save.
		 */
		public function update( $new_instance, $old_instance ) {

			$instance = parent::update( $new_instance, $old_instance );

			if ( ! empty( $new_instance['id'] ) ) {
				$instance['id'] = (int) $new_instance['id'];
			}

			return $instance;
		}

	}

}

?>