<?php
/*
Template Name: Child Menu Left
*/
?>
<?php get_header(); ?>
<?php while(have_posts()): the_post(); ?>

<div class="container fix">	
		
	<div id="page-title">
		<h1><?php echo wpb_page_title(); ?></h1>
	</div><!--/page-title-->
	
	<div id="content-part" class="right">
		<article id="entry-<?php the_ID(); ?>" <?php post_class('entry fix'); ?>>
			<?php get_template_part('_page-image'); ?>
			<div class="pad">
				<div class="text">
					<?php the_content(); ?>
					<div class="clear"></div>
				</div>
			</div>
		</article>

		<?php comments_template(); ?>
	</div><!--/content-part-->
	
	<div id="sidebar" class="sidebar-left mobile">	
		<ul id="child-menu">
			<?php wp_list_pages('title_li=&sort_column=menu_order&depth=3'); ?>
		</ul>
	</div><!--/sidebar-->
	
</div><!--/container-->

<?php endwhile; ?>
<?php get_footer(); ?>