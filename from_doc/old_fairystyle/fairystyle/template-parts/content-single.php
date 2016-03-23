<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package fairy_style
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			fairy_style_meta_date( 'single' );

			the_title( '<h1 class="entry-title">', '</h1>' );
		?>

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">

				<?php
					fairy_style_meta_author(
						'single',
						array(
							'before' => esc_html__( 'Posted by', 'fairy_style' ) . ' ',
						)
					);
				?>

				<?php
					fairy_style_meta_comments( 'single', array(
						'zero'   => '0' . esc_html__( ' Comment', 'fairy_style' ),
						'one'    => '1' . esc_html__( ' Comment', 'fairy_style' ),
						'plural' => '%' . esc_html__( ' Comments', 'fairy_style' ),
					) );
				?>

			</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->

	<figure class="post-thumbnail">
		<?php fairy_style_post_thumbnail( false ); ?>
	</figure><!-- .post-thumbnail -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fairy_style' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			fairy_style_meta_categories( 'single', array(
				'before'    => esc_html__( 'Categories: ', 'fairy_style' ),
			));

			fairy_style_meta_tags( 'single' );
		?>
		<?php fairy_style_share_buttons( 'single' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
