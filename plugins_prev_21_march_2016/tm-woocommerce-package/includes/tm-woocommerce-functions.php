<?php

if ( ! function_exists( 'tm_products_carousel_widget_sale_end_date' ) ) {

	function tm_products_carousel_widget_sale_end_date() {

		global $post, $product;

		$sale_end_date = get_post_meta( $product->id, '_sale_price_dates_to', true );

		if( '' != $sale_end_date ) {
			$data_format = apply_filters( 'tm_products_carousel_widget_sale_end_date_format', __( '<span>%D <i>days</i></span> <span>%H <i>Hrs</i></span><span>%M <i>Min</i></span>', 'child-theme-domian' ) );
			$sale_end_date = '<span class="tm-products-carousel-widget-sale-end-date" data-countdown="' . date ( 'Y/m/d', $sale_end_date ) . '" data-format="' . $data_format . '"></span>';
		}

		echo $sale_end_date;

	}

}

if ( ! function_exists( 'tm_woocommerce_package_field_label' ) ) {

	function tm_woocommerce_package_field_label( $key, $value, $setting, $instance ) {
		$html[] = '<p>';
		$html[] = '<label><b>' . $setting["label"] . '</b></label>';
		$html[] = '</p>';
		echo implode ( "\n", $html );
	}

}

if ( ! function_exists( 'tm_products_carousel_widget_cat' ) ) {

	function tm_products_carousel_widget_cat() {

		global $product;

		$cats_arr = wp_get_object_terms($product->id,'product_cat');
		if (!empty( $cats_arr )) {
			$cats[] = '<div class="tm_products_carousel_widget_cats">';
			foreach ($cats_arr as $cat) {
				$cats[] = '<a href="' . get_term_link( $cat->slug, 'product_cat' ) . '">' . $cat->name . '</a>';
			}
			$cats[] = '</div>';
			echo implode ("\n", $cats);
		}
	}

}

if ( ! function_exists( 'tm_products_carousel_widget_tag' ) ) {

	function tm_products_carousel_widget_tag() {

		global $product;

		$tags_arr = wp_get_object_terms($product->id,'product_tag');
		if (!empty( $tags_arr )) {
			$tags[] = '<div class="tm_products_carousel_widget_cats">';
			foreach ($tags_arr as $tag) {
				$tags[] = '<a href="' . get_term_link( $tag->slug, 'product_tag' ) . '">' . $tag->name . '</a>';
			}
			$tags[] = '</div>';
			echo implode ("\n", $tags);
		}
	}

}

function tm_products_smart_box_widget_settings_sanitize_option ( $instance, $new_instance, $key, $setting ) {

	if ( $setting['type'] === 'multiselect' ) {
		$instance =  esc_sql($new_instance[ $key ]);
	}

	return $instance;

}

?>