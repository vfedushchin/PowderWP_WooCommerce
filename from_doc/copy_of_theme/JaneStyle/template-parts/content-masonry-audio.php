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

		<?php jane_style_meta_date( 'loop' ); ?>

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
						jane_style_meta_author(
							'loop',
							array(
								'before' => esc_html__( 'Posted by', 'jane_style' ) . ' ',
							)
						);
					?>

					<?php
						jane_style_meta_comments( 'loop', array(
							'zero'   => '0' . esc_html__( ' Comment', 'jane_style' ),
							'one'    => '1' . esc_html__( ' Comment', 'jane_style' ),
							'plural' => '%' . esc_html__( ' Comments', 'jane_style' ),
						) );
					?>

				</div><!-- .entry-meta -->

			<?php endif; ?>

		</header><!-- .entry-header -->

		<div class="post-featured-content invert">
			<?php jane_style_sticky_label(); ?>
			<?php do_action( 'cherry_post_format_audio' ); ?>
		</div><!-- .post-featured-content -->

		<div class="entry-content">
			<?php

				$embed_args = array(
					'fields' => array( 'soundcloud' ),
					'height' => 310,
					'width'  => 310,
				);
				$embed_content = apply_filters( 'cherry_get_embed_post_formats', false, $embed_args );

				if ( false === $embed_content ) {
					jane_style_blog_content();
				} else {
					printf( '<div class="embed-wrapper">%s</div>', $embed_content );
				}
			?>
		</div><!-- .entry-content -->

	</div>
	<footer class="entry-footer">
		<?php
			jane_style_meta_categories( 'loop', array(
				'before'    => esc_html__( 'Categories: ', 'jane_style' ),
			));

			jane_style_meta_tags( 'loop' );
		?>
		<?php jane_style_read_more(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
