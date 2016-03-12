<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package powder
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'posts-list__item card' ); ?>>

	<div class="post-list__item-content">

		<div class="post-featured-content invert">
			<?php do_action( 'cherry_post_format_video', array( 'width'  => 1100, 'height' => 480, ) ); ?>
			<?php powder_meta_categories( 'loop' ); ?>
			<?php powder_sticky_label(); ?>
		</div><!-- .post-featured-content -->

		<header class="entry-header">
			<?php
				powder_meta_author(
					'loop',
					array(
						'before' => esc_html__( 'Posted by', 'powder' ) . ' ',
					)
				);
			?>
			<?php
				if ( is_single() ) {
					the_title( '<h1 class="entry-title">', '</h1>' );
				} else {
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				}
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php powder_blog_content(); ?>
		</div><!-- .entry-content -->

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">
				<?php
					powder_meta_date( 'loop', array(
						'before' => '<i class="material-icons">event</i>',
					) );

					powder_meta_comments( 'loop', array(
						'before' => '<i class="material-icons">mode_comment</i>',
						'zero'   => '0',
						'one'    => '1',
						'plural' => '%',
					) );

					powder_meta_tags( 'loop', array(
						'before'    => '<i class="material-icons">folder_open</i>',
						'separator' => ', ',
					) );
				?>
			</div><!-- .entry-meta -->

		<?php endif; ?>

	</div>
	<footer class="entry-footer">
		<?php powder_share_buttons( 'loop' ); ?>
		<?php powder_read_more(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
