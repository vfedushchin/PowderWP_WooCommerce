<?php
/**
 * Widget API: WP_Widget_Text class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */

/**
 * Core class used to implement a Text widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
if ( class_exists( 'WP_Widget_Text' ) ) {
	class __TM_About_Store_Widget extends WP_Widget_Text {

		/**
		 * Sets up a new TM About Store widget instance.
		 *
		 * @since 2.8.0
		 * @access public
		 */
		public function __construct() {

			//Bannres Grid admin
			wp_register_script( 'tm-custom-menu-widget-admin', plugins_url( '/assets/js/tm-custom-menu-widget-admin.js', dirname( dirname( __FILE__ ) ) ), array( 'jquery' ), '1.0', true );

			$widget_ops = array('classname' => 'tm_about_store_widget', 'description' => __('Add Store descriprion'));
			$control_ops = array('width' => 400, 'height' => 350);
			WP_Widget::__construct('tm_about_store_widget', __('TM About Store'), $widget_ops, $control_ops);
		}

		/**
		 * Outputs the content for the current TM About Store widget instance.
		 *
		 * @since 2.8.0
		 * @access public
		 *
		 * @param array $args     Display arguments including 'before_title', 'after_title',
		 *                        'before_widget', and 'after_widget'.
		 * @param array $instance Settings for the current TM About Store widget instance.
		 */
		public function widget( $args, $instance ) {
			$enable_button = isset( $instance['enable_button'] ) ? $instance['enable_button'] : 0;
			$button_url = isset( $instance['button_url'] ) ? sanitize_text_field( $instance['button_url'] ) : '';
			$button_text = isset( $instance['button_text'] ) ? apply_filters('wpml_translate_single_string', sanitize_text_field( $instance['button_text']), 'Widgets', 'TM About Store - button text' ) : '';
			$id = ! empty( $instance['id'] ) ? $instance['id'] : '';
			$img = '';
			if ( '' !== $id ) {
				$img = wp_get_attachment_image_src ( $id, 'original' );
			}
			if ( is_array ( $img ) ) {
				$args['before_widget'] .= '<div class="tm_about_store_widget_bg" style="background-image: url(' . $img[0] . ');"><div class="tm_about_store_widget_bg_inner">';
			}
			$after_widget = array();
			if ( $enable_button && '' !== $button_url && '' !== $button_text ) {
				$after_widget[] = '<a href="' . $button_url . '" class="btn">' . $button_text . '</a>';
			}
			if ( is_array ( $img ) ) {
				$after_widget[] = '</div></div>';
			}
			$after_widget[] = $args['after_widget'];
			$args['after_widget'] = implode( "\n", $after_widget );
			parent::widget( $args, $instance );
		}

		/**
		 * Handles updating settings for the current TM About Store widget instance.
		 *
		 * @since 2.8.0
		 * @access public
		 *
		 * @param array $new_instance New settings for this instance as input by the user via
		 *                            WP_Widget::form().
		 * @param array $old_instance Old settings for this instance.
		 * @return array Settings to save or bool false to cancel saving.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = parent::update( $new_instance, $old_instance );
			$instance['enable_button'] = ! empty( $new_instance['enable_button'] );
			$instance['button_url'] = sanitize_text_field( $new_instance['button_url'] );
			$instance['button_text'] = sanitize_text_field( $new_instance['button_text'] );
			$instance['id'] = ! empty( $new_instance['id'] ) ? (int) $new_instance['id'] : 0;

			//WMPL
			/**
			 * register strings for translation
			 */
			do_action( 'wpml_register_single_string', 'Widgets', 'TM About Store - button text', $instance['button_text'] );
			//WMPL

			return $instance;
		}

		/**
		 * Outputs the TM About Store widget settings form.
		 *
		 * @since 2.8.0
		 * @access public
		 *
		 * @param array $instance Current settings.
		 */
		public function form( $instance ) {
			parent::form( $instance );
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
			$enable_button = isset( $instance['button_url'] ) ? $instance['enable_button'] : 0;
			$button_url = isset( $instance['enable_button'] ) ? sanitize_text_field( $instance['button_url'] ) : '';
			$button_text = isset( $instance['button_text'] ) ? apply_filters('wpml_translate_single_string', sanitize_text_field( $instance['button_text']), 'Widgets', 'TM About Store - button text' ) : '';
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
			<p>
				<input id="<?php echo $this->get_field_id( 'enable_button' ); ?>" name="<?php echo $this->get_field_name( 'enable_button' ); ?>" type="checkbox"<?php checked( $enable_button ); ?> />&nbsp;<label for="<?php echo $this->get_field_id( 'enable_button' ); ?>"><?php _e( 'Enable Button', 'tm-woocommercr-package' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('button_url'); ?>"><?php _e( 'Button Url:', 'tm-woocommercr-package' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'button_url' ); ?>" name="<?php echo $this->get_field_name( 'button_url' ); ?>" type="url" value="<?php echo esc_attr( $button_url ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('button_text'); ?>"><?php _e( 'Button Text:', 'tm-woocommercr-package' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="url" value="<?php echo esc_attr( $button_text ); ?>">
			</p>
			<?php
		}
	}
}