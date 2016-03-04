<?php
/**
 * The template for displaying the default footer layout.
 *
 * @package powder
 */

?>
<div class="footer-area-wrap invert">
	<div class="container">
		<?php do_action( 'powder_render_widget_area', 'footer-area' ); ?>
	</div>
</div>

<div class="footer-container">
	<div <?php echo powder_get_container_classes( array( 'site-info' ) ); ?>>
		<div class="site-info__flex">
			<?php powder_footer_logo(); ?>
			<div class="site-info__mid-box"><?php
				powder_footer_copyright();
				powder_footer_menu();
			?></div>
			<?php powder_social_list( 'footer' ); ?>
		</div>
	</div><!-- .site-info -->
</div><!-- .container -->