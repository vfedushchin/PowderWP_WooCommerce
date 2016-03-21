<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package powder
 */

if ( ! function_exists( 'powder_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 *
 * @since 1.0.0
 */
function powder_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'powder' ) );
		if ( $categories_list && powder_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'powder' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'powder' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'powder' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'powder' ), esc_html__( '1 Comment', 'powder' ), esc_html__( '% Comments', 'powder' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'powder' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @since  1.0.0
 * @return bool
 */
function powder_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'powder_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'powder_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so powder_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so powder_categorized_blog should return false.
		return false;
	}
}

/**
 * Prints site header CSS classes.
 *
 * @since  1.0.0
 * @param  array $classes Additional classes.
 * @return void
 */
function powder_header_class( $classes = array() ) {
	$classes[] = 'site-header';
	$classes[] = get_theme_mod( 'header_layout_type' );
	echo powder_get_container_classes( $classes );
}

/**
 * Prints site content CSS classes.
 *
 * @since  1.0.0
 * @param  array $classes Additional classes.
 * @return void
 */
function powder_content_class( $classes = array() ) {
	$classes[] = 'site-content';
	echo powder_get_container_classes( $classes );
}

/**
 * Prints site footer CSS classes.
 *
 * @since  1.0.0
 * @param  array $classes Additional classes.
 * @return void
 */
function powder_footer_class( $classes = array() ) {
	$classes[] = 'site-footer';
	$classes[] = get_theme_mod( 'footer_layout_type', 'default' );
	echo powder_get_container_classes( $classes );
}

/**
 * Retrieve a CSS class attribute for container based on `Page Layout Type` option.
 *
 * @since  1.0.0
 * @param  array  $classes Additional classes.
 * @return string
 */
function powder_get_container_classes( $classes ) {
	$layout_type = get_theme_mod( 'page_layout_type' );

	if ( 'boxed' == $layout_type ) {
		$classes[] = 'container';
	}

	return 'class="' . join( ' ', $classes ) . '"';
}

/**
 * Prints primary content wrapper CSS classes.
 *
 * @since  1.0.0
 * @param  array $classes Additional classes.
 * @return void
 */
function powder_primary_content_class( $classes = array() ) {
	echo powder_get_layout_classes( 'content', $classes );
}

/**
 * Prints sidebar CSS class.
 *
 * @since  1.0.0
 * @param  array  $classes Additional classes.
 * @return void
 */
function powder_sidebar_class( $classes = array() ) {
	echo powder_get_layout_classes( 'sidebar', $classes );
}

/**
 * Get CSS class attribute for passed layout context.
 *
 * @since  1.0.0
 * @param  string $layout  Layout context.
 * @param  array  $classes Additional classes.
 * @return string
 */
function powder_get_layout_classes( $layout = 'content', $classes = array() ) {
	$sidebar_position = get_theme_mod( 'sidebar_position' );
	$sidebar_width    = get_theme_mod( 'sidebar_width' );

	if ( 'fullwidth' === $sidebar_position || is_singular( 'product' ) ) {
		$sidebar_width = 0;
	}

	if ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) {
		$sidebar_width = '1/4';
	}

	$layout_classes = ! empty( powder_theme()->layout[ $sidebar_position ][ $sidebar_width ][ $layout ] ) ? powder_theme()->layout[ $sidebar_position ][ $sidebar_width ][ $layout ] : array();

	if ( ! empty( $classes ) ) {
		$layout_classes = array_merge( $layout_classes, $classes );
	}

	if ( empty( $layout_classes ) ) {
		return '';
	}

	$layout_classes = apply_filters( "powder_{$layout}_classes", $layout_classes );

	return 'class="' . join( ' ', $layout_classes ) . '"';
}

function powder_posts_list_class( $classes = array(), $echo = true ) {
	$layout_type      = get_theme_mod( 'blog_layout_type', powder_theme()->customizer->get_default( 'blog_layout_type' ) );
	$sidebar_position = get_theme_mod( 'sidebar_position', powder_theme()->customizer->get_default( 'sidebar_position' ) );

	$classes[] = 'posts-list';
	$classes[] = 'posts-list--' . sanitize_html_class( $layout_type );
	$classes[] = sanitize_html_class( $sidebar_position );

	if ( in_array( $layout_type, array( 'grid-2-cols', 'grid-3-cols' ) ) ) {
		$classes[] = 'card-deck';
	}

	if ( in_array( $layout_type, array( 'masonry-2-cols', 'masonry-3-cols' ) ) ) {
		$classes[] = 'card-columns';
	}

	$sidebars = array(
		'full-width-header-area',
		'before-content-area',
		'before-loop-area',
	);

	$has_sidebars = false;

	foreach ( $sidebars as $sidebar ) {
		if ( powder_widget_area()->is_active_sidebar( $sidebar ) ) {
			$has_sidebars = true;
		}
	}

	if ( ! $has_sidebars && is_home() ) {
		$classes[] = 'no-sidebars-before';
	}

	$classes = apply_filters( 'powder_posts_list_class', $classes );

	$output = 'class="' . join( ' ', $classes ) . '"';

	if ( ! $echo ) {
		return $output;
	}

	echo $output;
}

