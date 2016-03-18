<?php
/**
 * Theme hooks.
 *
 * @package __Tm
 */

// Menu description
add_filter( 'walker_nav_menu_start_el', 'fairy_style_nav_menu_description', 10, 4 );

// Rewrite thumbnail size for non-deafult blog formats
add_filter( 'fairy_style_post_thumbail_size', 'fairy_style_set_thumb_sizes' );

// Sidebars classes.
add_filter( 'fairy_style_widget_area_classes', 'fairy_style_set_sidebar_classes', 10, 2 );

// Add row to footer area classes
add_filter( 'fairy_style_widget_area_classes', 'fairy_style_add_footer_widgets_wrapper_classes', 10, 2 );

// Set footer columns
add_filter( 'dynamic_sidebar_params', 'fairy_style_get_footer_widget_layout' );

// Adapt default image post format classes to current theme
add_filter( 'cherry_post_formats_image_css_model', 'fairy_style_add_image_format_classes', 10, 2 );

// Enqueue sticky menu if required
add_filter( 'fairy_style_theme_script_depends', 'fairy_style_enqueue_misc' );

// Add has/no thumbnail classes for posts
add_filter( 'post_class', 'fairy_style_post_thumb_classes' );

// Modify a comment form.
add_filter( 'comment_form_defaults', 'fairy_style_modify_comment_form' );

// Additional body classes
add_filter( 'body_class', 'fairy_style_extra_body_classes' );

// Render macros in text widgets
add_filter( 'widget_text', 'fairy_style_render_widget_macros' );

// Adds the meta viewport to the header.
add_action( 'wp_head', 'fairy_style_meta_viewport', 0 );

/**
 * Append description into nav items
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string
 */
function fairy_style_nav_menu_description( $item_output, $item, $depth, $args ) {

	if ( 'main' !== $args->theme_location || ! $item->description ) {
		return $item_output;
	}

	$descr_enabled = get_theme_mod(
		'header_menu_attributes',
		fairy_style_theme()->customizer->get_default( 'header_menu_attributes' )
	);

	if ( ! $descr_enabled ) {
		return $item_output;
	}

	$current     = $args->link_after . '</a>';
	$description = '<div class="menu-item_description">' . $item->description . '</div>';
	$item_output = str_replace( $current, $description . $current, $item_output );

	return $item_output;

}

/**
 * Rewrite thumbnail size for non-deafult blog template
 *
 * @param  bool|string $size Default size.
 * @return string
 */
function fairy_style_set_thumb_sizes( $size ) {

	if ( is_single() ) {
		return $size;
	}

	$layout = get_theme_mod( 'blog_layout_type', fairy_style_theme()->customizer->get_default( 'blog_layout_type' ) );

	if ( 'default' === $layout && ! ( is_sticky() && is_home() && ! is_paged() ) ) {
		return $size;
	}

	if ( 'default' !== $layout && ! ( is_sticky() && is_home() && ! is_paged() ) ) {
		return 'post-thumbnail';
	}

	return 'fairy_style-post-thumbnail-large';
}

/**
 * Set layout classes for sidebars.
 *
 * @since  1.0.0
 * @uses   fairy_style_get_layout_classes.
 * @param  array  $classes Additional classes.
 * @param  string $area_id Sidebar ID.
 * @return array
 */
function fairy_style_set_sidebar_classes( $classes, $area_id ) {

	if ( ! in_array( $area_id, array( 'sidebar-primary' , 'sidebar-secondary' ) ) ) {
		return $classes;
	}

	return fairy_style_get_layout_classes( 'sidebar', $classes );
}

/**
 * Set layout classes for sidebars.
 *
 * @since  1.0.0
 * @param  array  $classes Additional classes.
 * @param  string $area_id Sidebar ID.
 * @return array
 */
function fairy_style_add_footer_widgets_wrapper_classes( $classes, $area_id ) {

	if ( 'footer-area' !== $area_id ) {
		return $classes;
	}

	$classes[] = 'row';

	return $classes;
}


/**
 * Get footer widgets layout class
 *
 * @since  1.0.0
 * @param  string $params Existing widget classes.
 * @return string
 */
function fairy_style_get_footer_widget_layout( $params ) {

	if ( empty( $params[0]['id'] ) || 'footer-area' !== $params[0]['id'] ) {
		return $params;
	}

	if ( empty( $params[0]['before_widget'] ) ) {
		return $params;
	}

	$columns = get_theme_mod(
		'footer_widget_columns',
		fairy_style_theme()->customizer->get_default( 'footer_widget_columns' )
	);

	$columns = intval( $columns );
	$classes = 'class="col-xs-12 col-sm-%2$s col-md-%1$s %3$s ';

	switch ( $columns ) {
		case 4:
			$md_col = 3;
			$sm_col = 6;
			$extra  = '';
			break;

		case 3:
			$md_col = 4;
			$sm_col = 4;
			$extra  = '';
			break;

		case 2:
			$md_col = 6;
			$sm_col = 6;
			$extra  = '';
			break;

		default:
			$md_col = 12;
			$sm_col = 12;
			$extra  = 'footer-area--centered';
			break;
	}

	$params[0]['before_widget'] = str_replace(
		'class="',
		sprintf( $classes, $md_col, $sm_col, $extra ),
		$params[0]['before_widget']
	);

	return $params;
}

