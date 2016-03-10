<footer class="comment-meta">
	<div class="comment-author vcard">
		<?php echo jane_style_comment_author_avatar(); ?>
	</div>
	<div class="comment-metadata">
		<?php printf( __( '<span class="posted-by">Posted by</span> %s', 'jane_style' ), jane_style_get_comment_author_link() ); ?>
		<?php echo jane_style_get_comment_date( array( 'format' => 'd M, Y' ) ); ?>
	</div>
</footer>
<div class="comment-content">
	<?php echo jane_style_get_comment_text(); ?>
</div>
<div class="reply">
	<?php echo jane_style_get_comment_reply_link( array( 'reply_text' => '<i class="material-icons">reply</i>' ) ); ?>
</div>