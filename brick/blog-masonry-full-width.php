<?php
/*
Template Name: Blog Masonry Full Width
*/
?>
<?php get_header(); ?>
<?php
global $wp_query;
global $qode_template_name;
global $qode_page_id;
$qode_page_id = $wp_query->get_queried_object_id();
$id = $wp_query->get_queried_object_id();
$qode_template_name = get_page_template_slug($id);
$category = get_post_meta($id, "qode_choose-blog-category", true);
$post_number = esc_attr(get_post_meta($id, "qode_show-posts-per-page", true));
if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }
$page_object = get_post( $id );
$q_content = $page_object->post_content;

$sidebar = get_post_meta($id, "qode_show-sidebar", true);

if(get_post_meta($id, "qode_page_background_color", true) != ""){
	$background_color = 'background-color: '.esc_attr(get_post_meta($id, "qode_page_background_color", true));
}else{
	$background_color = "";
}

$content_style = "";
if(get_post_meta($id, "qode_content-top-padding", true) != ""){
	if(get_post_meta($id, "qode_content-top-padding-mobile", true) == 'yes'){
		$content_style = "padding-top:".esc_attr(get_post_meta($id, "qode_content-top-padding", true))."px !important";
	}else{
		$content_style = "padding-top:".esc_attr(get_post_meta($id, "qode_content-top-padding", true))."px";
	}
}

if(isset($qode_options['blog_masonry_number_of_chars'])&& $qode_options['blog_masonry_number_of_chars'] != "") {
	qode_set_blog_word_count(esc_attr($qode_options['blog_masonry_number_of_chars']));
}
$category_filter = "no";
if(isset($qode_options['blog_masonry_filter'])){
	$category_filter = $qode_options['blog_masonry_filter'];
}
$container_inner_class = "";
if($category_filter == "yes"){
	$container_inner_class = " full_page_container_inner";
}
?>

	<?php if(get_post_meta($id, "qode_page_scroll_amount_for_sticky", true)) { ?>
		<script>
		var page_scroll_amount_for_sticky = <?php echo esc_attr(get_post_meta($id, "qode_page_scroll_amount_for_sticky", true)); ?>;
		</script>
	<?php } ?>

	<?php get_template_part( 'title' ); ?>
	<?php get_template_part('slider'); ?>

	<?php		
		if(isset($qode_options['blog_page_range']) && $qode_options['blog_page_range'] != ""){
			$blog_page_range = esc_attr($qode_options['blog_page_range']);
		} else{
			$blog_page_range = $wp_query->max_num_pages;
		}
	?>
	<div class="full_width" <?php qode_inline_style($background_color); ?>>
		<div class="full_width_inner clearfix <?php echo esc_attr($container_inner_class); ?>" <?php qode_inline_style($content_style); ?>>
			<?php
				echo apply_filters('the_content', wp_kses_post($q_content));
				query_posts('post_type=post&paged='. $paged . '&cat=' . $category .'&posts_per_page=' . $post_number );
				get_template_part('templates/blog/blog', 'structure');
			?>
		</div>
	</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>