/**
 * Flush out the transients used in powder_categorized_blog.
 */
function powder_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'powder_categories' );
}
add_action( 'edit_category', 'powder_category_transient_flusher' );
add_action( 'save_post',     'powder_category_transient_flusher' );

/**
 * Show top panel message
 *
 * @param  string $format Output formatting.
 * @return void
 */
function powder_top_message( $format = '%s' ) {

	$message = get_theme_mod( 'top_panel_text', powder_theme()->customizer->get_default( 'top_panel_text' ) );

	if ( ! $message ) {
		return;
	}

	printf( $format, wp_kses( $message, wp_kses_allowed_html( 'post' ) ) );

}

/**
 * Show top panel search
 *
 * @param  string $format Output formatting.
 * @return void
 */
function powder_top_search( $format = '%s' ) {

	$is_enabled = get_theme_mod( 'top_panel_search', powder_theme()->customizer->get_default( 'top_panel_search' ) );

	if ( ! $is_enabled ) {
		return;
	}

	printf( $format, get_search_form( false ) );

}


/**
 * Show top Currency Switcher
 *
 * @param  string $format Output formatting.
 * @return void
 */
function powder_top_currency_switcher( $format = '%s' ) {

	$is_enabled = get_theme_mod( 'top_currency_switcher', powder_theme()->customizer->get_default( 'top_currency_switcher' ) );

	if ( ! $is_enabled ) {
		return;
	}

	printf( $format, powder_currency_switcher() );

}

/**
 * Show top Language Selector
 *
 * @param  string $format Output formatting.
 * @return void
 */




function powder_top_language_selector( $format = '%s' ) {
	$is_enabled = get_theme_mod( 'top_language_selector', powder_theme()->customizer->get_default( 'top_language_selector' ) );
	if ( ! $is_enabled ) {
		return;
	}
	printf( $format, do_action('wpml_add_language_selector') );
}

/**
 * Query WooCommerce activation
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		return class_exists( 'woocommerce' ) ? true : false;
	}
}
/**
 * Display Product Search
 * @since  1.0.0
 * @uses  is_woocommerce_activated() check if WooCommerce is activated
 * @return void
 */
if ( ! function_exists( 'powder_product_search' ) ) {
	function powder_product_search() {
		if ( is_woocommerce_activated() ) { ?>
			<div class="site-search">
				<?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
			</div>
		<?php
		}
	}
}
add_action( 'tm_menu_shop_header', 'powder_product_search', 	40 );

/**
 * Display Currency Switcher
 * @since  1.0.0
 * @uses  is_woocommerce_activated() check if WooCommerce is activated
 * @return void
 */
if ( ! function_exists( 'powder_currency_switcher' ) ) {
	function powder_currency_switcher() {
		if ( is_woocommerce_activated() ) { ?>
			<div class="currency_switcher">
				<?php the_widget( 'WOOCS_SELECTOR', 'title=' ); ?>
			</div>
		<?php
		}
	}
}

/**
 * Cart Link
 * Displayed a link to the cart including the number of items present and the cart total
 * @param  array $settings Settings
 * @return array           Settings
 * @since  1.0.0
 */
if ( ! function_exists( 'powder_cart_link' ) ) {
	function powder_cart_link() {
		?>
		<div class="cart-contents">
			<span class="count"><i class="fl-line-icon-set-shopping63"></i><span><?php echo WC()->cart->get_cart_contents_count();?></span></span>
		</div>
		<?php
	}
}

/**
 * Display Header Cart
 * @since  1.0.0
 * @uses  is_woocommerce_activated() check if WooCommerce is activated
 * @return void
 */
