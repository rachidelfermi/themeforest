<?php get_header(); ?>
<?php 
global $wp_query;
$id = $wp_query->get_queried_object_id();

if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }

$sidebar = $qode_options['category_blog_sidebar'];

if(isset($qode_options['blog_page_range']) && $qode_options['blog_page_range'] != ""){
	$blog_page_range = esc_attr($qode_options['blog_page_range']);
} else{
	$blog_page_range = $wp_query->max_num_pages;
}

?>
	
	<?php if(get_post_meta($id, "qode_page_scroll_amount_for_sticky", true)) { ?>
		<script>
			var page_scroll_amount_for_sticky = <?php echo esc_attr(get_post_meta($id, "qode_page_scroll_amount_for_sticky", true)); ?>;
		</script>
	<?php } ?>

	<?php get_template_part( 'title' ); ?>
	
	<div class="container">
	<?php if($qode_options['overlapping_content'] == 'yes') {?>
		<div class="overlapping_content"><div class="overlapping_content_inner">
	<?php } ?>
	<div class="container_inner default_template_holder clearfix">
		<?php if(($sidebar == "default")||($sidebar == "")) : ?>
			<div class="blog_holder blog_standard_type">
				<?php if(have_posts()) : while ( have_posts() ) : the_post(); ?>
						<?php 
							get_template_part('templates/blog/blog_search', 'loop');
						?>
				<?php endwhile; ?>
				<?php if($qode_options['pagination'] != "0") : ?>
					<?php qode_pagination($wp_query->max_num_pages, $blog_page_range, $paged); ?>
				<?php endif; ?>
				<?php else: //If no posts are present ?>
						<div class="entry">                        
							<p><?php _e('No posts were found.', 'qode'); ?></p>    
						</div>
				<?php endif; ?>
			</div>	
		<?php elseif($sidebar == "1" || $sidebar == "2"): ?>
			<div class="<?php if($sidebar == "1"):?>two_columns_66_33<?php elseif($sidebar == "2") : ?>two_columns_75_25<?php endif; ?> background_color_sidebar grid2 clearfix">
				<div class="column1 content_left_from_sidebar">
					<div class="column_inner">
						<div class="blog_holder blog_standard_type">
							<?php if(have_posts()) : while ( have_posts() ) : the_post(); ?>
									<?php 
										get_template_part('templates/blog/blog_search', 'loop');
									?>
							<?php endwhile; ?>
							<?php if($qode_options['pagination'] != "0") : ?>
								<?php qode_pagination($wp_query->max_num_pages, $blog_page_range, $paged); ?>
							<?php endif; ?>
							<?php else: //If no posts are present ?>
								<div class="entry">                        
									<p><?php _e('No posts were found.', 'qode'); ?></p>    
								</div>
							<?php endif; ?>
						</div>	
					</div>
				</div>
				<div class="column2">
					<?php get_sidebar(); ?>	
				</div>
			</div>
	<?php elseif($sidebar == "3" || $sidebar == "4"): ?>
			<div class="<?php if($sidebar == "3"):?>two_columns_33_66<?php elseif($sidebar == "4") : ?>two_columns_25_75<?php endif; ?> background_color_sidebar grid2 clearfix">
				<div class="column1">
				<?php get_sidebar(); ?>	
				</div>
				<div class="column2 content_right_from_sidebar">
					<div class="column_inner">
						<div class="blog_holder blog_standard_type">
							<?php if(have_posts()) : while ( have_posts() ) : the_post(); ?>
								<?php 
									get_template_part('templates/blog/blog_search', 'loop');
								?>
							<?php endwhile; ?>
							<?php if($qode_options['pagination'] != "0") : ?>
								<?php qode_pagination($wp_query->max_num_pages, $blog_page_range, $paged); ?>
							<?php endif; ?>
							<?php else: //If no posts are present ?>
								<div class="entry">                        
									<p><?php _e('No posts were found.', 'qode'); ?></p>    
								</div>
							<?php endif; ?>
						</div>	
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<?php if($qode_options['overlapping_content'] == 'yes') {?>
		</div></div>
	<?php } ?>
</div>
<?php get_footer(); ?>