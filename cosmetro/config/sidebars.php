<?php
/**
 * Sidebars configuration.
 *
 * @package __Tm
 */

add_action( 'after_setup_theme', 'cosmetro_register_sidebars', 5 );
function cosmetro_register_sidebars() {

	$widget_class = '12';

	$widgets = wp_get_sidebars_widgets();

	$widgets_count = count( $widgets[ 'after-content-area' ] );
	if ( $widgets_count > 0 ) {
		$widget_class = '' . ceil( 12 / count( $widgets[ 'after-content-area' ] ) );
		if ( $widgets_count > 3 ) {
			if( 0 === $widgets_count % 3 ) {
				$widget_class = '4';
			} else if ( 0 === $widgets_count % 2 ) {
				$widget_class = '6';
			} else {
				$widget_class = '4';
			}

		}
	}

	cosmetro_widget_area()->widgets_settings = apply_filters( 'tm_widget_area_default_settings', array(
		'sidebar-primary' => array(
			'name'           => esc_html__( 'Sidebar Blog', 'cosmetro' ),
			'description'    => '',
			'before_widget'  => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'   => '</aside>',
			'before_title'   => '<h4 class="widget-title">',
			'after_title'    => '</h4>',
			'before_wrapper' => '<div id="%1$s" %2$s role="complementary">',
			'after_wrapper'  => '</div>',
			'is_global'      => true,
		),
		'sidebar-secondary' => array(
			'name'           => esc_html__( 'Sidebar Shop', 'cosmetro' ),
			'description'    => '',
			'before_widget'  => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'   => '</aside>',
			'before_title'   => '<h4 class="widget-title">',
			'after_title'    => '</h4>',
			'before_wrapper' => '<div id="%1$s" %2$s role="complementary">',
			'after_wrapper'  => '</div>',
			'is_global'      => true,
		),
		'full-width-header-area' => array(
			'name'           => esc_html__( 'Full width header area', 'cosmetro' ),
			'description'    => '',
			'before_widget'  => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'   => '</aside>',
			'before_title'   => '<h4 class="widget-title">',
			'after_title'    => '</h4>',
			'before_wrapper' => '<div id="%1$s" %2$s>',
			'after_wrapper'  => '</div>',
			'is_global'      => false,
			'conditional'    => array( 'is_home', 'is_front_page' ),
		),
		'before-content-area' => array(
			'name'           => esc_html__( 'Before content widget area', 'cosmetro' ),
			'description'    => '',
			'before_widget'  => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'   => '</aside>',
			'before_title'   => '<h4 class="widget-title">',
			'after_title'    => '</h4>',
			'before_wrapper' => '<div id="%1$s" %2$s>',
			'after_wrapper'  => '</div>',
			'is_global'      => false,
			'conditional'    => array( 'is_home', 'is_front_page' ),
		),
		'before-loop-area' => array(
			'name'           => esc_html__( 'Before loop widget area', 'cosmetro' ),
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
			'name'           => esc_html__( 'After loop widget area', 'cosmetro' ),
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
			'name'           => esc_html__( 'After content widget area', 'cosmetro' ),
			'description'    => '',
			'before_widget'  => '<aside id="%1$s" class="widget %2$s col-xs-12 col-md-4">',
			'after_widget'   => '</aside>',
			'before_widget'  => '<div class="col-xs-12 col-sm-12 col-md-' . $widget_class . ' col-lg-' . $widget_class . ' col-xl-' . $widget_class . '"><aside id="%1$s" class="widget %2$s">',
			'after_widget'   => '</aside></div>',
			'before_title'   => '<h4 class="widget-title">',
			'after_title'    => '</h4>',
			'before_wrapper' => '<div id="%1$s" %2$s>',
			'after_wrapper'  => '</div>',
			'is_global'      => false,
			'conditional'    => array( 'is_home', 'is_front_page' ),
		),
		'after-content-full-width-area' => array(
			'name'           => esc_html__( 'After content full width widget area', 'cosmetro' ),
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
			'name'           => esc_html__( 'Footer widget area', 'cosmetro' ),
			'description'    => '',
			'before_widget'  => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'   => '</aside>',
			'before_title'   => '<h4 class="widget-title">',
			'after_title'    => '</h4>',
			'before_wrapper' => '<section id="%1$s" %2$s>',
			'after_wrapper'  => '</section>',
			'is_global'      => true,
		),
	) );
}
