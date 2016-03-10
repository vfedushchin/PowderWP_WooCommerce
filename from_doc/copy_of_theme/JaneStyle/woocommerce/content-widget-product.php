<?php
/**
 * The template for displaying product widget entries
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product; ?>

<li>
	<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<?php echo $product->get_image(); ?>
	</a>
	<ul class="product-widget-categories">
	<?php
	$cats = wp_get_post_terms( $product->id, 'product_cat' );
	$include = array();
	foreach ( $cats as $cat ) {
		$include[] = $cat->term_id;
	}
	include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );

	$list_args = array(
		'walker' => new WC_Product_Cat_List_Walker,
		'hierarchical' => false,
		'current_category_ancestors' => '',
		'taxonomy' => 'product_cat',
		'menu_order' => 'asc',
		'title_li' => '',
		'show_option_none' => '',
		'include' => implode( ',', $include ),

	);

	wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );
	?>
	</ul>
	<div class="product_title_link"><a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<span class="product-title"><?php echo $product->get_title(); ?></span>
	</a>
	</div>
	<?php echo $product->get_price_html(); ?>
	<?php if ( ! empty( $show_rating ) ) : ?>
		<?php echo $product->get_rating_html(); ?>
	<?php endif; ?>
</li>
