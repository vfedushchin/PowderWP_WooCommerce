<?php get_header( cosmetro_template_base() ); ?>

	<?php cosmetro_site_breadcrumbs(); ?>

	<div class="container">

		<?php do_action( 'cosmetro_render_widget_area', 'before-content-area' ); ?>

		<div class="row">

			<div id="primary" <?php cosmetro_primary_content_class(); ?>>


			<?php
				$customizer_breadcrumbs_page_title = get_theme_mod( 'breadcrumbs_page_title', cosmetro_theme()->customizer->get_default( 'breadcrumbs_page_title' ) );
				if ( $customizer_breadcrumbs_page_title) {
					$cherry_breadcrumbs = cosmetro_theme()->get_core()->modules['cherry-breadcrumbs'];
					$title = apply_filters(
						'cherry_page_title',
						sprintf( $cherry_breadcrumbs->args['page_title_format'], $cherry_breadcrumbs->page_title ), $cherry_breadcrumbs->args
					);
					echo $title;
				}
			 ?>

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
