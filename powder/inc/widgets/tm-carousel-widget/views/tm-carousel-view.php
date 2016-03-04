<div class="inner">
	<div class="content-wrapper">
		<header class="entry-header">
			<span class="post__date"><?php echo $date; ?></span>
			<?php echo $image; ?>
			<div class="post__cats"><?php echo $terms_line; ?></div>
		</header>
		<div class="entry-content">
			<?php echo $title; ?>
			<div class="entry-meta">
			<div class="post__author vcard"><span><?php echo esc_html__( 'Posted by ', 'powder' ); ?></span><?php echo $author; ?></div>
				<span class="post__comments"><?php echo $comments; ?></span>
			</div>
			<?php echo $content; ?>
		</div>
	</div>
	<footer class="entry-footer">
		<?php echo $more_button; ?>
	</footer>
</div>