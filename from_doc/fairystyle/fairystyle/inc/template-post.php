<?php
/**
 * Post Template Functions.
 *
 * @package __Tm
 */

/**
 * Show blog post content.
 *
 * @return void
 */
function fairy_style_blog_content() {

	if ( ! is_singular() && wp_is_mobile() ) {
		return;
	}

	$blog_content = get_theme_mod( 'blog_posts_content', fairy_style_theme()->customizer->get_default( 'blog_posts_content' ) );

	if ( ! in_array( $blog_content, array( 'full', 'excerpt' ) ) ) {
		$blog_content = 'excerpt';
	}

	switch ( $blog_content ) {
		case 'full':
			fairy_style_post_content();
			break;

		case 'excerpt':
			fairy_style_post_excerpt( array( 'length' => 45, 'more' => '&hellip;' ) );
			break;
	}

}

/**
 * Print the post excerpt.
 *
 * @return void
 */
function fairy_style_post_excerpt( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'length' => 55,
		'more'   => '',
	) );

	if ( has_excerpt() ) {
		the_excerpt();
	} else {
		/* wp_trim_excerpt analog */
		$content = strip_shortcodes( get_the_content( '' ) );
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		$content = wp_trim_words( $content, $args['length'], $args['more'] );

		echo $content;
	}
}

/**
 * Show full post content.
 *
 * @return void
 */
function fairy_style_post_content() {

	the_content( sprintf(
		/* translators: %s: Name of current post. */
		wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'fairy_style' ), array( 'span' => array( 'class' => array() ) ) ),
		the_title( '<span class="screen-reader-text">"', '"</span>', false )
	) );

	wp_link_pages( array(
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fairy_style' ),
		'after'  => '</div>',
	) );

}

/**
 * Show post thumbnail.
 *
 * @return void
 */
function fairy_style_post_thumbnail( $linked = false, $sizes = array() ) {

	if ( ! has_post_thumbnail() ) {
		return;
	}

	$sizes = wp_parse_args( $sizes, array(
		'small'     => 'post-thumbnail',
		'fullwidth' => 'fairy_style-post-thumbnail-large',
	) );

	$linked_format = apply_filters(
		'fairy_style_linked_post_thumbnail_format',
		'<a href="%2$s" class="post-thumbnail__link %3$s">%1$s</a>'
	);

	$single_format = apply_filters(
		'fairy_style_single_post_thumbnail_format',
		'%1$s'
	);

	$extra_classes   = array();
	$extra_classes[] = 'post-thumbnail__img';
	$link_class      = 'post-thumbnail--fullwidth';

	$size = apply_filters( 'fairy_style_post_thumbail_size', false );

	if ( false === $size ) {

		if ( ! is_single() ) {
			$size = get_theme_mod(
				'blog_featured_image',
				fairy_style_theme()->customizer->get_default( 'blog_featured_image' )
			);
		} else {
			$size = 'fullwidth';
		}

		$link_class = sanitize_html_class( 'post-thumbnail--' . $size );
		$size       = isset( $sizes[ $size ] ) ? esc_attr( $sizes[ $size ] ) : 'post-thumbnail';
	}

	$format = ( true === $linked ) ? $linked_format : $single_format;

	printf( $format,
		get_the_post_thumbnail( get_the_id(), $size, array( 'class' => join( ' ', $extra_classes ) ) ),
		get_permalink(),
		$link_class
	);

}

/**
 * Show read more button.
 *
 * @return void
 */
function fairy_style_read_more() {
	$button_text = get_theme_mod( 'blog_read_more_text', fairy_style_theme()->customizer->get_default( 'blog_read_more_text' ) );

	if ( ! $button_text ) {
		return;
	}

	$format = apply_filters( 'fairy_style_read_more_button_format', '<a href="%2$s" class="btn"><span class="btn__text">%1$s</span><span class="btn__icon"></span></a>' );

	printf( $format, wp_kses( $button_text, wp_kses_allowed_html( 'post' ) ), esc_url( get_permalink() ) );
}
