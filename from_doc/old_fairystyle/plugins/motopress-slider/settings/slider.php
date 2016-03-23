<?php

/** @var MPSLSliderOptions $this */
/** @var array $options */

$isAjax = defined('DOING_AJAX') && DOING_AJAX; // Checks `is it action ?`
//$isAction = isset($_POST['action']);
$isCreatePage = !(isset($_GET['id']) && $_GET['id']);
$optionsExists = isset($options) && is_array($options);

$categoriesArr = array();
$tagsArr = array();
$postTypesArr = array();
//$allPostTypesArr = array();
$postFormatsDependency = array();
$tagsDependency = array();
$catDependency = array();
$defaultPostType = $this->sliderType === 'post' ? 'post' : 'product';

// tmp
$_categories = array();
$_tags = array();
$_format = array();

if (($isCreatePage || $optionsExists) && !$isAjax && is_admin()) {

	if (in_array($this->sliderType, array('post', 'woocommerce'))) {

		if ($this->sliderType === 'post') {
			if ($optionsExists && isset($options['post_type']) && $options['post_type']) {
				$selectedPostType = $options['post_type'];
			} else {
				$selectedPostType = 'post';
			}
		} else {
			$selectedPostType = 'product';
		}

		if ($this->sliderType === 'post') {
			$postTypes = get_post_types(array(), 'objects');
			if (isset($postTypes['attachment'])) unset($postTypes['attachment']);
			if (isset($postTypes['revision'])) unset($postTypes['revision']);
			if (isset($postTypes['nav_menu_item'])) unset($postTypes['nav_menu_item']);

			// Reset default post_type
			if (count($postTypes) && !isset($postTypes['post'])) {
				$defaultPostType = reset(array_keys($postTypes));
			}

		} else {
			$postTypes = array('product' => get_post_type_object('product'));
		}

		if (count($postTypes)) {
			$categories = $tags = array();

			foreach ($postTypes as $postTypeName => $postType) {
				if (is_null($postType)) continue;

				$postTypeHierarchicalTaxs = $this->getTaxonomyName($postTypeName);
				$categories = $this->getTaxTerms($postTypeHierarchicalTaxs, $postTypeName, 'categories');
				$tags = $this->getTaxTerms($postTypeHierarchicalTaxs, $postTypeName, 'tags');
				// Get post-formats only once (because they are shared
				if (!count($_format)) $postFormats = $this->getTaxTerms($postTypeHierarchicalTaxs, $postTypeName, 'format');

				if (post_type_supports($postTypeName, 'post-formats')) {
					$postFormatsDependency[] = $postTypeName;
				}
				if (count(array_intersect(array('post_tag', 'product_tag'), array_keys($postTypeHierarchicalTaxs))) > 0) {
					$tagsDependency[] = $postTypeName;
				}
				if (count(array_intersect(array('category', 'product_cat'), array_keys($postTypeHierarchicalTaxs))) > 0) {
					$catDependency[] = $postTypeName;
				}

				if (count($categories) || count($tags)) {
					$postTypesArr[$postTypeName] = array(
						'label' => $postType->labels->singular_name,
						'attrs' => array(
							'data-categories' => $categories,
							'data-tags' => $tags,
//							'data-formats' => $postFormats
						)
					);
				} else {
					$postTypesArr[$postTypeName] = array(
						'label' => $postType->labels->singular_name,
						'attrs' => array()
					);
				}

//				if ($postTypeHierarchicalTaxs) $allPostTypesArr[] = $postTypeName;

				if (
					($this->sliderType === 'post' && $postTypeName === $selectedPostType) ||
					($this->sliderType === 'woocommerce' && $postTypeName === 'product')
				) {
					if (!count($_categories)) {
						foreach ($categories as $cat) {
							$_categories[$cat['key']] = $cat['value'];
						}
					}
					if (!count($_tags)) {
						foreach ($tags as $tag) {
							$_tags[$tag['key']] = $tag['value'];
						}
					}
				}
				if (!count($_format)) {
					foreach ($postFormats as $format) {
						$_format[$format['key']] = $format['value'];
					}
				}

			}
		}

	}

}

