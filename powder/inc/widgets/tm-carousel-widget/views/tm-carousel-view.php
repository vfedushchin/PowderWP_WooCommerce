<div class="inner">
	<div class="content-wrapper">
		<header class="entry-header">
			<?php echo $image; ?>
			<div class="post__cats"><?php echo $terms_line; ?></div>
		</header>
		<div class="entry-content">
			<?php powder_meta_categories( 'loop' ); ?>
			<?php echo $title; ?>
			<?php echo $content; ?>

			<div class="entry-meta">

				<div class="post__author vcard">
					<i class="material-icons">person</i>
					<span><?php echo esc_html__( 'By ', 'powder' ); ?></span>
					<?php echo $author; ?>
				</div>
				<!-- <span class="post__comments"><?php echo $comments; ?></span> -->

				<div class="post__date">
					<i class="material-icons">access_time</i>
					<span><?php echo esc_html__( 'Published on ', 'powder' ); ?></span>
					<span class="post__date"><?php /*echo $date;*/ powder_meta_date( 'loop' ); ?> </span>
				</div>

			</div>

		</div>
	</div>
	<footer class="entry-footer">
		<?php powder_share_buttons( 'loop' ); ?>
		<?php echo $more_button; ?>
	</footer>
</div>