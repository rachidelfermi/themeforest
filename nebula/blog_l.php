<?php
/**
 * Template Name: Blog Left Sidebar
 * The main template file for display blog page.
 *
 * @package WordPress
*/

/**
*	Get Current page object
**/
$page = get_page($post->ID);

/**
*	Get current page id
**/

if(!isset($current_page_id) && isset($page->ID))
{
    $current_page_id = $page->ID;
}

get_header(); 
?>

<br class="clear"/>

<?php
    //Get Page LayerSlider
    $page_layerslider = get_post_meta($current_page_id, 'page_layerslider', true);
    
    if($page_layerslider > 0)
    {
    	echo '<div class="page_layerslider">'.do_shortcode('[layerslider id="'.$page_layerslider.'"]').'</div>';
    }
?>

<?php
$is_display_page_content = TRUE;
$is_standard_wp_post = FALSE;

//Get page header display setting
$page_hide_header = get_post_meta($current_page_id, 'page_hide_header', true);

if(empty($page_hide_header))
{
?>
<div id="page_caption">
	<div class="page_title_wrapper">
		<h1>
			<?php
				if(is_tag())
				{
					printf( __( ' %s', '' ), '' . single_cat_title( '', false ) . '' ); 
					$is_display_page_content = FALSE;
					$is_standard_wp_post = TRUE;
				}
				elseif(is_category())
				{
					printf( __( ' %s', '' ), '' . single_cat_title( '', false ) . '' );
					$is_display_page_content = FALSE;
					$is_standard_wp_post = TRUE;
					$page_sidebar = 'Category Sidebar';
				}
				elseif(is_archive())
				{
			?>
					<?php if ( is_day() ) : ?>
						<?php printf( __( '%s', '' ), get_the_date() ); ?>
					<?php elseif ( is_month() ) : ?>
						<?php printf( __( '%s', '' ), get_the_date('F Y') ); ?>
					<?php elseif ( is_year() ) : ?>
						<?php printf( __( '%s', '' ), get_the_date('Y') ); ?>
					<?php else : ?>
						<?php _e( 'Blog Archives', '' ); ?>
					<?php endif; ?>
			<?php 
					$is_display_page_content = FALSE;
					$is_standard_wp_post = TRUE;
					$page_sidebar = 'Archives Sidebar';
				} 
				else 
				{
					the_title(); 
				}		
			?>
		</h1>
		<?php echo dimox_breadcrumbs(); ?>
	</div>
</div>
<br class="clear"/>
<?php
}
else
{
?>
<br class="clear"/>
<?php
}
?>

<?php
$page_sidebar = get_post_meta($current_page_id, 'page_sidebar', true);

//If not select sidebar then select default one
if(empty($page_sidebar))
{
	$page_sidebar = 'Blog Sidebar';
}
?>

<!-- Begin content -->
<?php
$page_audio = get_post_meta($current_page_id, 'page_audio', true);

if(!empty($page_audio))
{
?>
<div class="page_audio">
	<?php echo do_shortcode('[audio width="30" height="30" src="'.$page_audio.'"]'); ?>
</div>
<?php
}
?>

<div id="page_content_wrapper">
    
    <div class="inner">

    	<!-- Begin main content -->
    	<div class="inner_wrapper">
    		
    		<div class="sidebar_content full_width nomargintop">
    		
    			<?php if ( have_posts() && $is_display_page_content) while ( have_posts() ) : the_post(); ?>		

		    		<?php the_content(); ?>
		
		    	<?php endwhile; ?>
		    	
		    	<div class="sidebar_wrapper left_sidebar">
    		
	    			<div class="sidebar_top"></div>
	    		
	    			<div class="sidebar">
	    			
	    				<div class="content">
	    			
	    					<ul class="sidebar_widget">
	    					<?php dynamic_sidebar($page_sidebar); ?>
	    					</ul>
	    				
	    				</div>
	    		
	    			</div>
	    			<br class="clear"/>
	    	
	    			<div class="sidebar_bottom"></div>
	    		</div>

    			<div class="sidebar_content left_sidebar">
					
