<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */

global $product;
?>

<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id ) )?>" rel="nofollow" data-product-id="<?php echo $product_id ?>" data-product-type="<?php echo $product_type?>" class="<?php echo $link_classes ?>" >
	<span class="product_actions_tip add_to_wishlist_button__text add">
	<?php echo $icon ?>
	<?php echo $label ?>
	</span>
</a>
<img src="<?php echo esc_url( FAIRY_STYLE_THEME_URI . '/assets/images/rolling.svg' ) ?>" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden" />