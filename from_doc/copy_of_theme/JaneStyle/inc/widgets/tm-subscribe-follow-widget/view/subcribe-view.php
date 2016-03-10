<?php
/**
 * Template part to display subscribe form
 *
 * @package jane_style/widgets
 */
?>
<div class="subscribe-block">

	<?php echo $this->get_block_title( 'subscribe' ); ?>
	<?php echo $this->get_block_message( 'subscribe' ); ?>

	<form method="POST" action="" class="subscribe-block__form"><?php
		wp_nonce_field( 'jane_style_subscribe', 'jane_style_subscribe' );
	?><div class="subscribe-block__input-group"><?php
		echo $this->get_subscribe_input();
		$btn = 'btn';
		if ( 'footer-area' === $this->args['id'] ) {
			$btn .= ' btn-secondary';
		}
		echo $this->get_subscribe_submit( $btn );
	?></div><?php
		echo $this->get_subscribe_messages();
	?></form>
</div>