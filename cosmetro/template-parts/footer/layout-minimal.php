<?php
/**
 * The template for displaying the default footer layout.
 *
 * @package __Tm
 */
?>

<div class="footer-container">
	<div <?php echo cosmetro_get_container_classes( array( 'site-info' ) ); ?>>
		<div class="site-info__flex">
			<?php cosmetro_footer_logo(); ?>
			<div class="site-info__mid-box"><?php
				cosmetro_footer_copyright();
				// cosmetro_footer_menu();
			?></div>
			<?php cosmetro_social_list( 'footer' ); ?>
		</div>
	</div><!-- .site-info -->
</div><!-- .container -->