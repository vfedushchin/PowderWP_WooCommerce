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
	<?php cosmetro_header_logo() ?>
	<?php cosmetro_site_description(); ?>
</div>
<?php cosmetro_header_cart(); ?>
<?php cosmetro_social_list( 'header' ); ?>
<?php cosmetro_main_menu(); ?>

<?php cosmetro_top_currency_switcher(); ?>
<?php cosmetro_top_language_selector(); ?>
