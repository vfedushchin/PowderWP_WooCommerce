<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Jane_Style
 */
?>

<section class="error-404 not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( '404', 'Jane_Style' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<h2><?php esc_html_e( 'The page not found.', 'Jane_Style' ); ?></h2>
		<p><a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Visit home page', 'Jane_Style' ); ?></a></p>
        <hr>
		<h4><?php esc_html_e( 'Unfortunately the page you were looking for could not be found. Maybe search can help.', 'Jane_Style' ); ?></h4>

		<?php get_search_form(); ?>

	</div><!-- .page-content -->
</section><!-- .error-404 -->