$sliderSettings = array(
    'main' => array(
        'title' => __('Slider Settings', MPSL_TEXTDOMAIN),
        'icon' => null,
        'description' => '',
        'options' => array(
            'slider_type' => array(
                'type' => 'select',
                'default' => 'custom',
                'list' => array(
                    'custom' => 'custom',
                    'post' => 'post',
                    'woocommerce' => 'woocommerce'
                ),
                'hidden' => true,
            ),
            'title' => array(
                'type' => 'text',
                'label' => __('Slider title *:', MPSL_TEXTDOMAIN),
                'description' => __('The title of the slider. Example: Slider1', MPSL_TEXTDOMAIN),
                'default' => __('New Slider', MPSL_TEXTDOMAIN),
                'disabled' => false,
                'required' => true,
            ),
            'alias' => array(
                'type' => 'alias',
                'label' => __('Slider alias *:', MPSL_TEXTDOMAIN),
                'alias' => 'shortcode',
                'description' => __('The alias that will be used in shortcode for embedding the slider. Alias must be unique. Example: slider1', MPSL_TEXTDOMAIN),
                'default' => '',
                'disabled' => false,
                'required' => true,
            ),
            'shortcode' => array(
                'type' => 'shortcode',
                'label' => __('Slider shortcode:', MPSL_TEXTDOMAIN),
                'description' => 'Copy this shortocode and paste to your page.',
                'default' => '',
                'readonly' => true,
//                'disabled' => false,
            ),
            'full_width' => array(
                'type' => 'checkbox',
                'label' => '',
                'label2' => __('Force Full Width', MPSL_TEXTDOMAIN),
                'description' => __('Enable this option to make this slider full-width / wide-screen', MPSL_TEXTDOMAIN),
                'default' => false
            ),
            'width' => array(
                'type' => 'number',
                'label' => __('Layers Grid Size', MPSL_TEXTDOMAIN),
                'label2' => __('Width:', MPSL_TEXTDOMAIN),
                'description' => __('Initial width of the layers', MPSL_TEXTDOMAIN),
//                'pattern' => '/^(0|[1-9][0-9]*)$/',
                'default' => 960,
                'min' => 0,
//                'disabled' => false
            ),
            'height' => array(
                'type' => 'number',
                'label' => '',
                'label2' => __('Height:', MPSL_TEXTDOMAIN),
                'description' => __('Initial height of the layers', MPSL_TEXTDOMAIN),
                'default' => 350,
                'min' => 0,
//                'disabled' => false
            ),
            /*'min_height' => array(
                'type' => 'number',
                'label2' => __('Min. Height:'),
                'default' => 500
            ),*/
            'enable_timer' => array(
                'type' => 'checkbox',
                'label' => '',
                'label2' => __('Enable Slideshow', MPSL_TEXTDOMAIN),
                'default' => true,
//                'disabled' => false
            ),
            'slider_delay' => array(
                'type' => 'text',
                'label' => __('Slideshow Delay:', MPSL_TEXTDOMAIN),
                'description' => __('The time one slide stays on the screen in milliseconds', MPSL_TEXTDOMAIN),
                'default' => 7000
            ),
            'slider_animation' => array(
                'type' => 'select',
                'label' => __('Slideshow Animation:', MPSL_TEXTDOMAIN),
                'default' => 'msSlide',
                   'list' => array(
                       'msSlide' => __('Slide', MPSL_TEXTDOMAIN),
                       'msSlideFade' => __('Fade', MPSL_TEXTDOMAIN),
                       'msSlideUpDown' => __('Slide Up', MPSL_TEXTDOMAIN),
                    ),
                    //'description' => __('Select slideshow animation', MPSL_TEXTDOMAIN),
            ),
            'slider_duration' => array(
                'type' => 'text',
                'label' => __('Slideshow Duration:', MPSL_TEXTDOMAIN),
                'description' => __('Animation duration in milliseconds', MPSL_TEXTDOMAIN),
                'default' => 2000
            ),
            'slider_easing' => array(
                'type' => 'select',
                'label' => __('Slideshow Easing:', MPSL_TEXTDOMAIN),
                'default' => 'easeOutCirc',
                   'list' => array(
                       'linear' => __('linear', MPSL_TEXTDOMAIN),
                       'ease' => __('ease', MPSL_TEXTDOMAIN),
                       'easeIn' => __('easeIn', MPSL_TEXTDOMAIN),
                       'easeOut' => __('easeOut', MPSL_TEXTDOMAIN),
                       'easeInOut' => __('easeInOut', MPSL_TEXTDOMAIN),
                       'easeInQuad' => __('easeInQuad', MPSL_TEXTDOMAIN),
                       'easeInCubic' => __('easeInCubic', MPSL_TEXTDOMAIN),
                       'easeInQuart' => __('easeInQuart', MPSL_TEXTDOMAIN),
                       'easeInQuint' => __('easeInQuint', MPSL_TEXTDOMAIN),
                       'easeInSine' => __('easeInSine', MPSL_TEXTDOMAIN),
                       'easeInExpo' => __('easeInExpo', MPSL_TEXTDOMAIN),
                       'easeInCirc' => __('easeInCirc', MPSL_TEXTDOMAIN),
                       'easeInBack' => __('easeInBack', MPSL_TEXTDOMAIN),
                       'easeOutQuad' => __('easeOutQuad', MPSL_TEXTDOMAIN),
                       'easeOutCubic' => __('easeOutCubic', MPSL_TEXTDOMAIN),
                       'easeOutQuart' => __('easeOutQuart', MPSL_TEXTDOMAIN),
                       'easeOutQuint' => __('easeOutQuint', MPSL_TEXTDOMAIN),
                       'easeOutSine' => __('easeOutSine', MPSL_TEXTDOMAIN),
                       'easeOutExpo' => __('easeOutExpo', MPSL_TEXTDOMAIN),
                       'easeOutCirc' => __('easeOutCirc', MPSL_TEXTDOMAIN),
                       'easeOutBack' => __('easeOutBack', MPSL_TEXTDOMAIN),
                       'easeInOutQuad' => __('easeInOutQuad', MPSL_TEXTDOMAIN),
                       'easeInOutCubic' => __('easeInOutCubic', MPSL_TEXTDOMAIN),
                       'easeInOutQuart' => __('easeInOutQuart', MPSL_TEXTDOMAIN),
                       'easeInOutQuint' => __('easeInOutQuint', MPSL_TEXTDOMAIN),
                       'easeInOutSine' => __('easeInOutSine', MPSL_TEXTDOMAIN),
                       'easeInOutExpo' => __('easeInOutExpo', MPSL_TEXTDOMAIN),
                       'easeInOutCirc' => __('easeInOutCirc', MPSL_TEXTDOMAIN),
                       'easeInOutBack' => __('easeInOutBack', MPSL_TEXTDOMAIN),
                   ),
                'description' => __('<a href="https://jqueryui.com/easing/" target="_blank">Easing examples</a>', MPSL_TEXTDOMAIN),
//                'dependency' => array(
//                    'parameter' => 'slider_animation',
//                    'value' => 'msSlide'
//                ),
            ),
//            'post_slider' => array(
//                'type' => 'checkbox',
//                'label' => '',
//                'label2' => __('Post content', MPSL_TEXTDOMAIN),
//                'description' => __('Enable post slider', MPSL_TEXTDOMAIN),
//                'default' => false
//            ),

//            'slider_layout' => array(
//                'type' => 'select',
//                'label' => __('Slider Layout', MPSL_TEXTDOMAIN),
//                'default' => 'auto',
//                'list' => array(
//                    'auto' => __('Auto', MPSL_TEXTDOMAIN)
//                )
//            ),
//            'description' => array(
//                'type' => 'textarea',
//                'label' => __('Description :', MPSL_TEXTDOMAIN),
//                'description' => __('Write some description', MPSL_TEXTDOMAIN),
//                'default' => 'Default description',
////                'disabled' => false,
//            ),
//            'test' => array(
//                'type' => 'select',
//                'label' => __('Test dependency', MPSL_TEXTDOMAIN),
//                'default' => 'off',
//                'list' => array(
//                    'on' => 'On',
//                    'off' => 'Off'
//                ),
//            ),
//            'test_dependency' => array(
//                'type' => 'text',
//                'label' => __('Test dependency input', MPSL_TEXTDOMAIN),
//                'default' => 'visible',
//                'dependency' => array(
//                    'parameter' => 'test',
//                    'value' => 'on'
//                ),
//            ),
//            'radio_group' => array(
//                'type' => 'radio_group',
//                'label' => __('Test radiogroup', MPSL_TEXTDOMAIN),
//                'default' => 'one',
//                'list' => array(
//                    'one' => 'One',
//                    'two' => 'Two',
//                    'three' => 'Three',
//                )
//            ),
            'start_slide' => array(
                'type' => 'number',
                'label' => __('Start with slide:', MPSL_TEXTDOMAIN),
                'description' => __('Slide index in the list of slides', MPSL_TEXTDOMAIN),
                'default' => 1,
				'min' => 1
            ),
        )
    ),

    'controls' => array(
        'title' => __('Controls', MPSL_TEXTDOMAIN),
        'icon' => null,
        'description' => '',
        'options' => array(
            'arrows_show' => array(
                'type' => 'checkbox',
                'label2' => __('Show arrows', MPSL_TEXTDOMAIN),
                'default' => true
            ),
            'thumbnails_show' => array(
                'type' => 'checkbox',
                'label2' => __('Show bullets', MPSL_TEXTDOMAIN),
                'default' => true
            ),
            'slideshow_timer_show' => array(
                'type' => 'checkbox',
                'label2' => __('Show slideshow timer', MPSL_TEXTDOMAIN),
                'default' => true
            ),
            'slideshow_ppb_show' => array(
                'type' => 'checkbox',
                'label2' => __('Show slideshow play/pause button', MPSL_TEXTDOMAIN),
                'default' => true
            ),
            'controls_hide_on_leave' => array(
                'type' => 'checkbox',
                'label2' => __('Hide controls when mouse leaves slider', MPSL_TEXTDOMAIN),
                'default' => false
            ),
            'hover_timer' => array(
                'type' => 'checkbox',
                'label2' => __('Pause on Hover', MPSL_TEXTDOMAIN),
                'description' => __('Pause slideshow when hover the slider', MPSL_TEXTDOMAIN),
                'default' => false
            ),
            'timer_reverse' => array(
                'type' => 'checkbox',
                'label2' => __('Reverse order of the slides', MPSL_TEXTDOMAIN),
                'description' => __('Animate slides in the reverse order', MPSL_TEXTDOMAIN),
                'default' => false
            ),
            'counter' => array(
                'type' => 'checkbox',
                'label2' => __('Show counter', MPSL_TEXTDOMAIN),
                'description' => __('Displays the number of slides', MPSL_TEXTDOMAIN),
                'default' => false
            ),
            'swipe' => array(
                'type' => 'checkbox',
                'label2' => __('Enable swipe', MPSL_TEXTDOMAIN),
                'description' => __('Turn on swipe on desktop', MPSL_TEXTDOMAIN),
                'default' => true
            ),
        )
    ),

    'appearance' => array(
        'title' => __('Appearance', MPSL_TEXTDOMAIN),
        'icon' => null,
        'description' => '',
        'options' => array(
            'visible_from' => array(
                'type' => 'number',
                'label' => __('Visible', MPSL_TEXTDOMAIN),
                'label2' => __('from', MPSL_TEXTDOMAIN),
                'unit' => 'px',
                'default' => '',
                'min' => 0,
            ),
            'visible_till' => array(
                'type' => 'number',
                'label' => '',
                'label2' => __('till', MPSL_TEXTDOMAIN),
                'unit' => 'px',
                'default' => '',
                'min' => 0,
            ),
            'presets' => array(
                'type' => 'action_group',
                'label' => '',
                'label2' => __('presets:', MPSL_TEXTDOMAIN),
                'default' => '',
                'list' => array(
                    'phone' => __('Phone', MPSL_TEXTDOMAIN),
                    'tablet' => __('Tablet', MPSL_TEXTDOMAIN),
                    'desktop' => __('Desktop', MPSL_TEXTDOMAIN)
                ),
                'actions' => array(
                    'phone' => array(
                        'visible_from' => '',
                        'visible_till' => 767
                    ),
                    'tablet' => array(
                        'visible_from' => 768,
                        'visible_till' => 991
                    ),
                    'desktop' => array(
                        'visible_from' => 992,
                        'visible_till' => ''
                    )
                )
            ),
            'delay_init' => array(
                'type' => 'text',
                'label' => __('Initialization delay:', MPSL_TEXTDOMAIN),
                //'description' => __('Type slider init delay', MPSL_TEXTDOMAIN),
                'default' => 0
            ),

            'scroll_init' => array(
                'type' => 'checkbox',
                'label' => '',
                'label2' => __('Initialize slider on scroll', MPSL_TEXTDOMAIN),
                //'description' => __('Enable this option to init slider on scroll', MPSL_TEXTDOMAIN),
                'default' => false
            ),
            'custom_class' => array(
                'type' => 'text',
                'label' => __('Slider custom class name', MPSL_TEXTDOMAIN),
                'default' => ''
            ),
            'custom_styles' => array(
                'type' => 'codemirror',
                'mode' => 'css',
                'label2' => __('Slider custom styles', MPSL_TEXTDOMAIN),
                'default' => ''
            ),
        )
    ),

);

