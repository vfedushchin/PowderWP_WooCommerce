<?php
$result = array(

    'main' => array(
        'custom' => array(
            'label' => __('Custom Slider', MPSL_TEXTDOMAIN),
            'id' => 'mpsl-custom-slider',
            'slider_type' => 'custom',
			'description' => __('create unlimited slides with images, text, buttons and videos', MPSL_TEXTDOMAIN),
            'selected' => true
        ),
        'post' => array(
            'label' => __('Posts Slider', MPSL_TEXTDOMAIN),
            'id' => 'mpsl-post-slider',
            'slider_type' => 'post',
			'description' => __('create from posts of your website', MPSL_TEXTDOMAIN),
            'selected' => false
        ),
    ),

    'sample' => array(
	    'custom-1' => array(
            'label' => __('Custom Slider #1', MPSL_TEXTDOMAIN),
            'id' => 'custom-1',
            'slider_type' => 'custom',
		    'image_dir' => '',
            'screenshot' => $mpsl_settings['plugin_dir_url'] . 'defaults/slider-presets/screenshots/custom-1.png',
			'description' => '',
            'selected' => false
        ),
	    'post-1' => array(
            'label' => __('Posts Slider #1', MPSL_TEXTDOMAIN),
            'id' => 'post-1',
            'slider_type' => 'post',
            'screenshot' => $mpsl_settings['plugin_dir_url'] . 'defaults/slider-presets/screenshots/post-1.png',
            'selected' => false
        ),
    ),

//	array(
//		'label' 	=> __( 'Sample Slider 1', MSWP_TEXT_DOMAIN ),
//		'id' 		=> 'sample-slider1',
//		'slidertype'=> 'custom',
//		'importdata'=> '===',
//		'image_dir' => '',
//		'selected' 	=> '',
//		'screenshot'=> MSWP_AVERTA_ADMIN_URL . '/assets/images/starters/sample-slider-1.jpg'
//	),

);

if(is_plugin_active('woocommerce/woocommerce.php')) {
    $result['main']['woocommerce'] = array(
        'label' => __('WooCommerce Slider', MPSL_TEXTDOMAIN),
        'id' => 'mpsl-woocommerce-slider',
        'slider_type' => 'woocommerce',
        'selected' => false,
        'description' => __('create from WooCommerce products', MPSL_TEXTDOMAIN),
    );
    $result['sample']['woocommerce-1'] = array(
        'label' => __('WooCommerce Slider #1', MPSL_TEXTDOMAIN),
        'id' => 'woocommerce-1',
        'slider_type' => 'woocommerce',
        'selected' => false,
        'screenshot' => $mpsl_settings['plugin_dir_url'] . 'defaults/slider-presets/screenshots/woocommerce-1.png',
    );
}
return $result;


