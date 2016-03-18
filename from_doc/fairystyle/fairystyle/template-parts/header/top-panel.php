<?php
/**
 * Template part for top panel in header.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package __Tm
 */

// Don't show top panel if all elements are disabled
if ( ! fairy_style_is_top_panel_visible() ) {
	return;
} ?>

<div class="top-panel">
    <div <?php echo fairy_style_get_container_classes( array( 'top-panel__wrap container' ) ); ?>>
        <?php fairy_style_top_menu();?>
        <?php fairy_style_top_message( '<div class="top-panel__message">%s</div>' ); ?>
        <div class="search_switcher_block">
            <?php
            // fairy_style_product_search();
            fairy_style_top_search();
            fairy_style_top_currency_switcher();
            fairy_style_top_language_selector();
            ?>
        </div>
    </div>
</div><!-- .top-panel -->