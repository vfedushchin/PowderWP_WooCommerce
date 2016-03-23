<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cosmetro
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			cosmetro_meta_date( 'single' );

			the_title( '<h1 class="entry-title">', '</h1>' );
		?>

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">

				<?php
					cosmetro_meta_author(
						'single',
						array(
							'before' => esc_html__( 'Posted by', 'cosmetro' ) . ' ',
						)
					);
				?>

				<?php
					cosmetro_meta_comments( 'single', array(
						'zero'   => '0' . esc_html__( ' Comment', 'cosmetro' ),
						'one'    => '1' . esc_html__( ' Comment', 'cosmetro' ),
						'plural' => '%' . esc_html__( ' Comments', 'cosmetro' ),
					) );
				?>

			</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->

	<figure class="post-thumbnail">
		<?php cosmetro_post_thumbnail( false ); ?>
	</figure><!-- .post-thumbnail -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cosmetro' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			cosmetro_meta_categories( 'single', array(
				'before'    => esc_html__( 'Categories: ', 'cosmetro' ),
			));

			cosmetro_meta_tags( 'single' );
		?>
		<?php cosmetro_share_buttons( 'single' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
