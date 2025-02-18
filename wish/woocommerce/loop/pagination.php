<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.2
 */
if ( !defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

global $wp_query;

if ( $wp_query->max_num_pages <= 1 )
    return;
?>
<nav class="woocommerce-pagination clearfix">
    <?php
    echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
        'base' => str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
        'format' => '',
        'current' => max( 1, get_query_var( 'paged' ) ),
        'total' => $wp_query->max_num_pages,
        'prev_text' => '<span class="icon-arrow-left"></span>',
        'next_text' => '<span class="icon-arrow-right"></span>',
        'type' => 'list',
        'end_size' => 3,
        'mid_size' => 3
    ) ) );
    ?>
</nav>