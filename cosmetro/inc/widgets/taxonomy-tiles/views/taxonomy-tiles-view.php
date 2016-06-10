<?php
/**
 * Template part to display Taxonomy Tiles widget.
 *
 * @package __Tm
 * @subpackage widgets
 */
?>

<div class="widget-taxonomy-tiles__holder invert grid-item <?php echo $class; ?>">
	<figure class="widget-taxonomy-tiles__inner" <?php echo $inline_style; ?>>
		<a href="<?php echo $permalink; ?>" title="<?php echo $title; ?>"><?php echo $image; ?></a>
		<figcaption class="widget-taxonomy-tiles__content">
			<h2 class="widget-taxonomy-tiles__title">
				<a href="<?php echo $permalink; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
			</h2>
			<?php echo $description; ?>
			<?php echo $count; ?>
		</figcaption>
	</figure>
</div>