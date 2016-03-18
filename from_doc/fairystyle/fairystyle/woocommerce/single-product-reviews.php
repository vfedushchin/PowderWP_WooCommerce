<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews">
	<div id="comments">
		<h4><?php
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) )
				printf( _n( '%s review for %s', '%s reviews for %s', $count, 'fairy_style' ), $count, get_the_title() );
			else
				_e( 'Reviews', 'fairy_style' );
		?></h4>

		<?php if ( have_comments() ) : ?>

			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php _e( 'There are no reviews yet.', 'fairy_style' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>

		<div id="review_form_wrapper" class="row">
			<div id="review_form" class="col-lg-6">
				<?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply_before'   => '<h4 id="reply-title" class="comment-reply-title">',
						'title_reply_after'   => '</h4>',
						'title_reply'          => have_comments() ? __( 'Add a review', 'fairy_style' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'fairy_style' ), get_the_title() ),
						'title_reply_to'       => __( 'Add a review to %s', 'fairy_style' ),
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Your Name:', 'fairy_style' ) . ' <span class="required">*</span></label> ' .
							            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
							'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Your Email:', 'fairy_style' ) . ' <span class="required">*</span></label> ' .
							            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
						),
						'label_submit'  => __( 'Submit', 'fairy_style' ),
						'logged_in_as'  => '',
						'comment_field' => ''
					);

					if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
						$comment_form['must_log_in'] = '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'fairy_style' ), esc_url( $account_page_url ) ) . '</p>';
					}

					$comment_form['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s button">%4$s</button>';

					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$rating = '<p class="comment-form-rating"><span class="for_rating">' . __( 'Your Rating:', 'fairy_style' ) .'</span>
						<select name="rating" id="rating">
							<option value="">' . __( 'Rate&hellip;', 'fairy_style' ) . '</option>
							<option value="5">' . __( 'Perfect', 'fairy_style' ) . '</option>
							<option value="4">' . __( 'Good', 'fairy_style' ) . '</option>
							<option value="3">' . __( 'Average', 'fairy_style' ) . '</option>
							<option value="2">' . __( 'Not that bad', 'fairy_style' ) . '</option>
							<option value="1">' . __( 'Very Poor', 'fairy_style' ) . '</option>
						</select></p>';
						if( !is_user_logged_in () ){
							array_unshift( $comment_form['fields'], $rating );
						}
					}

					$comment_form['comment_field'] = '';

					if( is_user_logged_in () ){
						$comment_form['comment_field'] .= $rating;
					}

					$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'fairy_style' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'fairy_style' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>
</div>
