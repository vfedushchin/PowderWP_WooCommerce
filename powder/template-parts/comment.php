<footer class="comment-meta">
	<div class="comment-author vcard">
		<?php echo powder_comment_author_avatar(); ?>
	</div>
	<div class="comment-metadata">
		<?php printf( __( '<span class="posted-by">Posted by</span> %s', 'powder' ), powder_get_comment_author_link() ); ?>
		<?php echo powder_get_comment_date( array( 'format' => 'd M, Y' ) ); ?>
	</div>
</footer>
<div class="comment-content">
	<?php echo powder_get_comment_text(); ?>
</div>
<div class="reply">
	<?php echo powder_get_comment_reply_link( array( 'reply_text' => '<i class="material-icons">reply</i>' ) ); ?>
</div>