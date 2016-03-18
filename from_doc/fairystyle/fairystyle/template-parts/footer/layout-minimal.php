<?php
/**
 * The template for displaying the default footer layout.
 *
 * @package __Tm
 */
?>

<div class="footer-container">
	<div <?php echo fairy_style_get_container_classes( array( 'site-info' ) ); ?>>
		<div class="site-info__flex">
			<?php fairy_style_footer_logo(); ?>
			<div class="site-info__mid-box"><?php
				fairy_style_footer_copyright();
				// fairy_style_footer_menu();
			?></div>
			<?php fairy_style_social_list( 'footer' ); ?>
		</div>
	</div><!-- .site-info -->
</div><!-- .container -->