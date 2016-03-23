<?php
/**
 * Template part to display Custom Post widget.
 *
 * @package __Tm
 * @subpackage widgets
 */
?>

<div class="post <?php echo $grid_class; ?>">
	<div class="post-inner">
		<div class="post-image">
			<?php echo $image; ?>
		</div>
		<div class="post-content">
			<?php echo $author; ?>
			<?php echo $title; ?>
			<div class="meta">
				<?php echo $date; ?>
				<?php echo $count; ?>
			</div>
			<?php echo $excerpt; ?>
			<?php echo $category; ?>
			<?php echo $tag; ?>
			<?php echo $button; ?>
		</div>
	</div>
</div>