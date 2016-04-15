<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( has_post_thumbnail() ) {
	array_unshift($attachment_ids, get_post_thumbnail_id());
}

if ( $attachment_ids ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

		foreach ( $attachment_ids as $attachment_id ) {

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
				continue;

			$image_src = wp_get_attachment_image_src( $attachment_id, apply_filters( 'single_product_image_size', 'shop_single' ) );

			$thumb_src = wp_get_attachment_image_src( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );

			$original_src = wp_get_attachment_image_src( $attachment_id, apply_filters( 'single_product_oiginal_size', 'original' ) );

			$image_class = '';

			$html = array();

			$html[] = '<div class="easyzoom">';
		    $html[] = '<a href="%s">';
			$html[] = '<img data-u="image" src="%s">';
			$html[] = '</a>';
			$html[] = '<img data-u="thumb" src="%s">';
			$html[] = '</div>';
			$html[] = '';

			$html_string = implode( "\n", $html );

			if ( is_array( $image_src ) && is_array( $thumb_src ) && is_array( $original_src ) ) echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( $html_string, $original_src[0], $image_src[0], $thumb_src[0] ), $attachment_id, $post->ID, $image_class );

			$loop++;
		}
} ?>
