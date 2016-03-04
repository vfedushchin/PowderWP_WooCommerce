<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package powder
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
<?php powder_get_page_preloader(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'powder' ); ?></a>
	<header id="masthead" <?php powder_header_class(); ?> role="banner">
		<div class="top-panel">
			<div <?php echo powder_get_container_classes( array( 'top-panel__wrap container' ) ); ?>>
				<div class="div_dropdown_top_menu">
					<i class="material-icons material-icons-menu"></i><?php powder_top_menu();?>
				</div>
				<?php
				powder_top_message( '<div class="top-panel__message">%s</div>' );
				?>
				<div class="search_switcher_block">
					<?php
					powder_product_search();
					powder_top_currency_switcher();
					powder_top_language_selector();
					?>
				</div>
			</div>
		</div><!-- .top-panel -->

		<div class="header-container">
			<div <?php echo powder_get_container_classes( array( 'header-container_wrap' ) ); ?>>
				<?php get_template_part( 'template-parts/header/layout', get_theme_mod( 'header_layout_type' ) ); ?>
			</div>
		</div><!-- .header-container -->
	</header><!-- #masthead -->
	<?php do_action( 'powder_render_widget_area', 'full-width-header-area' ); ?>
	<div id="content" <?php powder_content_class(); ?>>