/**
 * Filter image CSS model
 *
 * @param  array $css_model Default CSS model.
 * @param  array $args      Post formats module arguments.
 * @return array
 */
function fairy_style_add_image_format_classes( $css_model, $args ) {
	$css_model['link'] .= ' post-thumbnail--fullwidth';
	return $css_model;
}

/**
 * Add jQuery Stickup to theme script dependencies if required.
 *
 * @param  array $depends Default dependencies.
 * @return array
 */
function fairy_style_enqueue_misc( $depends ) {

	$header_menu_sticky = get_theme_mod( 'header_menu_sticky', fairy_style_theme()->customizer->get_default( 'header_menu_sticky' ) );

	if ( $header_menu_sticky && ! wp_is_mobile() ) {
		$depends[] = 'jquery-stickup';
	}

	$totop_visibility = get_theme_mod( 'totop_visibility', fairy_style_theme()->customizer->get_default( 'totop_visibility' ) );

	if ( $totop_visibility ) {
		$depends[] = 'jquery-totop';
	}

	return $depends;

}

/**
 * Add has/no thumbnail classes for posts
 *
 * @param  array $classes Existing classes.
 * @return array
 */
function fairy_style_post_thumb_classes( $classes ) {

	$thumb = 'no-thumb';

	if ( has_post_thumbnail() ) {
		$thumb = 'has-thumb';
	}

	$classes[] = $thumb;

	return $classes;
}

/**
 * Add placeholder attributes for comment form fields.
 *
 * @param  array $args Argumnts for comment form.
 * @return array
 */
function fairy_style_modify_comment_form( $args ) {
	$args = wp_parse_args( $args );

	if ( ! isset( $args['format'] ) ) {
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
	}

	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );
	$html_req  = ( $req ? " required='required'" : '' );
	$html5     = 'html5' === $args['format'];
	$commenter = wp_get_current_commenter();

	$args['label_submit'] = esc_html__( 'Submit Comment', 'fairy_style' );

	$args['fields']['author'] = '<p class="comment-form-author"><input id="author" class="comment-form__field" name="author" type="text" placeholder="' . esc_html__( 'Your name', 'fairy_style' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' /></p>';

	$args['fields']['email'] = '<p class="comment-form-email"><input id="email" class="comment-form__field" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' placeholder="' . esc_html__( 'Your e-mail', 'fairy_style' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p>';

	$args['fields']['url'] = '<p class="comment-form-url"><input id="url" class="comment-form__field" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' placeholder="' . esc_html__( 'Your website', 'fairy_style' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';

	$args['comment_field'] = '<p class="comment-form-comment"><textarea id="comment" class="comment-form__field" name="comment" placeholder="' . esc_html__( 'Comments *', 'fairy_style' ) . '" cols="45" rows="8" aria-required="true" required="required"></textarea></p>';

	return $args;
}

/**
 * Add extra body classes
 *
 * @param  array $classes Existing classes.
 * @return array
 */
function fairy_style_extra_body_classes( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a options-based classes.
	$layout      = get_theme_mod( 'page_layout_type', fairy_style_theme()->customizer->get_default( 'page_layout_type' ) );
	$blog_layout = get_theme_mod( 'blog_layout_type', fairy_style_theme()->customizer->get_default( 'blog_layout_type' ) );
	$sb_position = get_theme_mod( 'sidebar_position', fairy_style_theme()->customizer->get_default( 'sidebar_position' ) );
	$sidebar     = get_theme_mod( 'sidebar_width', fairy_style_theme()->customizer->get_default( 'sidebar_width' ) );

	return array_merge( $classes, array(
		'layout-' . $layout,
		'blog-' . $blog_layout,
		'position-' . $sb_position,
		'sidebar-' . str_replace( '/', '-', $sidebar ),
	) );

}

/**
 * Replace macroses in text widget
 *
 * @param  string $text Default text.
 * @return string
 */
function fairy_style_render_widget_macros( $text ) {

	$uploads = wp_upload_dir();

	$data = array(
		'/%%uploads_url%%/' => $uploads['baseurl'],
		'/%%home_url%%/'    => home_url(),
		'/%%theme_url%%/'   => get_stylesheet_directory_uri(),
	);

	return preg_replace( array_keys( $data ), array_values( $data ), $text );
}

/**
 * Adds the meta viewport to the header.
 *
 * @since  1.0.1
 * @return string `<meta>` tag for viewport.
 */
function fairy_style_meta_viewport() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";
}
