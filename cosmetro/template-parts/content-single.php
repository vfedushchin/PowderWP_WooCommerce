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

	<div class="post-left-column">
		<?php
				cosmetro_meta_categories( 'single', array(
					//'before'    => esc_html__( 'Categories: ', 'cosmetro' ),
			));
		?>


			<div class="post__date">
				<i class="material-icons">access_time</i>
				<span><?php echo esc_html__( 'Published on ', 'cosmetro' ); ?></span>
				<span class="post__date"><?php cosmetro_meta_date( 'single' ); ?> </span>
			</div>

		<div class="post__author vcard">
			<i class="material-icons">person</i>
			<span><?php echo esc_html__( 'By ', 'cosmetro' ); ?></span>
			<?php
					cosmetro_meta_author(
						'single',
						array(
						)
					);
				?>
		</div>

		<!-- this block in "post__tags" div -->
			<?php
				cosmetro_meta_tags( 'single', array(
					'before'    => '<span>Tags:</span>',
					'separator' => ', ',
				) );
			?>

		<?php cosmetro_share_buttons( 'single' ); ?>
	</div>

	<div class="post-right-column">



	<header class="entry-header">
		<?php
			the_title( '<h1 class="entry-title">', '</h1>' );
		?>
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

	</footer><!-- .entry-footer -->


	<?php
		// the_post_navigation();

		cosmetro_post_author_bio();

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
	?>

	</div><!-- .post-right-column -->
</article><!-- #post-## -->



