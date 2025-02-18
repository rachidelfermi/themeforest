<?php
/**
 * The template for displaying Woo Commerce products
 *
 * @package Layers
 * @since Layers 1.0.0
 */

get_header('handyman-inner');
get_template_part( 'partials/header' , 'page-title' );

?>
<section class="<?php if( 'layout-fullwidth' != layers_get_theme_mod( 'content-layout-layout' ) ) echo 'container'; ?> clearfix content-main grid">
		<?php
        /**
		* Maybe show the left sidebar
		*/
		layers_maybe_get_sidebar( 'left-woocommerce-sidebar', implode( ' ', layers_get_wrapper_class( 'body_sidebar', 'column pull-left sidebar span-3' ) ) ); ?>
		<?php if ( have_posts()) : ?>
			<section <?php layers_center_column_class(); ?>>

				<div class="grid push-bottom woocommerce-result-count-container">
					<?php  do_action('woocommerce_before_shop_loop'); ?>
				</div>

				<ul class="products grid">

					<?php // Sub category listing
					woocommerce_product_subcategories(); ?>

					<?php while (have_posts()) :  the_post(); ?>
							<?php woocommerce_get_template_part( 'content' , 'product' ); ?>
					<?php endwhile; ?>
				</ul>

				<?php layers_pagination(); ?>

				<?php woocommerce_product_loop_end(); ?>

			</section>
		<?php endif; ?>

		<?php /**
		* Maybe show the right sidebar
		*/
		layers_maybe_get_sidebar( 'right-woocommerce-sidebar', implode( ' ', layers_get_wrapper_class( 'body_sidebar', 'column pull-right sidebar span-3 no-gutter' ) ) ); ?>
</section>
<?php get_footer();