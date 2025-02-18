<?php
/**
 * Additional Information tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/additional-information.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woothemes.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$heading = apply_filters( 'woocommerce_product_additional_information_heading', __( 'Additional Information', 'north' ) );
$shop_product_style = ot_get_option('shop_product_style', 'style1');
?>
<?php if ($shop_product_style === 'style2') { ?>
<div class="row">
	<div class="small-12 medium-8 medium-centered large-6 columns">
<?php } ?>
<?php $product->list_attributes(); ?>
<?php if ($shop_product_style === 'style2') { ?>
	</div>
</div>
<?php } ?>