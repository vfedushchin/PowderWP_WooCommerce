<?php
/*
	Plugin Name: TM Woocommerce Package
	Version: 1.0
	Author: TemplateMonster
	Author URI: http://www.templatemonster.com/
*/

/*  This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class TM_Woocommerce {

	/**
	 * The single instance of the class.
	 *
	 * @var TM_Woocommerce
	 * @since 2.1
	 */
	protected static $_instance = null;

	/**
	 * Trigger checks is woocoomerce active or not
	 *
	 * @since 1.0.0
	 * @var   bool
	 */
	public $has_woocommerce = null;

	/**
	 * Holder for plugin folder path
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	public $plugin_dir = null;

	/**
	 * Main TM_Woocommerce Instance.
	 *
	 * Ensures only one instance of TM_Woocommerce is loaded or can be loaded.
	 *
	 * @since 2.1
	 * @static
	 * @see tm_wc()
	 * @return TM_Woocommerce - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Sets up needed actions/filters for the theme to initialize.
	 *
	 * @since 1.0.0
	*/
	public function __construct() {

		if ( ! $this->has_woocommerce() ) {
			return false;
		}

		// Load public assets.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 9 );

		include_once( 'includes/tm-woocommerce-functions.php' );
		include_once( 'includes/tm-woocommerce-hooks.php' );

		add_action( 'widgets_init', array ( $this, '__tm_woocommerce_register_widgets' ) );

		add_filter( 'cherry_breadcrumbs_custom_trail', array( $this, 'get_woo_breadcrumbs' ), 10, 2 );

	}



	public function __tm_woocommerce_register_widgets() {

		include_once( 'includes/widgets/class-tm-products-carousel-widget.php' );
		include_once( 'includes/widgets/class-tm-products-smart-box-widget.php' );
		include_once( 'includes/widgets/class-tm-banners-grid-widget.php' );
		include_once( 'includes/widgets/class-tm-custom-menu-widget.php' );
		include_once( 'includes/widgets/class-tm-product-categories-widget.php' );
		include_once( 'includes/widgets/class-tm-about-store-widget.php' );

		register_widget( '__TM_Products_Carousel_Widget' );
		register_widget( '__TM_Products_Smart_Box_Widget' );
		register_widget( '__TM_Banners_Grid_Widget' );
		register_widget( '__TM_Custom_Menu_Widget' );
		register_widget( '__TM_Product_Categories_Widget' );
		register_widget( '__TM_About_Store_Widget' );
	}

	/**
	 * Get custom WooCommerce breadcrumbs trail
	 *
	 * @since  4.0.0
	 * @param  bool  $is_custom_breadcrumbs  default custom breadcrums trigger
	 */
	public function get_woo_breadcrumbs( $is_custom_breadcrumbs, $args ) {

		if ( ! $this->is_woo_page() ) {
			return $is_custom_breadcrumbs;
		}

		if ( ! class_exists( 'Cherry_Woo_Breadcrumbs' ) ) {
			require_once( 'includes/class-cherry-woo-breadcrumbs.php' );
		}

		$core = apply_filters( '__tm_get_theme_core', false );

		if ( ! $core ) {
			return $is_custom_breadcrumbs;
		}

		$woo_breadcrums = new Cherry_Woo_Breadcrumbs( $core, $args );
		return array( 'items' => $woo_breadcrums->items, 'page_title' => $woo_breadcrums->page_title );
	}

	/**
	 * Check if we viewing Woo-related page
	 *
	 * @since  4.0.0
	 */
	public function is_woo_page() {

		if ( ! $this->has_woocommerce() ) {
			return false;
		}

		if ( ! function_exists( 'is_woocommerce' ) ) {
			return false;
		}

		return is_woocommerce();
	}

	/**
	 * Check if WooCommerce is active
	 *
	 * @since  1.0.0
	 * @return bool
	 */
	public function has_woocommerce() {

		if ( null == $this->has_woocommerce ) {
			$this->has_woocommerce = in_array(
				'woocommerce/woocommerce.php',
				apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
			);
		}

		return $this->has_woocommerce;

	}

	/**
	 * Enqueue assets.
	 *
	 * @since 1.0.0
	 * @return void
	*/
	public function register_assets() {

		// Swiper assets register
		wp_register_script( 'jquery-swiper', plugins_url( '/assets/js/swiper.jquery.min.js', __FILE__ ), array( 'jquery' ), '3.3.0', true );
		wp_register_style( 'jquery-swiper', plugins_url( '/assets/css/swiper.min.css', __FILE__ ), array(), '3.3.0', 'all' );

		// Material Tabs assets register
		wp_register_script( 'jquery-rd-material-tabs', plugins_url( '/assets/js/jquery.rd-material-tabs.min.js', __FILE__ ), array( 'jquery' ), '1.0.2', true );
		wp_register_style( 'jquery-rd-material-tabs', plugins_url( '/assets/css/rd-material-tabs.css', __FILE__ ), array(), '1.0.0', 'all' );

		// jQuery Countdown
		wp_register_script( 'jquery-countdown',  plugins_url( '/assets/js/jquery.countdown.min.js', __FILE__ ), array( 'jquery' ), '2.1.0', true );

		// TM Products Carousel Widget
		wp_register_style( 'tm-products-carousel-widget-styles', plugins_url( '/assets/css/tm-products-carousel-widget.css', __FILE__ ), array( 'jquery-swiper' ), '1.0', 'all' );
		wp_register_script( 'tm-products-carousel-widget-init', plugins_url( '/assets/js/tm-products-carousel-widget.js', __FILE__ ), array( 'jquery-swiper' ), '1.0', true );

		// TM Categories Carousel Widget
		wp_register_script( 'tm-categories-carousel-widget-init', plugins_url( '/assets/js/tm-categories-carousel-widget.js', __FILE__ ), array( 'jquery-swiper' ), '1.0', true );

		// TM Custom Menu Widget
		wp_register_style( 'tm-custom-menu-widget-styles', plugins_url( '/assets/css/tm-custom-menu-widget.css', __FILE__ ), array(), '1.0', 'all' );

	}

	/**
	 * Get product terms.
	 *
	 * @var string $terms type of product terms
	 * @since 1.0.0
	 * @return array product terms
	*/
	public function tm_get_products_terms( $terms = 'product_cat' ) {

		include_once( plugin_dir_path( dirname( __FILE__ ) ) . 'woocommerce/includes/class-wc-post-types.php' );

		WC_Post_types::register_taxonomies();

		$product_terms = get_terms( $terms );

		$tm_filter_by_term = array();

		foreach ($product_terms as $term) {
			$tm_filter_by_term[$term->term_taxonomy_id] = $term->name;
		}

		return $tm_filter_by_term;

	}

	/**
	 * Get product categories.
	 *
	 * @since 1.0.0
	 * @return array product categories
	*/
	public function tm_get_products_cats() {

		$product_cats = self::tm_get_products_terms();

		$tm_filter_by_category_options['all-categories'] = __( 'All categories', 'tm-woocommerce-package' );

		$tm_filter_by_category_options += $product_cats;

		return $tm_filter_by_category_options;
	}

	/**
	 * Get product tags.
	 *
	 * @since 1.0.0
	 * @return array product tags
	*/
	public function tm_get_products_tags() {

		$product_tags = self::tm_get_products_terms( 'product_tag' );

		$tm_filter_by_tag_options['all-tags'] = __( 'All tags', 'tm-woocommerce-package' );

		$tm_filter_by_tag_options += $product_tags;

		return $tm_filter_by_tag_options;
	}

	public function tm_widgets_form_multiselect( $instance, $widget ) {

		if ( empty( $widget->settings ) ) {
			return;
		}

		foreach ( $widget->settings as $key => $setting ) {

			$class = isset( $setting['class'] ) ? $setting['class'] : '';
			$value = isset( $instance[ $key ] ) ? $instance[ $key ] : $setting['std'];

			switch ( $setting['type'] ) {

				case 'multiselect' :
					?>
					<p>
						<label for="<?php echo $widget->get_field_id( $key ); ?>"><?php echo $setting['label']; ?></label>
						<select multiple="multiple" class="widefat <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $widget->get_field_id( $key ) ); ?>" name="<?php echo $widget->get_field_name( $key ); ?>[]">
							<?php foreach ( $setting['options'] as $option_key => $option_value ) :
							if( is_array ( $value ) ) {
								$selected = in_array( $option_key, $value ) ? 'selected' : '';
							} else {
								$selected = selected( $option_key, $value );
							}
							 ?>
								<option value="<?php echo esc_attr( $option_key ); ?>" <?php echo $selected; ?>><?php echo esc_html( $option_value ); ?></option>
							<?php endforeach; ?>
						</select>
					</p>
					<?php
				break;
			}
		}

	}

	public function tm_widgets_form_button( $instance, $widget ) {

		if ( empty( $widget->settings ) ) {
			return;
		}

		foreach ( $widget->settings as $key => $setting ) {

			$class = isset( $setting['class'] ) ? $setting['class'] : '';
			$value = isset( $instance[ $key ] ) ? $instance[ $key ] : $setting['std'];

			switch ( $setting['type'] ) {

				case 'button' :
					?>
					<p>
						<label for="<?php echo $widget->get_field_id( $key ); ?>"><?php echo $setting['label']; ?></label>
						<select multiple="multiple" class="widefat <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $widget->get_field_id( $key ) ); ?>" name="<?php echo $widget->get_field_name( $key ); ?>[]">
							<?php foreach ( $setting['options'] as $option_key => $option_value ) :
							if( is_array ( $value ) ) {
								$selected = in_array( $option_key, $value ) ? 'selected' : '';
							} else {
								$selected = selected( $option_key, $value );
							}
							 ?>
								<option value="<?php echo esc_attr( $option_key ); ?>" <?php echo $selected; ?>><?php echo esc_html( $option_value ); ?></option>
							<?php endforeach; ?>
						</select>
					</p>
					<?php
				break;
			}
		}

	}

	public function plugin_dir( $path = null ) {

		if ( ! $this->plugin_dir ) {
			$this->plugin_dir = trailingslashit( plugin_dir_path( __FILE__ ) );
		}

		if ( null != $path ) {
			return $this->plugin_dir . $path;
		}

		return $this->plugin_dir;

	}

	/**
	 * Print compare button in products loop
	 *
	 * @since 1.0.0
	 * @return void|bool false
	 */
	public function add_loop_compare() {

		if ( 'yes' !== $this->compare['loop'] ) {
			return false;
		}

		$this->custom_compare_link();

	}
}

function tm_wc() {
	return TM_Woocommerce::instance();
}

tm_wc();

?>