<?php

global $more; $more = false; 

//If theme built-in blog template then add query
if(!$is_standard_wp_post)
{
	$query_string ="post_type=post&paged=$paged";
	query_posts($query_string);
}

if (have_posts()) : while (have_posts()) : the_post();

	$image_thumb = '';
								
	if(has_post_thumbnail(get_the_ID(), 'large'))
	{
	    $image_id = get_post_thumbnail_id(get_the_ID());
	    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
	}
?>

<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post_wrapper">
	    
	    <div class="post_content_wrapper">
	    
	    	<?php
		    	if(!empty($image_thumb))
		    	{
		    		$small_image_url = wp_get_attachment_image_src($image_id, 'blog', true);
		    ?>
		    
		    <div class="post_img">
		    	<a href="<?php the_permalink(); ?>">
		    		<img src="<?php echo $small_image_url[0]; ?>" alt="" class="" style="width:<?php echo $small_image_url[1]; ?>px;height:<?php echo $small_image_url[2]; ?>px;"/>
		    		<div class="mask">
                    	<div class="mask_circle">
		                    <i class="fa fa-share"/></i>
						</div>
	                </div>
		    	</a>
		    </div>
		    
		    <?php
		    	}
		    ?>
	    
		    <div class="post_header">
		    	<h5><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
			    
			    <?php
			    	$pp_blog_display_full = get_option('pp_blog_display_full');
			    	
			    	if(!empty($pp_blog_display_full))
			    	{
			    		the_content();
			    	}
			    	else
			    	{
			    		the_excerpt();
			    	}
			    ?>
		    </div>
		    <hr/>
		    <div class="post_detail">
			    <?php
					$author_ID = get_the_author_meta('ID');
			    	$author_name = get_the_author();
			    	$author_url = get_author_posts_url($author_ID);
					
					if(!empty($author_name))
					{
				?>
					<i class="fa fa-user marginright"></i><?php echo _e( 'By', THEMEDOMAIN ); ?>&nbsp;<a href="<?php echo $author_url; ?>"><?php echo $author_name; ?></a>
				<?php
					}
		    	?>
		    	<?php echo _e( 'On', THEMEDOMAIN ); ?>&nbsp;<?php echo get_the_time(THEMEDATEFORMAT); ?>&nbsp;
			    <i class="fa fa-comment marginright"></i><a href="<?php comments_link(); ?>"><?php comments_number(__('0 Comment', THEMEDOMAIN), __('1 Comment', THEMEDOMAIN), __('% Comments', THEMEDOMAIN)); ?></a>
			</div>
			<a class="read_more" href="<?php the_permalink(); ?>"><?php echo _e( 'Read More', THEMEDOMAIN ); ?></a>
			
	    </div>
	    
	</div>

</div>
<br class="clear"/>
<!-- End each blog post -->

<?php endwhile; endif; ?>

    	<?php
		    if($wp_query->max_num_pages > 1)
		    {
		    	if (function_exists("wpapi_pagination")) 
		    	{
		?>
				<br class="clear"/>
		<?php
		    	    wpapi_pagination($wp_query->max_num_pages);
		    	}
		    	else
		    	{
		    	?>
		    	    <div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>
		    	<?php
		    	}
		    ?>
		    <div class="pagination_detail">
		     	<?php
		     		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		     	?>
		     	<?php _e( 'Page', THEMEDOMAIN ); ?> <?php echo $paged; ?> <?php _e( 'of', THEMEDOMAIN ); ?> <?php echo $wp_query->max_num_pages; ?>
		     </div>
		     <?php
		     }
		?>
    		
    	</div>
    	
    	</div>
    	
    </div>
    <!-- End main content -->

</div>  
<br class="clear"/><br/>
<?php get_footer(); ?>