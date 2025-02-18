<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop;

get_header('shop'); ?>
	  
	<?php
        // Remove breadcrumb if needed
        $post_id = yiw_post_id();
        if( get_post_meta( $post_id, '_show_breadcrumbs_page', true ) == 'no' ) {
            remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
        }

        if( get_post_meta( $post_id, '_slogan_page', true ) ) {
            get_template_part('slogan');
        }
		/** 
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */	 
		do_action('woocommerce_before_main_content');
	?>
        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		    <h1 class="page-title"><?php if( get_post_meta( yiw_post_id(), '_show_title_page', true ) == 'yes' ) woocommerce_page_title(); ?></h1>
		<?php endif; ?>

		<div class="clear"></div>         

		<?php do_action( 'woocommerce_archive_description' ); ?>
				
		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_pagination hook
				 *
				 * @hooked woocommerce_pagination - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
		
			<?php woocommerce_product_loop_start(); ?>
			
				<?php woocommerce_product_subcategories(); $woocommerce_loop['loop'] = 0; $woocommerce_loop['columns'] = 0; ?>
		
				<?php while ( have_posts() ) : the_post(); ?>
		
					<?php wc_get_template_part( 'content', 'product' ); ?>
		
				<?php endwhile; // end of the loop. ?>
				
			<?php woocommerce_product_loop_end(); ?>

			<?php do_action('woocommerce_after_shop_loop'); ?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>
		
		<div class="clear"></div>

		<?php 
			/** 
			 * woocommerce_pagination hook
			 *
			 * @hooked woocommerce_pagination - 10
			 * @hooked woocommerce_catalog_ordering - 20
			 */		
			do_action( 'woocommerce_pagination' ); 
		?>

	<?php
		/** 
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */	 
		do_action('woocommerce_after_main_content'); 
	?>

	<?php 
		/** 
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */		
		do_action('woocommerce_sidebar'); 
	?>

<?php get_template_part( 'extra-content' ) ?>

<?php get_footer('shop'); ?>