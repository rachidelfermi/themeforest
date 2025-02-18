<?php
/**
 * Single Product Image
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.0.14
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
global $post, $woocommerce, $product,$ievent_data;
?>
<div class="images">
			<?php
			if ( has_post_thumbnail() ) {
				$image_title      = esc_attr( get_the_title( get_post_thumbnail_id() ) );
				$image_link       = wp_get_attachment_url( get_post_thumbnail_id() );
				$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
					'title' => $image_title
				) );
				$attachment_count = count( $product->get_gallery_attachment_ids() );
				$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
				
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $props['url'], $props['caption'], $image ), $post->ID );
  				
			}else{
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
			}
				
			
			//$attachment_ids = $product->get_gallery_attachment_ids();
			?>
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
</div>
