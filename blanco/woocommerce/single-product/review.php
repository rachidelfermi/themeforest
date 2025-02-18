<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post; 
?>
<li itemprop="reviews" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<?php echo get_avatar( $GLOBALS['comment'], $size='60' ); ?>
		
		<div class="comment-text">
		
			<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo esc_attr( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) ); ?>">
				<span style="width:<?php echo get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true )*10; ?>px"><span itemprop="ratingValue"><?php echo get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ); ?></span> <?php _e('out of 5', ETHEME_DOMAIN); ?></span>
			</div>
			
			<?php if ($GLOBALS['comment']->comment_approved == '0') : ?>
				<p class="meta"><em><?php _e('Your comment is awaiting approval', ETHEME_DOMAIN); ?></em></p>
			<?php else : ?>
				<p class="meta">
					<strong itemprop="author"><?php comment_author(); ?></strong> <?php 
						
						if ( get_option('woocommerce_review_rating_verification_label') == 'yes' )
							if ( woocommerce_customer_bought_product( $GLOBALS['comment']->comment_author_email, $GLOBALS['comment']->user_id, $post->ID ) )
								echo '(' . __('verified owner', ETHEME_DOMAIN) . ') ';
						
					?>&ndash; <time itemprop="datePublished" time datetime="<?php echo get_comment_date('c'); ?>"><?php echo get_comment_date(__('M jS Y', ETHEME_DOMAIN)); ?></time>:
				</p>
			<?php endif; ?>
			
				<div itemprop="description" class="description"><?php comment_text(); ?></div>
				<div class="clear"></div>
			</div>
		<div class="clear"></div>			
	</div>