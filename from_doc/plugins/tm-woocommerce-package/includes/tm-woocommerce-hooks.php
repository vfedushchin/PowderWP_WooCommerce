<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_action( 'woocommerce_after_shop_loop_item_title', 'tm_products_carousel_widget_sale_end_date', 11 );

add_action( 'tm_smart_box_woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
add_action( 'tm_smart_box_woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
add_action( 'tm_smart_box_woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'tm_smart_box_woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

add_action( 'tm_smart_box_woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

add_action( 'woocommerce_widget_field_label', 'tm_woocommerce_package_field_label', 10, 4 );

?>