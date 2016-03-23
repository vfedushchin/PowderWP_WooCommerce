<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package fairy_style
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'posts-list__item card' ); ?>>

	<div class="post-list__item-content">

		<div class="post-featured-content format-quote invert">
		<?php fairy_style_meta_date( 'loop' ); ?>

			<?php fairy_style_sticky_label(); ?>
			<?php do_action( 'cherry_post_format_quote' ); ?>
		</div><!-- .post-featured-content -->

		<header class="entry-header">
			<?php
				if ( is_single() ) {
					the_title( '<h5 class="entry-title">', '</h5>' );
				} else {
					the_title( '<h5 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' );
				}
			?>

			<?php if ( 'post' === get_post_type() ) : ?>

				<div class="entry-meta">

					<?php
						fairy_style_meta_author(
							'loop',
							array(
								'before' => esc_html__( 'Posted by', 'fairy_style' ) . ' ',
							)
						);
					?>

					<?php
						fairy_style_meta_comments( 'loop', array(
							'zero'   => '0' . esc_html__( ' Comment', 'fairy_style' ),
							'one'    => '1' . esc_html__( ' Comment', 'fairy_style' ),
							'plural' => '%' . esc_html__( ' Comments', 'fairy_style' ),
						) );
					?>

				</div><!-- .entry-meta -->

			<?php endif; ?>

		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php fairy_style_blog_content(); ?>
		</div><!-- .entry-content -->

	</div>

	<footer class="entry-footer">
		<?php
			fairy_style_meta_categories( 'loop', array(
				'before'    => esc_html__( 'Categories: ', 'fairy_style' ),
			));

			fairy_style_meta_tags( 'loop' );
		?>

		<?php fairy_style_read_more(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
