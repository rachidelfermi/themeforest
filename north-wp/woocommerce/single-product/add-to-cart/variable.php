<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$attribute_keys = array_keys( $attributes );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->id ); ?>" data-product_variations="<?php echo htmlspecialchars( json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>
	
	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
			<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'north' ); ?></p>
	<?php else : ?>
		<div class="variations">
		<?php foreach ( $attributes as $attribute_name => $options ) : ?>
				<div class="select-wrapper">
					<?php
						$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) : $product->get_variation_default_attribute( $attribute_name );
						wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
					?>
			</div>
  	<?php endforeach;?>
	</div>
		<?php do_action('woocommerce_before_add_to_cart_button'); ?>
		
		<div class="single_variation_wrap">
	
			<?php do_action( 'woocommerce_before_single_variation' ); ?>
			
			<?php do_action( 'woocommerce_single_variation' ); ?>
			
			<?php do_action( 'woocommerce_after_single_variation' ); ?>
		</div>
		
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	
	<?php endif; ?>
	
	<?php do_action( 'woocommerce_after_variations_form' ); ?>
	
</form>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>