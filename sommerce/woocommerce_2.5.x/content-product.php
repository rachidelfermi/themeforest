<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}

if (   yiw_get_option( 'shop_border_thumbnail' ) )        { $classes[] = 'border'; }
if (   yiw_get_option( 'shop_shadow_thumbnail' ) )        { $classes[] = 'shadow'; }
if ( ! yiw_get_option( 'shop_show_price' ) )              { $classes[] = 'hide-price'; }
if ( ! yiw_get_option( 'shop_show_button_details' ) )     { $classes[] = 'hide-details-button'; }
if ( ! yiw_get_option( 'shop_show_button_add_to_cart' ) ) { $classes[] = 'hide-add-to-cart-button'; }

?>
<li <?php post_class( $classes ); ?>>

    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

    <a href="<?php the_permalink(); ?>">

        <div class="thumbnail">
            <?php
	            /**
	             * woocommerce_before_shop_loop_item_title hook
	             *
	             * @hooked woocommerce_show_product_loop_sale_flash - 10
	             * @hooked woocommerce_template_loop_product_thumbnail - 10
	             */
	            do_action( 'woocommerce_before_shop_loop_item_title' );

	            /**
	             * woocommerce_shop_loop_item_title hook
	             *
	             * @hooked woocommerce_template_loop_product_title - 10
	             */
	            do_action( 'woocommerce_shop_loop_item_title' );
            ?>
        </div>

        <?php
	        /**
	         * woocommerce_after_shop_loop_item_title hook
	         *
	         * @hooked woocommerce_template_loop_rating - 5
	         * @hooked woocommerce_template_loop_price - 10
	         */
	        do_action( 'woocommerce_after_shop_loop_item_title' );
        ?>

    </a>

    <?php

	    /**
	     * woocommerce_after_shop_loop_item hook
	     *
	     * @hooked woocommerce_template_loop_add_to_cart - 10
	     */
	    do_action( 'woocommerce_after_shop_loop_item' );
    ?>

</li>