if (in_array($this->sliderType, array('post', 'woocommerce'))) {

	// Taxonomy dependencies
	$taxDepsParam = $postFormatsTaxDepsParam = 'post_type';
	if ($this->sliderType === 'woocommerce') {
		$taxDepsParam = 'slider_type';
		$catDependency = $tagsDependency = 'woocommerce';
		
		if (in_array('product', $postFormatsDependency)) {
			$postFormatsTaxDepsParam = 'slider_type';
			$postFormatsDependency = 'woocommerce';
		}
	};

	$postSliderLabels = array();
	switch ($this->sliderType) {
		case 'post':
			$postSliderLabels = array(
				'tab_label' => __('Content', MPSL_TEXTDOMAIN),
                'exclude_label' => __('Exclude posts:', MPSL_TEXTDOMAIN),
                'exclude_description' => __('post id\'s separated by comma', MPSL_TEXTDOMAIN),
                'include_label' => __('Include posts:', MPSL_TEXTDOMAIN),
                'include_description' => __('post id\'s separated by comma', MPSL_TEXTDOMAIN),
                'count_label' => __('Number of posts to display: ', MPSL_TEXTDOMAIN),
                'link_label' => __('Link slides to post\'s page: ', MPSL_TEXTDOMAIN),
			);
			break;
		case 'woocommerce':
			$postSliderLabels = array(
				'tab_label' => __('Content', MPSL_TEXTDOMAIN),
                'exclude_label' => __('Exclude products:', MPSL_TEXTDOMAIN),
                'exclude_description' => __('product id\'s separated by comma', MPSL_TEXTDOMAIN),
                'include_label' => __('Include products:', MPSL_TEXTDOMAIN),
                'include_description' => __('product id\'s separated by comma', MPSL_TEXTDOMAIN),
                'count_label' => __('Number of products to display: ', MPSL_TEXTDOMAIN),
                'link_label' => __('Link slides to product\'s page: ', MPSL_TEXTDOMAIN),
			);
			break;
	}


	$sliderSettings['post_settings'] = array(
		'title' => $postSliderLabels['tab_label'],
		'icon' => null,
		'description' => '',
		'options' => array(
			'post_type' => array(
				'type' => 'select',
				'label' => __('Select Post type:', MPSL_TEXTDOMAIN),
				'default' => $defaultPostType,
				'list' => $postTypesArr,
				'listAttrSettings' => array(
		            'data-categories' => array(
			            'type' => 'json',
		            ),
                    'data-tags' => array(
                        'type' => 'json',
                    )
	            ),
				'dependency' => array(
					'parameter' => 'slider_type',
					'value' => 'post',
				)
			),

			'post_categories' => array(
				'type' => 'select',
				'label' => __('Categories:', MPSL_TEXTDOMAIN),
				'default' => 0,
				'multiple' => true,
				'list' => $_categories,
				'helpers' => array('post_type'),
				'dynamicList' => array(
					'parameter' => 'post_type',
					'attr' => 'data-categories',
				),
                'dependency' => array(
					'parameter' => $taxDepsParam,
					'value' => $catDependency,
				)
			),

			'post_tags' => array(
				'type' => 'select',
				'label' => __('Tags:', MPSL_TEXTDOMAIN),
				'default' => 0,
				'multiple' => true,
				'list' => $_tags,
                'helpers' => array('post_type'),
                'dynamicList' => array(
                    'parameter' => 'post_type',
                    'attr' => 'data-tags',
                ),
                'dependency' => array(
                    'parameter' => $taxDepsParam,
                    'value' => $tagsDependency,
                )
			),

			'post_format' => array(
				'type' => 'select',
				'label' => __('Post Format:', MPSL_TEXTDOMAIN),
				'default' => 0,
				'multiple' => true,
				'list' => $_format,
				'dependency' => array(
					'parameter' => $postFormatsTaxDepsParam,
					'value' => $postFormatsDependency,
				)
			),

			'post_exclude_ids' => array(
				'type' => 'text',
				'label' => $postSliderLabels['exclude_label'],
				'description' => $postSliderLabels['exclude_description'],
				'default' => '',
				'dependency' => array(
					'parameter' => 'slider_type',
					'value' => array('post', 'woocommerce'),
				)
			),
			'post_include_ids' => array(
				'type' => 'text',
				'label' => $postSliderLabels['include_label'],
				'description' => $postSliderLabels['include_description'],
				'default' => '',
				'dependency' => array(
					'parameter' => 'slider_type',
					'value' => array('post', 'woocommerce'),
				)
			),
			'post_count' => array(
				'type' => 'number',
				'label' => $postSliderLabels['count_label'],
				'default' => 10,
				'min' => -1,
				'dependency' => array(
					'parameter' => 'slider_type',
					'value' => array('post', 'woocommerce'),
				)
			),
			'post_excerpt_length' => array(
				'type' => 'number',
				'label' => __('Excerpt length:', MPSL_TEXTDOMAIN),
				'description' => __('character(s)', MPSL_TEXTDOMAIN),
				'default' => 200,
				'min' => 0,
				'dependency' => array(
					'parameter' => 'slider_type',
					'value' => array('post', 'woocommerce'),
				)
			),
			'post_offset' => array(
				'type' => 'number',
				'label' => __('Number of first results to skip (offset):', MPSL_TEXTDOMAIN),
				'default' => '',
				'min' => 0,
				'dependency' => array(
					'parameter' => 'slider_type',
					'value' => array('post', 'woocommerce'),
				)
			),
			'post_link_slide' => array(
				'type' => 'checkbox',
				'label' => $postSliderLabels['link_label'],
				'default' => false,
				'dependency' => array(
					'parameter' => 'slider_type',
					'value' => array('post', 'woocommerce'),
				)
			),
			'post_link_target' => array(
				'type' => 'checkbox',
				'label' => __('Open in new window:', MPSL_TEXTDOMAIN),
				'default' => false,
				'dependency' => array(
					'parameter' => 'post_link_slide',
					'value' => true,
				)
			),
			'post_order_by' => array(
				'type' => 'select',
				'label' => __('Order By:', MPSL_TEXTDOMAIN),
				'default' => 'date',
				'list' => array(
					'date' => 'Date',
					'menu_order' => 'Menu Order',
					'title' => 'Title',
					'id' => 'Id',
					'random' => 'Random',
					'comments' => 'Comments',
					'date_modified' => 'Date Modified',
					'none' => 'None'
				),
				'dependency' => array(
					'parameter' => 'slider_type',
					'value' => array('post', 'woocommerce'),
				)
			),
			'post_order_direction' => array(
				'type' => 'select',
				'label' => __('Order direction:', MPSL_TEXTDOMAIN),
				'default' => 'DESC',
				'list' => array(
					'DESC' => 'Descending (largest to smallest)',
					'ASC' => 'Ascending (smallest to largest)',
				),
				'dependency' => array(
					'parameter' => 'slider_type',
					'value' => array('post', 'woocommerce'),
				)
			),
		),
	);

	if ($this->sliderType === 'woocommerce') {
		$sliderSettings['post_settings']['options'] = array_merge($sliderSettings['post_settings']['options'], array(
			'wc_only_instock' => array(
				'type' => 'checkbox',
				'label' => __('Only display in-stock products. ', MPSL_TEXTDOMAIN),
				'default' => false,
				'dependency' => array(
					'parameter' => 'slider_type',
					'value' => 'woocommerce',
				)
			),
			'wc_only_featured' => array(
				'type' => 'checkbox',
				'label' => __('Only display featured products. ', MPSL_TEXTDOMAIN),
				'default' => false,
				'dependency' => array(
					'parameter' => 'slider_type',
					'value' => 'woocommerce',
				)
			),
			'wc_only_onsale' => array(
				'type' => 'checkbox',
				'label' => __('Only display on sale products. ', MPSL_TEXTDOMAIN),
				'default' => false,
				'dependency' => array(
					'parameter' => 'slider_type',
					'value' => 'woocommerce',
				)
			)
		));
	}
}


if ($this->sliderType === 'post') {
	$sliderSettings['main']['options']['title']['default'] = __('New Posts Slider', MPSL_TEXTDOMAIN);
} else if ($this->sliderType === 'woocommerce') {
	$sliderSettings['main']['options']['title']['default'] = __('New WooCommerce Slider', MPSL_TEXTDOMAIN);
}

return $sliderSettings;