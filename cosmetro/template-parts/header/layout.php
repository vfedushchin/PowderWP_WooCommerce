<?php
/**
 * Template part for default Header layout.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package __Tm
 */
?>

<?php cosmetro_social_list( 'header' ); ?>
<div class="site-branding">
    <?php cosmetro_header_logo() ?>
    <?php cosmetro_site_description(); ?>
</div>

<div class="site-shop-elements">
  <?php cosmetro_top_currency_switcher(); ?>
  <?php cosmetro_top_language_selector(); ?>
  <?php cosmetro_header_cart(); ?>
</div>

<?php cosmetro_main_menu(); ?>
