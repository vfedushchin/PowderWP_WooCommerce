<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package jane_style
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'posts-list__item card' ); ?>>

	<div class="post-list__item-content">
	<div class="post-format-wrap">
		<?php do_action( 'cherry_post_format_image' ); ?>
		<?php jane_style_meta_categories( 'loop' ); ?>
		<?php jane_style_sticky_label(); ?>
	</div>

	<header class="entry-header">
		<?php
			jane_style_meta_author(
				'loop',
				array(
					'before' => esc_html__( 'Posted by', 'jane_style' ) . ' ',
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
		<?php jane_style_blog_content(); ?>
	</div><!-- .entry-content -->

	<?php if ( 'post' === get_post_type() ) : ?>

		<div class="entry-meta">
			<?php
				jane_style_meta_date( 'loop', array(
					'before' => '<i class="material-icons">event</i>',
				) );

				jane_style_meta_comments( 'loop', array(
					'before' => '<i class="material-icons">mode_comment</i>',
					'zero'   => '0',
					'one'    => '1',
					'plural' => '%',
				) );

				jane_style_meta_tags( 'loop', array(
					'before'    => '<i class="material-icons">folder_open</i>',
					'separator' => ', ',
				) );
			?>
		</div><!-- .entry-meta -->

	<?php endif; ?>
	</div>
	<footer class="entry-footer">
		<?php jane_style_share_buttons( 'loop' ); ?>
		<?php jane_style_read_more(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
