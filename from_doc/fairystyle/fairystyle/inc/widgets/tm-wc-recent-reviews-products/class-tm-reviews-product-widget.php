<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Recent Reviews Widget.
 *
 * @author   WooThemes
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.3.0
 * @extends  WC_Widget
 */

/*Extend widget Woocommerce Recent Reviews*/

class Fairy_Style_WC_Widget_Recent_Reviews extends WC_Widget_Recent_Reviews {
		/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	 public function widget( $args, $instance ) {
		global $comments, $comment;

		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		$number   = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
		$comments = get_comments( array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish', 'post_type' => 'product' ) );

		if ( $comments ) {
			$this->widget_start( $args, $instance );

			echo '<ul class="product_list_widget row">';

			foreach ( (array) $comments as $comment ) {

				$_product = wc_get_product( $comment->comment_post_ID );

				$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

				$rating_html = $_product->get_rating_html( $rating );

				echo '<li class="col-md-6 col-sm-12 col-xl-4"><a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">';

				echo $_product->get_image() . '</a>';

				printf( '<em class="reviewer">' . _x( 'by <span>%1$s</span>', 'by comment author', 'woocommerce' ) . '</em>', get_comment_author() );

				echo '<a class="widget_title_product" href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">' . $_product->get_title() . '</a>';

				echo $rating_html;

				echo '</li>';
			}

			echo '</ul>';

			$this->widget_end( $args );
		}

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}
