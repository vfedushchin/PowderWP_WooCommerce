<?php
/**
 * Template part for top panel in header.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package __Tm
 */

// Don't show top panel if all elements are disabled
if ( ! cosmetro_is_top_panel_visible() ) {
	return;
} ?>

<div class="top-panel">
    <div <?php echo cosmetro_get_container_classes( array( 'top-panel__wrap container' ) ); ?>>

        <?php cosmetro_top_message( '<div class="top-panel__message">%s</div>' ); ?>
        <div class="div_dropdown_top_menu">
            <?php cosmetro_top_menu();?>
        </div>
        <div class="search_switcher_block">
            <?php
            // cosmetro_product_search();
            cosmetro_top_search();
            ?>
        </div>
    </div>
</div><!-- .top-panel -->