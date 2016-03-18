<?php
/**
 * Template part for minimal Header layout.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package __Tm
 */
?>

<div class="site-branding">
	<?php fairy_style_header_logo() ?>
	<?php fairy_style_site_description(); ?>
</div>
<?php fairy_style_header_cart(); ?>
<?php fairy_style_social_list( 'header' ); ?>
<?php fairy_style_main_menu(); ?>
