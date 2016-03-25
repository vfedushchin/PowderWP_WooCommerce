<?php
/**
 * The template for displaying the default footer layout.
 *
 * @package __Tm
 */

?>
<div class="footer-area-wrap invert">
  <div class="container">
    <?php do_action( 'cosmetro_render_widget_area', 'footer-area2' ); ?>
  </div>
</div>

<div class="footer-container">
	<div <?php echo cosmetro_get_container_classes( array( 'site-info' ) ); ?>>
		<?php
			cosmetro_footer_logo();
      cosmetro_social_list( 'footer' );
      cosmetro_footer_menu();
      cosmetro_footer_copyright();
		?>
	</div><!-- .site-info -->
</div><!-- .container -->