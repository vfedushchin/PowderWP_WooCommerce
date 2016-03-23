<?php get_header( cosmetro_template_base() ); ?>

	<?php cosmetro_site_breadcrumbs(); ?>

	<div class="container">

		<?php do_action( 'cosmetro_render_widget_area', 'before-content-area' ); ?>

		<div class="row">

			<div id="primary" <?php cosmetro_primary_content_class(); ?>>

				<?php do_action( 'cosmetro_render_widget_area', 'before-loop-area' ); ?>

				<main id="main" class="site-main">

					<?php include cosmetro_template_path(); ?>

				</main><!-- #main -->

				<?php do_action( 'cosmetro_render_widget_area', 'after-loop-area' ); ?>

			</div><!-- #primary -->

			<?php get_sidebar( 'secondary' ); // Loads the sidebar-secondary.php template. ?>

			<?php get_sidebar( 'primary' ); // Loads the sidebar-primary.php template.  ?>

		</div><!-- .row -->

		<?php do_action( 'cosmetro_render_widget_area', 'after-content-area' ); ?>

	</div><!-- .container -->

	<?php do_action( 'cosmetro_render_widget_area', 'after-content-full-width-area' ); ?>

<?php get_footer( cosmetro_template_base() ); ?>
