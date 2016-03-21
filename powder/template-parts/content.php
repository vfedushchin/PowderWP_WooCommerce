<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package powder
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'posts-list__item card hentry' ); ?>>
	<div class="post-list__item-content">



		<figure class="post-thumbnail">
			<?php powder_post_thumbnail( true ); ?>
			<?php powder_sticky_label(); ?>
		</figure><!-- .post-thumbnail -->

		<div class="post-body">

			<header class="entry-header">
				<?php
					powder_meta_categories( 'loop', array(
						'separator' => ',',
					) );
				?>

				<?php
					if ( is_single() ) {
						the_title( '<h1 class="entry-title">', '</h1>' );
					} else {
						the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
					}
				?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php powder_blog_content(110); ?>
			</div><!-- .entry-content -->


			<footer class="entry-footer">

				<?php
					powder_meta_date( 'loop', array(
						'before' => ' <i class="material-icons">access_time</i><span>' . esc_html__( 'Published on', 'powder' ) . '</span> ',
						'after' => '',
					) );
				?>

				<?php
					powder_meta_author(
						'loop',
						array(
							'before' => '<i class="material-icons">person</i>' . esc_html__( 'By', 'powder' ) . ' ',
							'after' => '',
						)
					);
				?>

				<?php if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php
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

				<?php powder_read_more(); ?>
				<?php powder_share_buttons( 'loop' ); ?>
			</footer><!-- .entry-footer -->




		</div>







	</div>

</article><!-- #post-## -->
