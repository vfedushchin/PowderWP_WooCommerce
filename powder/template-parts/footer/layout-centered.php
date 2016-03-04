<?php
/**
 * The template for displaying the default footer layout.
 *
 * @package powder
 */

?>
<div class="footer-container">
	<div <?php echo powder_get_container_classes( array( 'site-info' ) ); ?>>
		<?php
			powder_footer_logo();
            powder_footer_text_center();
			powder_social_list( 'footer' );
			powder_footer_copyright();
			powder_footer_menu();
		?>
	</div><!-- .site-info -->
</div><!-- .container -->