<?php

//Disable the default WooCommerce stylesheet.
if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
    add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
    define( 'WOOCOMMERCE_USE_CSS', false );
}

if(!function_exists('edgt_woo_related_products_args')) {
    /**
     * Function that sets number of displayed related products. Hooks to woocommerce_output_related_products_args filter
     * @param $args array array of args for the query
     * @return mixed array of changed args
     */
    function edgt_woo_related_products_args( $args ) {
        global $edgt_options;
        if(isset($edgt_options['woo_products_list_number']) && $edgt_options['woo_products_list_number'] != ''){
            switch($edgt_options['woo_products_list_number']){
                case('columns-3') :
                    $args['posts_per_page'] = 3;
                    break;
                case('columns-4') :
                    $args['posts_per_page'] = 4;
                    break;
                default :
                    $args['posts_per_page'] = 3;
            }
        }
        else {
            $args['posts_per_page'] = 3;
        }
        return $args;
    }

    add_filter( 'woocommerce_output_related_products_args', 'edgt_woo_related_products_args' );
}

// Redefine woocommerce_output_upsell_products()
function woocommerce_upsell_display($posts_per_page = 4, $columns = 4, $orderby = 'rand') {
    woocommerce_get_template('single-product/up-sells.php', array(
        'posts_per_page' => $posts_per_page,
        'orderby' => $orderby,
        'columns' => $columns
    ));
}

// Define number of products per page.
if(!function_exists('edgt_woo_product_per_page')) {
    /**
     * Function that sets number of products per page. Default is 12
     * @return int number of products to be shown per page
     */
    function edgt_woo_product_per_page() {
        global $edgt_options;

        $products_per_page = 12;
        if(isset($edgt_options['woo_products_per_page']) && $edgt_options['woo_products_per_page']) {
            $products_per_page = $edgt_options['woo_products_per_page'];
        }

        return $products_per_page;
    }

    add_filter('loop_shop_per_page', 'edgt_woo_product_per_page', 20);
}

// Hook in
add_filter('woocommerce_checkout_fields', 'edgt_custom_override_checkout_fields');

/**
 * Remove add to cart function from woocommerce_after_shop_loop_item_title hook
 * and hook it in edgt_woocommerce_after_product_image
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action('edgt_woocommerce_after_product_image', 'woocommerce_template_loop_add_to_cart', 10);

/**
 * Remove related products from woocommerce_after_single_product_summary hook
 * and hook it in edgt_woocommerce_related_products.With this action(edgt_woocommerce_related_products)
 *  related products now can be hooked separately from woocommerce tabs(accordions)
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action('edgt_woocommerce_related_products', 'woocommerce_output_related_products', 5);


/**
 * Overrides placeholder values for checkout fields
 * @param array all checkout fields
 * @return array checkout fields with overriden values
 */
function edgt_custom_override_checkout_fields($fields) {
    //billing fields
    $args_billing = array(
        'first_name' => __('First name','edgt'),
        'last_name'  => __('Last name','edgt'),
        'company'    => __('Company name','edgt'),
        'address_1'  => __('Address','edgt'),
        'email'      => __('Email','edgt'),
        'phone'      => __('Phone','edgt'),
        'postcode'   => __('Postcode / ZIP','edgt')
    );
    
    //shipping fields
    $args_shipping = array(
        'first_name' => __('First name','edgt'),
        'last_name'  => __('Last name','edgt'),
        'company'    => __('Company name','edgt'),
        'address_1'  => __('Address','edgt'),
        'postcode'   => __('Postcode / ZIP','edgt')
    );
    
    //override billing placeholder values
    foreach ($args_billing as $key => $value) {
        $fields["billing"]["billing_{$key}"]["placeholder"] = $value;
    }
    
    //override shipping placeholder values
    foreach ($args_shipping as $key => $value) {
        $fields["shipping"]["shipping_{$key}"]["placeholder"] = $value;
    }

    return $fields;
}

// Adds theme support for woocommerce 
add_theme_support('woocommerce');

