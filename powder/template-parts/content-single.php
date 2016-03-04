<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package powder
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			powder_meta_date( 'single' );

			the_title( '<h1 class="entry-title">', '</h1>' );
		?>

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">

				<?php
					powder_meta_author(
						'single',
						array(
							'before' => esc_html__( 'Posted by', 'powder' ) . ' ',
						)
					);
				?>

				<?php
					powder_meta_comments( 'single', array(
						'zero'   => '0' . esc_html__( ' Comment', 'powder' ),
						'one'    => '1' . esc_html__( ' Comment', 'powder' ),
						'plural' => '%' . esc_html__( ' Comments', 'powder' ),
					) );
				?>

			</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->

	<figure class="post-thumbnail">
		<?php powder_post_thumbnail( false ); ?>
	</figure><!-- .post-thumbnail -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'powder' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			powder_meta_categories( 'single', array(
				'before'    => esc_html__( 'Categories: ', 'powder' ),
			));

			powder_meta_tags( 'single', array(
				'before'    => '<i class="material-icons">folder_open</i>',
				'separator' => ', ',
			) );
		?>
		<?php powder_share_buttons( 'single' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
