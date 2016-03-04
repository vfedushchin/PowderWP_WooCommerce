<?php
/**
 * Template part for default Header layout.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Powder
 */
?>

<div class="site-branding">
	<?php Powder_header_logo() ?>
	<?php Powder_site_description(); ?>
</div>
<?php Powder_main_menu(); ?>
<div class="block_cart_social">
	<?php Powder_header_cart(); ?>
	<?php Powder_social_list( 'header' ); ?>
</div>