<?php
/**
 * The template for displaying the default footer layout.
 *
 * @package jane_style
 */

?>

<div class="footer-container">
	<div <?php echo jane_style_get_container_classes( array( 'site-info' ) ); ?>>
		<div class="site-info__flex">
			<?php jane_style_footer_logo(); ?>
			<div class="site-info__mid-box"><?php
				jane_style_footer_copyright();
				// jane_style_footer_menu();
			?></div>
			<?php jane_style_social_list( 'footer' ); ?>
		</div>
	</div><!-- .site-info -->
</div><!-- .container -->