if (!function_exists('edgt_woocommerce_content')){

    /**
     * Output WooCommerce content.
     *
     * This function is only used in the optional 'woocommerce.php' template
     * which people can add to their themes to add basic woocommerce support
     * without hooks or modifying core templates.
     *
     * @access public
     * @return void
     */
    function edgt_woocommerce_content() {

        if ( is_singular( 'product' ) ) {

            while ( have_posts() ) : the_post();

                woocommerce_get_template_part( 'content', 'single-product' );

            endwhile;

        } else {

            ?>

            <?php do_action( 'woocommerce_archive_description' ); ?>

            <?php if ( have_posts() ) : ?>

                <?php do_action('woocommerce_before_shop_loop'); ?>

                <?php woocommerce_product_loop_start(); ?>

                    <?php woocommerce_product_subcategories(); ?>

                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php woocommerce_get_template_part( 'content', 'product' ); ?>

                    <?php endwhile; // end of the loop. ?>

                <?php woocommerce_product_loop_end(); ?>

                <?php do_action('woocommerce_after_shop_loop'); ?>

            <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

                <?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>

            <?php endif;

        }
    }
}
if ( ! function_exists( 'edgt_woocommerce_output_product_data_tabs' ) ) {

	/**
	 * Output the product tabs.
	 *
	 * @access public
	 * @subpackage	Product/Tabs
	 * @return void
	 */
	function edgt_woocommerce_output_product_data_tabs() {
		woocommerce_get_template( 'single-product/tabs/tabs.php' );
                echo '</div>';
	}
}


if(!function_exists('edgt_woocommerce_change_actions_priorities')) {
    /**
     * Function that changes woocommerce actions priorities.
     * Used in product listing to put product rating bellow product price
     */
    function edgt_woocommerce_change_actions_priorities() {
        $actions = array(
            array(
                'tag' => 'woocommerce_after_shop_loop_item_title',
                'action' => 'woocommerce_template_loop_price',
                'priority' => 10,
                'priority_to_set' => 10
            ),
            array(
                'tag' => 'woocommerce_after_shop_loop_item_title',
                'action' => 'woocommerce_template_loop_rating',
                'priority' => 5,
                'priority_to_set' => 11
            )
        );
        
        foreach($actions as $action) {
            //actions which priorities needs to be changed
            remove_action($action['tag'], $action['action'], $action['priority']);
            
            //new priorities
            add_action($action['tag'], $action['action'], $action['priority_to_set']);
        }
    }
    
    add_action('woocommerce_change_priorities', 'edgt_woocommerce_change_actions_priorities');
    do_action('woocommerce_change_priorities');
}

add_filter( 'get_product_search_form' , 'woo_edgt_product_searchform' );

/**
 * woo_custom_product_searchform
 *
 * @access      public
 * @since       1.0
 * @return      void
 */
function woo_edgt_product_searchform($form) {

    $form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
		<div>
			<label class="screen-reader-text" for="s">' . __( 'Search for:', 'woocommerce' ) . '</label>
			<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __( 'Search Products', 'woocommerce' ) . '" />
			<input type="submit" id="searchsubmit" value="&#xf002" />
			<input type="hidden" name="post_type" value="product" />
		</div>
	</form>';

    return $form;

}

if(!function_exists('edgt_woocommerce_share')) {
    function edgt_woocommerce_share() {
        global $edgt_options;

        $product_show_social_share = "no";
        if (isset($edgt_options['enable_social_share'])&& ($edgt_options['enable_social_share']) =="yes"){
            if (isset($edgt_options['post_types_names_product'])&& $edgt_options['post_types_names_product'] =="product"){
                if (isset($edgt_options['woo_product_single_show_social_share'])) {
                    $product_show_social_share = $edgt_options['woo_product_single_show_social_share'];

                    $product_social_share_type = "dropdown";
                    if(isset($edgt_options['woo_product_single_select_share_option'])){
                        $product_social_share_type = $edgt_options['woo_product_single_select_share_option'];
                    }
                }
            }
        }
        if($product_show_social_share == 'yes'){
            if($product_social_share_type == 'dropdown'){
                if(do_shortcode('[no_social_share]') != ""){
                    echo '<span class="socail_share_title">Share: </span>';
                    echo do_shortcode('[no_social_share]'); // XSS OK
                }
            }
            elseif($product_social_share_type == 'list'){
                if(do_shortcode('[no_social_share_list]') != ""){
                    echo '<div class="social_share_list_holder">';
                    echo do_shortcode('[no_social_share_list]'); // XSS OK
                    echo '</div>'; // close social_share_list_holder
                }
            }
        }

    }

    add_action('woocommerce_product_meta_end', 'edgt_woocommerce_share');
}