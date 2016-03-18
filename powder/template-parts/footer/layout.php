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
			<?php powder_footer_logo(); ?>
			<div class="site-info__mid-box2"><?php
				powder_footer_copyright();
				powder_footer_menu();
			?></div>
		</div>
	</div><!-- .site-info -->
</div><!-- .container -->