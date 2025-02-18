<?php
/*
Template Name: Blog Classic
*/

/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package berg-wp
 */

get_header(); 

global $pageId;
$pageId = get_the_id();
$args = array('all');
$the_query = new WP_Query( $args );

$categories = get_post_meta(get_the_id());
	
if (isset($categories['blog_categories'][0])) {
	$categories = maybe_unserialize($categories['blog_categories'][0]);
} else {
	$categories = '';
}

$sidebar = '';
$posts_size_content = '';
if(YSettings::g('berg_blog_classic_sidebar_pos') == 'right') {
	$sidebar = 'sidebar-right';
	$posts_size_content = 'col-md-8';
} 
if(YSettings::g('berg_blog_classic_sidebar_pos') == 'left') {
	$sidebar = 'sidebar-left';
	$posts_size_content = 'col-md-8';
} 
if(YSettings::g('berg_blog_classic_sidebar_pos') == 'none') {
	$sidebar = 'hidden';
	$posts_size_content = 'col-md-10 col-md-offset-1';
} 

$sidebar_name = YSettings::g('berg_blog_classic_sidebar_select');

?>
<section id="blog-classic" class="section-scroll main-section blog-content blog blog-sidebar">
	<?php if(YSettings::g('berg_show_page_title')) : ?>
	<header class="section-header">
		<h2 class="h3"><?php echo the_title();?></h2>
	</header>
	<?php endif; ?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 <?php echo $posts_size_content; ?>">
			<?php
			if ($categories == '') {
				$the_query = new WP_Query(array(
					'posts_per_page' => YSettings::g('blog_post_per_page', $pageId)
				));
			} else {
				$the_query = new WP_Query(array(
					'posts_per_page' => YSettings::g('blog_post_per_page', $pageId),
					'tax_query' => array(array(
						'taxonomy' => 'category',
						'terms' => $categories,
						'field' => 'term_id'
					))
				));
			}
			?>
			<div id="blog-content-append" data-pages="<?php echo $the_query->max_num_pages;?>">
			<?php if ($the_query->have_posts()) : ?>
				
				<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<?php get_template_part('content', 'blog-classic'); ?>
				<?php endwhile; ?>

				<?php berg_wp_paging_nav(); ?>

			<?php else : ?>
				<?php get_template_part('content', 'none'); ?>
			<?php endif; ?>
			<div class="hidden-content hidden"></div>
			</div>
			<?php if ($the_query->max_num_pages > 1) : ?>
				<article class="load-more post">
					<div class="load-more-text">
						<span class="hidden-xs hidden-sm"><?php echo __('Load more', 'BERG'); ?></span>
						<button class="visible-xs visible-sm"><?php echo __('Load more', 'BERG'); ?></button>
					</div>

					<div class="js-loading "><div class="masonry-spinner"><div></div><div></div><div></div><div></div></div><div class="ie-fallback">Please wait...</div></div>
				</article>
			<?php endif; ?>
			</div>

			<div class="col-xs-12 col-md-4 widget-sidebar sidebar-padding <?php echo $sidebar;?>">
				<?php //echo $sidebar_object ;?>
				<?php dynamic_sidebar($sidebar_name);?>
			</div>

		</div>
	</div>
</section>
<?php
wp_reset_postdata();
berg_getFooter();
get_template_part('footer');