if ( ! function_exists( 'powder_header_cart' ) ) {
	function powder_header_cart() {
		if ( is_woocommerce_activated() ) {
			if ( is_cart() ) {
				$class = 'current-menu-item';
			} else {
				$class = '';
			}
		?>
		<ul class="site-header-cart navbar-header-cart menu">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php powder_cart_link(); ?>
			</li>
			<li class="header-cart-dropdown">
				<div class="shopping_cart-dropdown-wrap">
					<h4><?php echo __( 'My Cart', 'powder' ) ?></h4>
					<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
				</div>
			</li>
		</ul>
		<?php
		}
	}
}


/**
 * Show footer logo, uploaded from customizer
 *
 * @return void
 */
function powder_footer_logo() {

	$logo_url = get_theme_mod( 'footer_logo_url' );


	if ( ! $logo_url ) {
		return;
	}

	$url      = esc_url( home_url( '/' ) );
	$alt      = esc_attr( get_bloginfo( 'name' ) );
	$logo_url = esc_url( powder_render_theme_url( $logo_url ) );

	$logo_format = apply_filters(
		'powder_footer_logo_format',
		'<div class="footer-logo"><a href="%2$s" class="footer-logo_link"><img src="%1$s" alt="%3$s" class="footer-logo_img"></a></div>'
	);

	printf( $logo_format, $logo_url, $url, $alt );

}

/**
 * Show footer copyright text.
 *
 * @return void
 */
function powder_footer_copyright() {

	$copyright = get_theme_mod( 'footer_copyright', powder_theme()->customizer->get_default( 'footer_copyright' ) );
	$format    = '<div class="footer-copyright">%s</div>';

	if ( ! empty( $copyright ) ) {
		printf( $format, wp_kses( powder_render_macros( $copyright ), wp_kses_allowed_html( 'post' ) ) );
		return;
	}
}

/**
 * Show footer copyright text.
 *
 * @return void
 */
function powder_footer_text_center() {

	$centerText = get_theme_mod( 'footer_text_center', powder_theme()->customizer->get_default( 'footer_text_center' ) );
	$format    = '<div class="footer-text-center">%s</div>';

	if ( ! empty( $centerText ) ) {
		printf( $format, wp_kses( powder_render_macros( $centerText ), wp_kses_allowed_html( 'post' ) ) );
		return;
	}
}

/**
 * Show main menu.
 *
 * @return void
 */
function powder_main_menu() {
	?>
	<nav id="site-navigation" class="main-navigation" role="navigation">
		<button class="menu-toggle" aria-controls="main-menu" aria-expanded="false"><i class="material-icons">menu</i> Menu</button>
		<?php
			$args = apply_filters( 'powder_main_menu_args', array(
				'theme_location'   => 'main',
				'container'        => '',
				'menu_id'          => 'main-menu rd-navbar-menu',
				'fallback_cb'      => 'powder_set_nav_menu',
				'fallback_message' => __( 'Set main menu', 'powder' ),
			) );

			wp_nav_menu( $args );
		?>
	</nav><!-- #site-navigation -->
	<?php
}

/**
 * Show footer menu.
 *
 * @return void
 */
function powder_footer_menu() { ?>
	<nav id="footer-navigation" class="footer-menu" role="navigation">
	<?php
		$args = apply_filters( 'powder_footer_menu_args', array(
			'theme_location'   => 'footer',
			'container'        => '',
			'menu_id'          => 'footer-menu-items',
			'menu_class'       => 'footer-menu__items inline-list',
			'depth'            => 1,
			'fallback_cb'      => '__return_empty_string',
			'fallback_message' => __( 'Set footer menu', 'powder' ),
		) );

		wp_nav_menu( $args );
	?>
	</nav><!-- #footer-navigation -->
	<?php
}

/**
 * Show Social list.
 *
 * @return void
 */
function powder_social_list( $context = '' ) {
	$visibility_in_header = get_theme_mod( 'header_social_links', powder_theme()->customizer->get_default( 'header_social_links' ) );
	$visibility_in_footer = get_theme_mod( 'footer_social_links', powder_theme()->customizer->get_default( 'footer_social_links' ) );

	if ( ! $visibility_in_header && ( 'header' === $context ) ) {
		return;
	}

	if ( ! $visibility_in_footer && ( 'footer' === $context ) ) {
		return;
	}

	echo powder_get_social_list( $context );

}

/**
 * Get social nav menu
 *
 * @since  1.0.0
 * @return string
 */
