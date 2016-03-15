<?php
/**
 * Template part to display follow list in Subscribe and Follow widget
 *
 * @package powder/widgets
 */
?>
<div class="follow-block"><?php

	echo $this->get_social_nav();
  echo $this->get_block_title( 'follow' );
  echo $this->get_block_message( 'follow' );

?></div>