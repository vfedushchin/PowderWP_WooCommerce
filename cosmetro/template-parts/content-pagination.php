<?php
/**
 * Template part for posts pagination.
 *
 * @package cosmetro
 */
the_posts_pagination(
	array(
		'prev_text' => '<i class="material-icons">navigate_before</i>' . __( 'Prev', 'cosmetro' ),
    'next_text' => __( 'Next', 'cosmetro' ) . '<i class="material-icons">navigate_next</i>'
	)
);