function powder_get_social_list( $context = '' ) {

	static $instance = 0;
	$instance++;

	$container_class = array( 'social-list' );

	if ( ! empty( $context ) ) {
		$container_class[] = sprintf( 'social-list--%s', sanitize_html_class( $context ) );
	}

	$args = apply_filters( 'powder_social_list_args', array(
		'theme_location'   => 'social',
		'container'        => 'div',
		'container_class'  => join( ' ', $container_class ),
		'menu_id'          => "social-list-{$instance}",
		'menu_class'       => 'social-list__items inline-list',
		'depth'            => 1,
		'link_before'      => '<span class="screen-reader-text">',
		'link_after'       => '</span>',
		'echo'             => false,
		'fallback_cb'      => 'powder_set_nav_menu',
		'fallback_message' => __( 'Set social menu', 'powder' ),
	) );

	return wp_nav_menu( $args );

}

/**
 * Set fallback callback for nav menu
 *
 * @param  array $args Nav menu arguments.
 * @return void
 */
function powder_set_nav_menu( $args ) {

	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return null;
	}

	$format = '<div class="set-menu %3$s"><a href="%2$s" target="_blank" class="set-menu_link">%1$s</a></div>';
	$label  = $args['fallback_message'];
	$url    = esc_url( admin_url( 'nav-menus.php' ) );

	printf( $format, $label, $url, $args['container_class'] );

}

/**
 * Show read more button
 *
 * @return void
 */
function powder_read_more() {

	$button_text = get_theme_mod( 'blog_read_more_text', powder_theme()->customizer->get_default( 'blog_read_more_text' ) );

	if ( ! $button_text ) {
		return;
	}

	$format = apply_filters( 'powder_read_more_button_format', '<a href="%2$s" class="btn"><span class="btn__text">%1$s</span><span class="btn__icon"></span></a>' );

	printf( $format, wp_kses( $button_text, wp_kses_allowed_html( 'post' ) ), esc_url( get_permalink() ) );

}

/**
 * Show blog post content
 *
 * @return void
 */
function powder_blog_content($length = 25) {

	if ( ! is_singular() && wp_is_mobile() ) {
		return;
	}

	$blog_content = get_theme_mod( 'blog_posts_content', powder_theme()->customizer->get_default( 'blog_posts_content' ) );

	if ( ! in_array( $blog_content, array( 'full', 'excerpt' ) ) ) {
		$blog_content = 'excerpt';
	}

	switch ( $blog_content ) {
		case 'full':
			powder_post_content();
			break;

		case 'excerpt':
			powder_post_excerpt( array( 'length' => $length, 'more' => '&hellip;' ) );
			break;
	}

}

/**
 * Print the post excerpt
 *
 * @return void
 */
function powder_post_excerpt( $args = array() ) {

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
 * Show full post content
 *
 * @return void
 */
function powder_post_content() {

	the_content( sprintf(
		/* translators: %s: Name of current post. */
		wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'powder' ), array( 'span' => array( 'class' => array() ) ) ),
		the_title( '<span class="screen-reader-text">"', '"</span>', false )
	) );

	wp_link_pages( array(
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'powder' ),
		'after'  => '</div>',
	) );

}

/**
 * Show post thumbnail
 *
 * @return void
 */
