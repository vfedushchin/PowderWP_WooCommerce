<?php get_header( jane_style_template_base() ); ?>

	<?php jane_style_site_breadcrumbs(); ?>

	<div class="container">

		<?php do_action( 'jane_style_render_widget_area', 'before-content-area' ); ?>

		<div class="row">

			<div id="primary" <?php jane_style_primary_content_class(); ?>>

				<?php do_action( 'jane_style_render_widget_area', 'before-loop-area' ); ?>

				<main id="main" class="site-main" role="main">

					<?php include jane_style_template_path(); ?>

				</main><!-- #main -->

				<?php do_action( 'jane_style_render_widget_area', 'after-loop-area' ); ?>

			</div><!-- #primary -->

			<?php get_sidebar( 'secondary' ); // Loads the sidebar-secondary.php template. ?>

			<?php get_sidebar( 'primary' ); // Loads the sidebar-primary.php template.  ?>

		</div><!-- .row -->

		<?php do_action( 'jane_style_render_widget_area', 'after-content-area' ); ?>

	</div><!-- .container -->

	<?php do_action( 'jane_style_render_widget_area', 'after-content-full-width-area' ); ?>

<?php get_footer( jane_style_template_base() ); ?>
