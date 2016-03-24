<?php
/**
 * Template part to display Carousel widget.
 *
 * @package __Tm
 * @subpackage widgets
 */
?>

<div class="inner">
	<div class="content-wrapper">
		<header class="entry-header">
			<?php echo $image; ?>
		</header>
		<div class="entry-content">
			<?php cosmetro_meta_categories( 'loop' ); ?>
			<?php echo $title; ?>
			<?php echo $content; ?>

			<div class="entry-meta">

				<div class="post__date">
					<i class="material-icons">access_time</i>
					<span><?php echo esc_html__( 'Published on ', 'cosmetro' ); ?></span>
					<span class="post__date"><?php /*echo $date;*/ cosmetro_meta_date( 'loop' ); ?> </span>
				</div>

				<div class="post__author vcard">
					<i class="material-icons">person</i>
					<span><?php echo esc_html__( 'By ', 'cosmetro' ); ?></span>
					<?php echo $author; ?>
				</div>
				<!-- <span class="post__comments"><?php echo $comments; ?></span> -->



			</div>

		</div>
	</div>
	<footer class="entry-footer">
		<?php echo $more_button; ?>
		<?php cosmetro_share_buttons( 'loop' ); ?>
	</footer>
</div>

