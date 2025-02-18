<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $woocommerce, $product, $woo_config;

$id = get_queried_object_id();
	
if(is_product()){
	$layout = theme_get_inherit_option($id, '_layout', 'advanced','woocommerce_product_layout');
}else{
	$layout = theme_get_inherit_option($id, '_layout', 'advanced','woocommerce_layout');
}

if($layout == 'full'){
	$sizes = array($woo_config['full']['shop_single']['width'], $woo_config['full']['shop_single']['height']);
}else{
	$sizes = array($woo_config['sidebar']['shop_single']['width'], $woo_config['sidebar']['shop_single']['height']);
}

?>
<div class="images">

	<?php
		if ( has_post_thumbnail() ) {
			$attachment_count   = count( $product->get_gallery_attachment_ids() );
			$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
			$thumbnail_id = get_post_thumbnail_id();
			$props       = wc_get_product_attachment_props( $thumbnail_id, $post );
		
			$image_src = theme_get_image_src(array('type'=>'attachment_id','value'=>$thumbnail_id), $sizes);
			$image_title 		= esc_attr( $props['title'] );
			$image_alt 			= esc_attr( $props['alt'] );
			if (empty($image_alt)) $image_alt=$image_title;

			$image       		= '<img class="attachment-shop_single wp-post-image" width="'.$sizes[0].'" height="'.$sizes[1].'" data-thumbnail="'.$thumbnail_id.'" src="'.$image_src.'" alt="'.$image_alt.'" />';

			$image_link  		= esc_url( $props['url'] );

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_title, $image ), $post->ID );

		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
		}

		do_action( 'woocommerce_product_thumbnails' );
	?>
</div>
