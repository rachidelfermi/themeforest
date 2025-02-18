<?php
/**
 * @package WordPress
 * @subpackage Agriculture
 * @since Agriculture 1.0
 * 
 * Blog Post Full Width Image Post Format Template
 * Created by CMSMasters
 * 
 */


$cmsms_option = cmsms_get_global_options();


$cmsms_heading = get_post_meta(get_the_ID(), 'cmsms_heading', true);

$cmsms_post_featured_image_show = get_post_meta(get_the_ID(), 'cmsms_post_featured_image_show', true);

$cmsms_post_image_link = get_post_meta(get_the_ID(), 'cmsms_post_image_link', true);

?>

<!--_________________________ Start Image Article _________________________ -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
		if (!post_password_required()) {
			if ($cmsms_post_image_link != '' && $cmsms_post_image_link != get_template_directory_uri() . '/framework/admin/inc/img/image.png') {
				cmsms_thumb(get_the_ID(), 'full-thumb', false, 'img_' . get_the_ID(), true, true, true, true, $cmsms_post_image_link);
			} else if (has_post_thumbnail() && $cmsms_post_featured_image_show == 'true' && $cmsms_heading != 'parallax') {
				cmsms_thumb(get_the_ID(), 'full-thumb', false, 'img_' . get_the_ID(), true, true, true, true, false);
			}
		}
	?>
	<header class="entry-header">
		<span class="cmsms_post_format_img"></span>
	<?php
		if ($cmsms_option[CMSMS_SHORTNAME . '_blog_post_title']) {
			echo cmsms_heading_nolink(get_the_ID(), false) . "\n";
		}
	?>
	</header>
	<?php 
	if (
		$cmsms_option[CMSMS_SHORTNAME . '_blog_post_like'] || 
		$cmsms_option[CMSMS_SHORTNAME . '_blog_post_date'] || 
		$cmsms_option[CMSMS_SHORTNAME . '_blog_post_comment'] || 
		$cmsms_option[CMSMS_SHORTNAME . '_blog_post_cat'] || 
		$cmsms_option[CMSMS_SHORTNAME . '_blog_post_author']
	) {
		echo '<footer class="entry-meta">';
			
			cmsms_post_like('post', 'post');
		
			cmsms_post_date('post', 'post');
			
			if (!post_password_required()) {
				cmsms_comments('post', 'post');
			}
			
			cmsms_meta('post', 'post');
			
		echo '</footer>';
	}
		
	echo '<div class="entry-content">' . "\n";
	
	the_content();
	
	wp_link_pages(array( 
		'before' => '<div class="subpage_nav" role="navigation">' . '<strong>' . __('Pages', 'cmsmasters') . ':</strong>', 
		'after' => '</div>' . "\n", 
		'link_before' => ' [ ', 
		'link_after' => ' ] ' 
	));
	
	cmsms_content_composer(get_the_ID());
	
	echo "\t\t" . '</div>' . "\n" . 
	'<div class="cl"></div>';
	
	cmsms_tags(get_the_ID(), 'post', 'post'); 
	?>
</article>
<!--_________________________ Finish Image Article _________________________ -->

