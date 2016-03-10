<?php
/**
 * Template part for default Header layout.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Jane_Style
 */
?>

<div class="site-branding">
	<?php Jane_Style_header_logo() ?>
	<?php Jane_Style_site_description(); ?>
</div>
<?php Jane_Style_main_menu(); ?>
<div class="block_cart_social">
	<?php Jane_Style_header_cart(); ?>
	<?php Jane_Style_social_list( 'header' ); ?>
</div>