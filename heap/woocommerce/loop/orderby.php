<?php
/**
 * Show options for ordering
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wp_query;

// get all product categories
$terms = get_terms('product_cat');

// if there is a category queried cache it
$current_term =	get_queried_object();

if ( !is_wp_error( $terms ) && ! empty( $terms ) && heap_option('display_product_filters', '1') ) {
	// create a link which should link to the shop
	$all_link = get_post_type_archive_link('product');

	echo '<ul class="shop-categories  nav  nav--banner">';
	// display the shop link first if there is one
	if ( !empty($all_link) ) {
		// also if the current_term doesn't have a term_id it means we are quering the shop and the "all categories" should be active
		echo '<li><a href="', $all_link ,'"', ( !isset( $current_term->term_id ) ) ? ' class="active"' : '' ,'>', __('All Products', 'heap' ) , '</a></li>';
	}

	// display a link for each product category
	foreach ($terms as $key => $term ) {
		$link  = get_term_link( $term, 'product_cat' );
		if ( !is_wp_error($link) ) {

			// if the current category is queried add the "active class" to the link
			$class_string = "";
			if ( !empty($current_term->name) && $current_term->name === $term->name ) {
				$class_string = ' class="active"';
			}

			echo '<li><a href="', $link, '"', $class_string,'>', $term->name ,'</a></li>';
		}
	}
	echo '</ul>';
} // close if !empty($terms)

// for the moment we do not need an order selector
return;

global $woocommerce, $wp_query;

if ( 1 == $wp_query->found_posts || ! woocommerce_products_will_display() )
	return;
?>
<form class="woocommerce-ordering" method="get">
	<select name="orderby" class="orderby">
		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php
	// Keep query string vars intact
	foreach ( $_GET as $key => $val ) {
		if ( 'orderby' === $key || 'submit' === $key ) {
			continue;
		}
		if ( is_array( $val ) ) {
			foreach( $val as $innerVal ) {
				echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
			}
		} else {
			echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
		}
	}
	?>
</form>
