<?php
/**
 * Template part for centered Header layout.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Powder
 */
?>

<?php Powder_header_cart(); ?>

<div class="site-branding">
	<?php Powder_header_logo() ?>
	<?php Powder_site_description(); ?>
</div>

<?php Powder_main_menu(); ?>
