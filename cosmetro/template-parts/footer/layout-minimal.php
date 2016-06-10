<?php
/**
 * The template for displaying the default footer layout.
 *
 * @package __Tm
 */

?>
<div class="footer-container">
	<div <?php echo cosmetro_get_container_classes( array( 'site-info' ) ); ?>>
		<?php
			cosmetro_footer_logo();
      // cosmetro_social_list( 'footer' );
      cosmetro_footer_menu();
      cosmetro_footer_copyright();
		?>
	</div><!-- .site-info -->
</div><!-- .container -->