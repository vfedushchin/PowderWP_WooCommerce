<?php
/**
 * Cart dropdown template
 *
 * @version     1.0.0
 */
?>
<a href="<?php echo esc_url( $jane_style_wc_compare_button['url'] ); ?>" class="compare <?php echo esc_attr( $jane_style_wc_compare_button['is_button'] ); ?>" data-product_id="<?php echo absint( $jane_style_wc_compare_button['product_id'] ); ?>">
	<span class="product_actions_tip add_to_compare_button__text">
		<?php echo sanitize_text_field( $jane_style_wc_compare_button['button_text'] ); ?>
	</span>
</a>