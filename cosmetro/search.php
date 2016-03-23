<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package __Tm
 */

if ( have_posts() ) : ?>
<div class="blog-default">
	<header class="page-header">
		<h1 class="page-title screen-reader-text"><?php printf( esc_html__( 'Search Results for: %s', 'cosmetro' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	</header><!-- .page-header -->

	<div class="posts-list--default">

	<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post();

		/**
		 * Run the loop for the search to output the results.
		 * If you want to overload this in a child theme then include a file
		 * called content-search.php and that will be used instead.
		 */
		get_template_part( 'template-parts/content' );

	endwhile; ?>

	</div><!-- .posts-list -->
</div>
	<?php get_template_part( 'template-parts/content', 'pagination' );

else :

	get_template_part( 'template-parts/content', 'none' );

endif; ?>