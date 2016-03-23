<?php
/**
 * Layout configuration.
 *
 * @package __Tm
 */

add_action( 'after_setup_theme', 'cosmetro_set_layout', 5 );
function cosmetro_set_layout() {

	cosmetro_theme()->layout = array(
		'one-right-sidebar' => array(
			'1/3' => array(
				'content' => array( 'col-xs-12', 'col-md-8' ),
				'sidebar' => array( 'col-xs-12', 'col-md-4' ),
			),
			'1/4' => array(
				'content' => array( 'col-xs-12', 'col-md-8', 'col-xl-9' ),
				'sidebar' => array( 'col-xs-12', 'col-md-4', 'col-xl-3' ),
			),
			'0' => array(
				'content' => array( 'col-xs-12', 'col-md-12' )
			),
		),
		'one-left-sidebar' => array(
			'1/3' => array(
				'content' => array( 'col-xs-12', 'col-md-8', 'col-md-push-4' ),
				'sidebar' => array( 'col-xs-12', 'col-md-4', 'col-md-pull-8' ),
			),
			'1/4' => array(
				'content' => array( 'col-xs-12', 'col-md-8', 'col-xl-9', 'col-md-push-4', 'col-xl-push-3' ),
				'sidebar' => array( 'col-xs-12', 'col-md-4', 'col-xl-3', 'col-md-pull-8', 'col-xl-pull-9' ),
			),
			'0' => array(
				'content' => array( 'col-xs-12', 'col-md-12' )
			),
		),
		'fullwidth' => array(
			array(
				'content' => array( 'col-xs-12', 'col-md-12' ),
			),
		),
	);
}