function powder_post_thumbnail( $linked = false, $sizes = array() ) {

	if ( ! has_post_thumbnail() ) {
		return;
	}

	$sizes = wp_parse_args( $sizes, array(
		'small'     => '_tm-thumb-536-449',
		'fullwidth' => '_tm-post-thumbnail-large',
	) );

	$linked_format = apply_filters(
		'powder_linked_post_thumbnail_format',
		'<a href="%2$s" class="post-thumbnail__link %3$s">%1$s</a>'
	);

	$single_format = apply_filters(
		'powder_single_post_thumbnail_format',
		'%1$s'
	);

	$extra_classes   = array();
	$extra_classes[] = 'post-thumbnail__img';
	$link_class      = 'post-thumbnail--fullwidth';

	$size = apply_filters( 'powder_post_thumbail_size', false );

	if ( false === $size ) {

		if ( ! is_single() ) {
			$size = get_theme_mod(
				'blog_featured_image',
				powder_theme()->customizer->get_default( 'blog_featured_image' )
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
 * Print meta block with post author
 *
 * @since  1.0.0
 * @param  string $context current post context - 'single' or 'loop'.
 * @param  array  $args    arguments array.
 * @return void
 */
function powder_meta_author( $context = 'loop', $args = array() ) {

	if ( 'loop' == $context ) {
		$meta = 'blog_post_author';
	} else {
		$meta = 'single_post_author';
	}

	if ( ! powder_is_meta_visible( $meta, $context ) ) {
		return;
	}

	$args = wp_parse_args( $args, array(
		'container' => 'span',
		'before'    => '',
		'after'     => '',
	) );

	/**
	 * Filter post author output format
	 *
	 * @var string
	 */
	$author_format = apply_filters(
		'powder_meta_author_format',
		'<%1$s class="post-author">%2$s<a class="post-author__link" href="%4$s">%5$s</a>%3$s</%1$s>',
		$context
	);

	printf(
		$author_format,
		esc_attr( $args['container'] ),
		$args['before'],
		$args['after'],
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);

}

/**
 * Prints HTML with meta information for the current post-date/time.
 *
 * @since  1.0.0
 * @param  string $context current post context - 'single' or 'loop'.
 * @param  array  $args    arguments array.
 * @return void
 */
function powder_meta_date( $context = 'loop', $args = array() ) {

	if ( 'loop' == $context ) {
		$meta = 'blog_post_publish_date';
	} else {
		$meta = 'single_post_publish_date';
	}

	if ( ! powder_is_meta_visible( $meta, $context ) ) {
		return;
	}

	$args = wp_parse_args( $args, array(
		'container' => 'span',
		'before'    => '',
		'after'     => '',
	) );

	$time_string = '<time class="post-date__time" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	/**
	 * Filter post date output format
	 *
	 * @var string
	 */
	$date_format = apply_filters(
		'powder_meta_date_format',
		'<%1$s class="post__date">%2$s<a class="post-date__link" href="%4$s">%5$s</a>%3$s</%1$s>',
		$context
	);

	printf(
		$date_format,
		esc_attr( $args['container'] ),
		$args['before'],
		$args['after'],
		esc_url( get_permalink() ),
		$time_string
	);

}

/**
 * Prints HTML with meta information for the current post comments.
 *
 * @since  1.0.0
 * @param  string $context current post context - 'single' or 'loop'.
 * @param  array  $args    arguments array.
 * @return void
 */
function powder_meta_comments( $context = 'loop', $args = array() ) {

	if ( post_password_required() || ! comments_open() ) {
		return;
	}

	if ( 'loop' == $context ) {
		$meta = 'blog_post_comments';
	} else {
		$meta = 'single_post_comments';
	}

	if ( ! powder_is_meta_visible( $meta, $context ) ) {
		return;
	}

	$args = wp_parse_args( $args, array(
		'container' => 'span',
		'before'    => '',
		'after'     => '',
		'zero'      => '',
		'one'       => '',
		'plural'    => '',
	) );

	/**
	 * Filter post comments output format
	 *
	 * @var string
	 */
	$comments_format = apply_filters(
		'powder_meta_comments_format',
		'<%1$s class="post__comments">%2$s%4$s%3$s</%1$s>',
		$context
	);

	ob_start();
	comments_popup_link(
		esc_html( $args['zero'] ), esc_html( $args['one'] ), esc_html( $args['plural'] ), 'post-comments__link'
	);
	$comments_link = ob_get_clean();

	printf(
		$comments_format,
		esc_attr( $args['container'] ),
		$args['before'],
		$args['after'],
		$comments_link
	);

}

/**
 * Prints HTML with meta information for the current post categories.
 *
 * @since  1.0.0
 * @param  string $context current post context - 'single' or 'loop'.
 * @param  array  $args    arguments array.
 * @param  bool   $echo    If true - prints result, if false - return.
 * @return void
 */
function powder_meta_categories( $context = 'loop', $args = array(), $echo = true ) {

	if ( 'loop' == $context ) {
		$meta = 'blog_post_categories';
	} else {
		$meta = 'single_post_categories';
	}

	if ( ! powder_is_meta_visible( $meta, $context ) ) {
		return;
	}

	$args = wp_parse_args( $args, array(
		'container' => 'div',
		'before'    => '',
		'after'     => '',
		'separator' => ' ',
	) );

	/**
	 * Filter post categories output format
	 *
	 * @var string
	 */
	$categories_format = apply_filters(
		'powder_meta_categories_format',
		'<%1$s class="post__cats">%2$s%4$s%3$s</%1$s>',
		$context
	);

	$categories_list = get_the_category_list( $args['separator'] );

	if ( true == $echo ) {
		printf(
			$categories_format,
			esc_attr( $args['container'] ),
			$args['before'],
			$args['after'],
			$categories_list
		);
	} else {
		return sprintf(
			$categories_format,
			esc_attr( $args['container'] ),
			$args['before'],
			$args['after'],
			$categories_list
		);
	}
}

/**
 * Prints HTML with meta information for the current post tags.
 *
 * @since  1.0.0
 * @param  string $context current post context - 'single' or 'loop'.
 * @param  array  $args    arguments array.
 * @return void
 */
function powder_meta_tags( $context = 'loop', $args = array() ) {

	if ( 'loop' == $context ) {
		$meta = 'blog_post_tags';
	} else {
		$meta = 'single_post_tags';
	}

	if ( ! powder_is_meta_visible( $meta, $context ) ) {
		return;
	}

	$args = wp_parse_args( $args, array(
		'container' => 'div',
		'before'    => '',
		'after'     => '',
		'separator' => ' ',
	) );

	/**
	 * Filter post tags output format
	 *
	 * @var string
	 */
	$tags_format = apply_filters(
		'powder_meta_tags_format',
		'<%1$s class="post__tags">%2$s</%1$s>',
		$context
	);

	$tags_list = get_the_tag_list( $args['before'], $args['separator'], $args['after'] );

	if ( empty( $tags_list ) ) {
		return;
	}

	printf(
		$tags_format,
		esc_attr( $args['container'] ),
		$tags_list
	);
}

/**
 * Show sticky menu label grabbed from options
 *
 * @since  1.0.0
 * @return void
 */
function powder_sticky_label() {

	if ( ! is_sticky() || ! is_home() || is_paged() ) {
		return;
	}

	$sticky_label = get_theme_mod( 'blog_sticky_label' );

	if ( empty( $sticky_label ) ) {
		return;
	}

	printf( '<span class="sticky__label">%s</span>', powder_render_icons( $sticky_label ) );
}

/**
 * Check if passed meta data is visible in current context
 *
 * @since  1.0.0
 * @param  string $meta    meta setting to check.
 * @param  string $context current post context - 'single' or 'loop'.
 * @return bool
 */
function powder_is_meta_visible( $meta, $context = 'loop' ) {

	if ( ! $meta ) {
		return false;
	}

	$meta_enabled = get_theme_mod( $meta, powder_theme()->customizer->get_default( $meta ) );

	switch ( $context ) {

		case 'loop':

			if ( ! is_single() && $meta_enabled ) {
				return true;
			} else {
				return false;
			}

		case 'single':

			if ( is_single() && $meta_enabled ) {
				return true;
			} else {
				return false;
			}

	}

	return false;

}

/**
 * Display the header logo.
 *
 * @since  1.0.0
 * @return void
 */
function powder_header_logo() {
	$logo = powder_get_site_title_by_type( get_theme_mod( 'header_logo_type', powder_theme()->customizer->get_default( 'header_logo_type' ) ) );

	if ( is_front_page() && is_home() ) {
		$tag = 'h1';
	} else {
		$tag = 'div';
	}

	$format = apply_filters(
		'powder_header_logo_format',
		'<%1$s class="site-logo"><a class="site-logo__link" href="%2$s" rel="home">%3$s</a></%1$s>'
	);

	printf( $format, $tag, esc_url( home_url( '/' ) ), $logo );
}

/**
 * Retrieve the site title (image or text).
 *
 * @since  1.0.0
 * @return string
 */
function powder_get_site_title_by_type( $type ) {

	if ( ! in_array( $type, array( 'text', 'image' ) ) ) {
		$type = 'text';
	}

	$logo = get_bloginfo( 'name' );

	if ( 'text' === $type ) {
		return $logo;
	}

	$logo_url = get_theme_mod( 'header_logo_url', powder_theme()->customizer->get_default( 'header_logo_url' ) );

	if ( ! $logo_url ) {
		return $logo;
	}

	$logo_url = powder_render_theme_url( $logo_url );

	$retina_logo     = '';
	$retina_logo_url = get_theme_mod( 'retina_header_logo_url' );
	$retina_logo_url = powder_render_theme_url( $retina_logo_url );

	if ( $retina_logo_url ) {
		$retina_logo = sprintf( 'srcset="%s 2x"', esc_url( $retina_logo_url ) );
	}

	$format_image = apply_filters( 'powder_header_logo_image_format',
		'<img src="%1$s" alt="%2$s" class="site-link__img" %3$s>'
	);

	return sprintf( $format_image, esc_url( $logo_url ), esc_attr( $logo ), $retina_logo );
}

/**
 * Display the site description.
 *
 * @since  1.0.0
 * @return void
 */
function powder_site_description() {

	$show_desc = get_theme_mod( 'show_tagline', powder_theme()->customizer->get_default( 'show_tagline' ) );

	if ( ! $show_desc ) {
		return;
	}

	$description = get_bloginfo( 'description', 'display' );

	if ( ! ( $description || is_customize_preview() ) ) {
		return;
	}

	$format = apply_filters( 'powder_site_description_format', '<div class="site-description">%s</div>' );

	printf( $format, $description );
}

/**
 * Dispaply box with information about author
 *
 * @return void
 */
function powder_post_author_bio() {

	$is_enabled = get_theme_mod( 'single_author_block', powder_theme()->customizer->get_default( 'single_author_block' ) );

	if ( ! $is_enabled ) {
		return;
	}

	get_template_part( 'template-parts/content', 'author-bio' );

}

/**
 * Display a link to all posts by an author.
 *
 * @since  1.0.0
 * @param  array $args Arguments.
 * @return string      An HTML link to the author page.
 */
function powder_get_the_author_posts_link() {
	ob_start();
	the_author_posts_link();
	$author = ob_get_clean();

	return $author;
}

/**
 * Display the breadcrumbs.
 *
 * @since  1.0.0
 * @return void
 */
function powder_site_breadcrumbs() {
	$breadcrumbs_visibillity = get_theme_mod( 'breadcrumbs_visibillity', powder_theme()->customizer->get_default( 'breadcrumbs_visibillity' ) );
	$breadcrumbs_page_title = get_theme_mod( 'breadcrumbs_page_title', powder_theme()->customizer->get_default( 'breadcrumbs_page_title' ) );
	$breadcrumbs_path_type = get_theme_mod( 'breadcrumbs_path_type', powder_theme()->customizer->get_default( 'breadcrumbs_path_type' ) );
	$breadcrumbs_front_visibillity = get_theme_mod( 'breadcrumbs_front_visibillity', powder_theme()->customizer->get_default( 'breadcrumbs_front_visibillity' ) );

	$breadcrumbs_settings = apply_filters( 'powder_breadcrumbs_settings', array(
		'wrapper_format'	=> '<div class="container"><div class="breadcrumbs__title">%1$s</div><div class="breadcrumbs__items">%2$s</div><div class="clear"></div></div>',
		'page_title_format'	=> '<h5 class="page-title">%s</h5>',
		'show_title'		=> $breadcrumbs_page_title,
		'path_type'			=> $breadcrumbs_path_type,
		'show_on_front'		=> $breadcrumbs_front_visibillity,
		'labels'			=> array(
			'browse'		=> '',
		),
		'css_namespace' => array(
			'module'	=> 'breadcrumbs',
			'content'	=> 'breadcrumbs__content',
			'wrap'		=> 'breadcrumbs__wrap',
			'browse'	=> 'breadcrumbs__browse',
			'item'		=> 'breadcrumbs__item',
			'separator'	=> 'breadcrumbs__item-sep',
			'link'		=> 'breadcrumbs__item-link',
			'target'	=> 'breadcrumbs__item-target'
		)
	) );

	if ( $breadcrumbs_visibillity ) {
		powder_theme()->get_core()->init_module( 'cherry-breadcrumbs', $breadcrumbs_settings );
		do_action('cherry_breadcrumbs_render');
	}

}

/**
 * Display the site_preloader.
 *
 * @since  1.0.0
 * @return void
 */
function powder_get_page_preloader() {
	$page_preloader = get_theme_mod( 'page_preloader', powder_theme()->customizer->get_default( 'page_preloader' ) );

	if ( $page_preloader ) {
		echo '<div class="page-preloader-cover"><div class="tm-folding-cube">
		<div class="tm-cube1 tm-cube"></div>
		<div class="tm-cube2 tm-cube"></div>
		<div class="tm-cube4 tm-cube"></div>
		<div class="tm-cube3 tm-cube"></div>
	  </div></div>';
	}
}

/**
 * Show top page menu if active
 *
 * @return void
 */
function powder_top_menu() {

	if ( ! has_nav_menu( 'top' ) ) {
		return;
	}

	wp_nav_menu( array(
		'menu_id'         => 'rd-navbar-shop-menu',
		'theme_location'  => 'top',
		'container'       => 'div',
		'container_class' => 'top-panel__menu',
		'menu_class'      => 'top-panel__menu-list',
		'depth'           => 1,
	) );

}

/**
 * Print boxed or fullwidth conainer class
 *
 * @return void
 */
function powder_layout_wrap() {
	$layout = get_theme_mod( 'page_layout_type', powder_theme()->customizer->get_default( 'page_layout_type' ) );
	printf( '%s-wrap', esc_attr( $layout ) );
}

/**
 * Retrieve a share buttons with settings.
 *
 * @since  1.0.0
 * @return array
 */
function powder_share_buttons( $context = 'loop', $args = array(), $config = array() ) {

	if ( 'loop' == $context ) {
		$meta = 'blog_post_share_buttons';
	} else {
		$meta = 'single_post_share_buttons';
	}

	if ( ! powder_is_meta_visible( $meta, $context ) ) {
		return;
	}

	/**
	 * Default social networks.
	 *
	 * @since 1.0.0
	 *
	 * $1%s - `id`
	 * $2%s - `type`
	 * $3%s - `url`
	 * $4%s - `title`
	 * $4%s - `summary`
	 * $6%s - `thumbnail`
	 */
	$defaults = apply_filters( 'powder_default_args_share_buttons', array(
		'facebook' => array(
			'icon'      => 'fa fa-facebook',
			'name'      => esc_html__( 'Facebook', 'powder' ),
			'share_url' => 'https://www.facebook.com/sharer/sharer.php?u=%3$s&t=%4$s',
		),
		'twitter' => array(
			'icon'      => 'fa fa-twitter',
			'name'      => esc_html__( 'Twitter', 'powder' ),
			'share_url' => 'https://twitter.com/intent/tweet?url=%3$s&text=%4$s',
		),
		'google-plus' => array(
			'icon'      => 'fa fa-google-plus',
			'name'      => esc_html__( 'Google+', 'powder' ),
			'share_url' => 'https://plus.google.com/share?url=%3$s',
		),
		'linkedin' => array(
			'icon'      => 'fa fa-linkedin',
			'name'      => esc_html__( 'LinkedIn', 'powder' ),
			'share_url' => 'http://www.linkedin.com/shareArticle?mini=true&url=%3$s&title=%4$s&summary=%5$s&source=%3$s',
		),
		'pinterest' => array(
			'icon'      => 'fa fa-pinterest',
			'name'      => esc_html__( 'Pinterest', 'powder' ),
			'share_url' => 'https://www.pinterest.com/pin/create/button/?url=%3$s&description=%4$s&media=%6$s',
		),
	) );

	$networks = wp_parse_args( $args, $defaults );

	$default_config = apply_filters( 'powder_default_config_share_buttons', array(
		'http'         => is_ssl() ? 'https' : 'http',
		'custom_class' => '',
	) );

	$config = wp_parse_args( $config, $default_config );

	// Prepare a data for sharing.
	$id           = get_the_ID();
	$type         = get_post_type( $id );
	$url          = get_permalink( $id );
	$title        = get_the_title( $id );
	$summary      = get_the_excerpt();
	$thumbnail_id = get_post_thumbnail_id( $id );
	$thumbnail    = '';

	if ( ! empty( $thumbnail_id ) ) {
		$thumbnail = wp_get_attachment_image_src( $thumbnail_id, 'full' );
		$thumbnail = $thumbnail[0];
	}

	$share_item_html = apply_filters( 'powder_share_button_html',
		'<div class="share-btns__item %2$s-item"><a class="share-btns__link" href="%1$s" rel="nofollow" target="_blank" rel="nofollow" title="%3$s"><i class="%4$s"></i><span class="share-btns__label screen-reader-text">%5$s</span></a></div>'
	);
	$share_buttons = '';

	foreach ( (array) $networks as $id => $network ) :

		if ( empty( $network['share_url'] ) ) {
			continue;
		}

		$share_url = sprintf( $network['share_url'],
			esc_attr( $id ),
			esc_attr( $type ),
			esc_url( $url ),
			esc_attr( $title ),
			esc_attr( $summary ),
			esc_url( $thumbnail )
		);

		$share_buttons .= sprintf(
			$share_item_html,
			htmlspecialchars( $share_url ),
			sanitize_html_class( $id ),
			esc_html__( 'Share on ', 'powder' ) . $network['name'],
			esc_attr( $network['icon'] ),
			esc_attr( $network['name'] )
		);

	endforeach;

	printf(
		'<div class="share-btns__list %1$s">%2$s</div>',
		esc_attr( $config['custom_class'] ),
		$share_buttons
	);
}