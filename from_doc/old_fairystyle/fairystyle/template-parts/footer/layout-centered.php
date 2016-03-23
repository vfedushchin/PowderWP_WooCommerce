<?php
/**
 * The template for displaying the default footer layout.
 *
 * @package __Tm
 */

?>
<div class="footer-container">
	<div <?php echo fairy_style_get_container_classes( array( 'site-info' ) ); ?>>
		<?php
			fairy_style_footer_logo();
            fairy_style_footer_text_center();
            fairy_style_social_list( 'footer' );
            fairy_style_footer_copyright();
            fairy_style_footer_menu();
		?>
	</div><!-- .site-info -->
</div><!-- .container -->