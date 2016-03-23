<?php

if ( ! function_exists( 'tm_products_carousel_widget_sale_end_date' ) ) {

	function tm_products_carousel_widget_sale_end_date() {

		global $post, $product;

		$sale_end_date = get_post_meta( $product->id, '_sale_price_dates_to', true );

		if( '' != $sale_end_date ) {
			$data_format = apply_filters( 'tm_products_carousel_widget_sale_end_date_format', __( '%D days %H:%M:%S', 'child-theme-domian' ) );
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
		echo $product->get_categories( '</li> <li>', '<ul class="product-widget-categories"><li>', '</li></ul>' );
	}
}

if ( ! function_exists( 'tm_products_carousel_widget_tag' ) ) {

	function tm_products_carousel_widget_tag() {

		global $product;
		echo $product->get_tags( '</li> <li>', '<ul class="product-widget-tags"><li>', '</li></ul>' );
	}

}

function tm_products_smart_box_widget_settings_sanitize_option ( $instance, $new_instance, $key, $setting ) {

	if ( $setting['type'] === 'multiselect' ) {
		$instance =  esc_sql($new_instance[ $key ]);
	}

	return $instance;

}

?>