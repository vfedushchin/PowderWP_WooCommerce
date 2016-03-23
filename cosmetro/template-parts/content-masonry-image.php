<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cosmetro
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'posts-list__item card' ); ?>>

	<div class="post-list__item-content">

		<div class="post-format-wrap post-thumbnail">
			<?php do_action( 'cherry_post_format_image' ); ?>
			<?php cosmetro_sticky_label(); ?>
			<?php cosmetro_meta_date( 'loop' ); ?>
		</div>

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
						cosmetro_meta_author(
							'loop',
							array(
								'before' => esc_html__( 'Posted by', 'cosmetro' ) . ' ',
							)
						);
					?>

					<?php
						cosmetro_meta_comments( 'loop', array(
							'zero'   => '0' . esc_html__( ' Comment', 'cosmetro' ),
							'one'    => '1' . esc_html__( ' Comment', 'cosmetro' ),
							'plural' => '%' . esc_html__( ' Comments', 'cosmetro' ),
						) );
					?>

				</div><!-- .entry-meta -->

			<?php endif; ?>

		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php cosmetro_blog_content(); ?>
		</div><!-- .entry-content -->

	</div>
	<footer class="entry-footer">
		<?php
			cosmetro_meta_categories( 'loop', array(
				'before'    => esc_html__( 'Categories: ', 'cosmetro' ),
			));

			cosmetro_meta_tags( 'loop', array(
				'before'    => esc_html__( 'Tags: ', 'cosmetro' ),
			));
		?>
		<?php cosmetro_read_more(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
