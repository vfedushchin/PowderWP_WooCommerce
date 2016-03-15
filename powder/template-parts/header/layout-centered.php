<?php
/**
 * Template part for centered Header layout.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Powder
 */
?>

<?php Powder_social_list( 'header' ); ?>

<div class="site-branding">
  <?php Powder_header_logo() ?>
  <?php Powder_site_description(); ?>
</div>

<div class="site-shop-elements">
  <?php
    powder_top_currency_switcher();
    powder_top_language_selector();
    Powder_header_cart();
  ?>
</div>



<?php Powder_main_menu(); ?>


