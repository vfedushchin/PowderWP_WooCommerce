<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package jane_style
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php jane_style_get_page_preloader(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'jane_style' ); ?></a>
	<header id="masthead" <?php jane_style_header_class(); ?> role="banner">
		<div class="top-panel">
			<div <?php echo jane_style_get_container_classes( array( 'top-panel__wrap container' ) ); ?>>
				<div class="div_dropdown_top_menu">
					<i class="material-icons material-icons-menu"></i><?php jane_style_top_menu();?>
				</div>
				<?php
				jane_style_top_message( '<div class="top-panel__message">%s</div>' );
				?>
				<div class="search_switcher_block">
					<?php
					jane_style_product_search();
					jane_style_top_currency_switcher();
					jane_style_top_language_selector();
					?>
				</div>
			</div>
		</div><!-- .top-panel -->

		<div class="header-container">
			<div <?php echo jane_style_get_container_classes( array( 'header-container_wrap' ) ); ?>>
				<?php get_template_part( 'template-parts/header/layout', get_theme_mod( 'header_layout_type' ) ); ?>
			</div>
		</div><!-- .header-container -->
	</header><!-- #masthead -->
	<?php do_action( 'jane_style_render_widget_area', 'full-width-header-area' ); ?>
	<div id="content" <?php jane_style_content_class(); ?>>
