<?php
/**
 *
 * @package    _Tm
 * @subpackage Class
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( ! class_exists( 'powder_Widget_Area' ) ) {
	class powder_Widget_Area {
		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;
		/**
		 * Settings.
		 *
		 * @since 1.0.0
		 * @var   array
		 */
		public $widgets_settings = array();
		/**
		 * Public holder thats saves widgets state during page loading
		 *
		 * @var array
		 */
		public $active_sidebars = array();
		/**
		* Constructor.
		*
		* @since 1.0.0
		*/
		function __construct( $widgets_settings = array() ) {
			$widgets_default_settings = apply_filters( 'tm_widget_area_default_settings', array(
				'sidebar-primary' => array(
					'name'           => esc_html__( 'Sidebar Primary', 'powder' ),
					'description'    => '',
					'before_widget'  => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'   => '</aside>',
					'before_title'   => '<h4 class="widget-title">',
					'after_title'    => '</h4>',
					'before_wrapper' => '<aside id="%1$s" %2$s role="complementary">',
					'after_wrapper'  => '</aside>',
					'is_global'      => true,
					'conditional'    => array(),
				),
				'sidebar-secondary' => array(
					'name'           => esc_html__( 'Sidebar Secondary', 'powder' ),
					'description'    => '',
					'before_widget'  => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'   => '</aside>',
					'before_title'   => '<h4 class="widget-title">',
					'after_title'    => '</h4>',
					'before_wrapper' => '<aside id="%1$s" %2$s role="complementary">',
					'after_wrapper'  => '</aside>',
					'is_global'      => true,
					'conditional'    => array(),
				),
				'full-width-header-area' => array(
					'name'           => esc_html__( 'Full width header area', 'powder' ),
					'description'    => '',
					'before_widget'  => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'   => '</aside>',
					'before_title'   => '<h4 class="widget-title">',
					'after_title'    => '</h4>',
					'before_wrapper' => '<section id="%1$s" %2$s>',
					'after_wrapper'  => '</section>',
					'is_global'      => false,
					'conditional'    => array( 'is_front_page' ),
				),
				'before-content-area' => array(
					'name'           => esc_html__( 'Before content widget area', 'powder' ),
					'description'    => '',
					'before_widget'  => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'   => '</aside>',
					'before_title'   => '<h4 class="widget-title">',
					'after_title'    => '</h4>',
					'before_wrapper' => '<section id="%1$s" %2$s>',
					'after_wrapper'  => '</section>',
					'is_global'      => false,
					'conditional'    => array( 'is_front_page' ),
				),
				'before-loop-area' => array(
					'name'           => esc_html__( 'Before loop widget area', 'powder' ),
					'description'    => '',
					'before_widget'  => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'   => '</aside>',
					'before_title'   => '<h4 class="widget-title">',
					'after_title'    => '</h4>',
					'before_wrapper' => '<section id="%1$s" %2$s>',
					'after_wrapper'  => '</section>',
					'is_global'      => false,
					'conditional'    => array( 'is_home', 'is_front_page' ),
				),
				'after-loop-area' => array(
					'name'           => esc_html__( 'After loop widget area', 'powder' ),
					'description'    => '',
					'before_widget'  => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'   => '</aside>',
					'before_title'   => '<h4 class="widget-title">',
					'after_title'    => '</h4>',
					'before_wrapper' => '<section id="%1$s" %2$s>',
					'after_wrapper'  => '</section>',
					'is_global'      => false,
					'conditional'    => array( 'is_home', 'is_front_page' ),
				),
				'after-content-area' => array(
					'name'           => esc_html__( 'After content widget area', 'powder' ),
					'description'    => '',
					'before_widget'  => '<aside id="%1$s" class="widget %2$s col-xs-12 col-md-4">',
					'after_widget'   => '</aside>',
					'before_title'   => '<h4 class="widget-title">',
					'after_title'    => '</h4>',
					'before_wrapper' => '<section id="%1$s" %2$s>',
					'after_wrapper'  => '</section>',
					'is_global'      => false,
					'conditional'    => array( 'is_front_page' ),
				),
				'after-content-full-width-area' => array(
					'name'           => esc_html__( 'After content full width widget area', 'powder' ),
					'description'    => '',
					'before_widget'  => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'   => '</aside>',
					'before_title'   => '<h4 class="widget-title">',
					'after_title'    => '</h4>',
					'before_wrapper' => '<section id="%1$s" %2$s>',
					'after_wrapper'  => '</section>',
					'is_global'      => false,
					'conditional'    => array( 'is_home', 'is_front_page' ),
				),
				'footer-area' => array(
					'name'           => esc_html__( 'Footer widget area', 'powder' ),
					'description'    => '',
					'before_widget'  => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'   => '</aside>',
					'before_title'   => '<h4 class="widget-title">',
					'after_title'    => '</h4>',
					'before_wrapper' => '<section id="%1$s" %2$s>',
					'after_wrapper'  => '</section>',
					'is_global'      => true,
					'conditional'    => array(),
				),
			) );
			$this->widgets_settings = wp_parse_args( $widgets_settings, $widgets_default_settings );
			// Register widget areas.
			add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
			add_action( 'powder_render_widget_area', array( $this, 'render_widget_area' ) );
		}
		/**
		 * Register sidebars.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function register_sidebars() {
			global $wp_registered_sidebars;
			foreach ( $this->widgets_settings as $widget => $widget_settings ) {
				register_sidebar( array(
					'name'          => $widget_settings['name'],
					'id'            => $widget,
					'description'   => $widget_settings['description'],
					'before_widget' => $widget_settings['before_widget'],
					'after_widget'  => $widget_settings['after_widget'],
					'before_title'  => $widget_settings['before_title'],
					'after_title'   => $widget_settings['after_title'],
				) );
				if ( isset( $widget_settings['is_global'] ) ) {
					$wp_registered_sidebars[ $widget ]['is_global'] = $widget_settings['is_global'];
				}
			}
		}
		/**
		 * Widget area render function.
		 *
		 * @since  1.0.0
		 * @param  string $area_id Widget area id.
		 * @return void
		 */
		public function render_widget_area( $area_id ) {
			if ( ! is_active_sidebar( $area_id ) ) {
				$this->active_sidebars[ $area_id ] = false;
				return;
			}
			$this->active_sidebars[ $area_id ] = true;
			// Conditional page tags checking
			if ( isset( $this->widgets_settings[ $area_id ]['conditional'] ) && ! empty( $this->widgets_settings[ $area_id ]['conditional'] ) ) {
				$visibility = false;
				foreach ( $this->widgets_settings[ $area_id ]['conditional'] as $conditional ) {
					if ( call_user_func( $conditional ) ) {
						$visibility = true;
					}
				}
				if ( false === $visibility ) {
					return;
				}
			}
			$area_id        = apply_filters( 'powder_rendering_current_widget_area', $area_id );
			$before_wrapper = isset( $this->widgets_settings[ $area_id ]['before_wrapper'] ) ? $this->widgets_settings[ $area_id ]['before_wrapper'] : '<div id="%1$s" %2$s>';
			$after_wrapper  = isset( $this->widgets_settings[ $area_id ]['after_wrapper'] ) ? $this->widgets_settings[ $area_id ]['after_wrapper'] : '</div>';
			$classes = array( $area_id, 'widget-area' );
			$classes = apply_filters( 'powder_widget_area_classes', $classes, $area_id );
			if ( is_array( $classes ) ) {
				$classes = 'class="' . join( ' ', $classes ) . '"';
			}
			printf( $before_wrapper, $area_id, $classes );
				dynamic_sidebar( $area_id );
			printf( $after_wrapper );
		}
		/**
		 * Check if passed sidebar was already rendered and it's active
		 * @param  string  $index Sidebar ID.
		 * @return boolean|null
		 */
		public function is_active_sidebar( $index ) {
			if ( isset( $this->active_sidebars[ $index ] ) ) {
				return $this->active_sidebars[ $index ];
			}
			return null;
		}
		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
	}
	function powder_widget_area() {
		return powder_Widget_Area::get_instance();
	}
	powder_widget_area();
}