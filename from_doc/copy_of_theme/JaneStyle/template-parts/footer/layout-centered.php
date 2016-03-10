<?php
/**
 * The template for displaying the default footer layout.
 *
 * @package jane_style
 */

?>
<div class="footer-container">
	<div <?php echo jane_style_get_container_classes( array( 'site-info' ) ); ?>>
		<?php
			jane_style_footer_logo();
            jane_style_footer_text_center();
			jane_style_social_list( 'footer' );
			jane_style_footer_copyright();
			jane_style_footer_menu();
		?>
	</div><!-- .site-info -->
</div><!-- .container -->