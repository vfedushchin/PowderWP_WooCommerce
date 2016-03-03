<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package jane_style
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			jane_style_meta_date( 'single'
			// 	, array(
			// 	'before' => '<i class="material-icons">event</i>',
			// )
			 );

			the_title( '<h1 class="entry-title">', '</h1>' );
		?>

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">

				<?php
					jane_style_meta_author(
						'single',
						array(
							'before' => esc_html__( 'Posted by', 'jane_style' ) . ' ',
						)
					);

					jane_style_meta_comments( 'single', array(
						'zero'   => '0',
						'one'    => '1',
						'plural' => '%',
					) );
				?>

			</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->

	<figure class="post-thumbnail">
		<?php jane_style_post_thumbnail( false ); ?>
	</figure><!-- .post-thumbnail -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jane_style' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			jane_style_meta_categories( 'single' );

			jane_style_meta_tags( 'single', array(
				'before'    => '<i class="material-icons">folder_open</i>',
				'separator' => ', ',
			) );
		?>
		<?php jane_style_share_buttons( 'single' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
