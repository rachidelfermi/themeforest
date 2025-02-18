<?php

if ( ! function_exists( 'gp_posts' ) ) {
	function gp_posts($atts, $content = null) {
		extract(shortcode_atts(array(
			'cats' => '',
			'images' => 'true',
			'image_width' => '670',
			'image_height' => '250',
			'image_wrap' => 'false',
			'hard_crop' => 'true',
			'cols' => '1',
			'per_page' => '5',
			'link' => 'both',
			'orderby' => 'date',
			'order' => 'desc',
			'offset' => '',
			'content_display' => 'excerpt',
			'excerpt_length' => '400',
			'title' => 'true',
			'title_size' => '',
			'title_font' => '',
			'meta' => 'true',
			'meta_author' => 'true',
			'meta_date' => 'true',
			'meta_cats' => 'true',
			'meta_comments' => 'true',
			'meta_tags' => 'true',
			'read_more' => 'true',
			'pagination' => 'true',
			'preload' => 'false',
			'spacing' => 'spacing-normal'
		),$atts));

		require(gp_inc . 'options.php'); global $post, $dirname;


		// Unique Name
	
		STATIC $i = 0;
		$i++;
		$name = 'posts'.$i;
	
	
		// Title Size
	
		$title_weight = '';
		if($title_size != "") {
			if(preg_match('/^1[0-4]$/', $title_size)) {
				$title_weight = 'font-weight: bold; ';				
			}
		}
		if($title_size != "") {
			if(preg_match('/%/', $title_size) OR preg_match('/em/', $title_size) OR preg_match('/px/', $title_size)) {
				$title_size = 'font-size: '.$title_size.'; ';				
			} else {
				$title_size = 'font-size: '.$title_size.'px; ';		
			}
		} else {
			$title_size = "";
		}
	
	
		// Title Font
	
		if($title_font != "") {
			$title_font = 'font-family: '.$title_font.'; ';		
		} else {
			$title_font = "";
		}
	
	
		// Preload
	
		if($preload == "true") {
			$preload = " preload ";
		} else {
			$preload = "";
		}
	
	
		// Pagination
		
		if (get_query_var('paged') && $pagination == 'true') {
			$paged = get_query_var('paged');
		} elseif (get_query_var('page') && $pagination == 'true') {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}
	
	
		// Post Query	
	
		$args=array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'cat' => $cats,
		'paged' => $paged,
		'ignore_sticky_posts' => 0,
		'orderby' => $orderby,
		'order' => $order,
		'posts_per_page' => $per_page,
		'offset' => $offset
		);

		$featured_query = new wp_query($args); $counter = "";
	
		ob_start(); ?>
	
	
		<!-- BEGIN POST WRAPPER -->
	
		<div class="post-wrapper <?php echo $name.' '.$spacing; ?>">
	
	
			<?php while ($featured_query->have_posts()) : $featured_query->the_post(); $counter = $counter + 1;
		
		
			// Image Dimensions
		
			if(get_post_meta($post->ID, $dirname.'_thumbnail_width', true) && get_post_meta($post->ID, $dirname.'_thumbnail_width', true)) {
				$thumbnail_width = get_post_meta($post->ID, $dirname.'_thumbnail_width', true);
			} else {
				$thumbnail_width = $image_width;
			}
			if(get_post_meta($post->ID, $dirname.'_thumbnail_height', true) != "") {
				$thumbnail_height = get_post_meta($post->ID, $dirname.'_thumbnail_height', true);
			} else {
				$thumbnail_height = $image_height;
			}
		
		
			// Columns
		
			if($counter %$cols == 1) {
				$first_column = " first-column ";
			} else {
				$first_column = "";
			}
	
			if($cols > 1) {
				$columns = " post-columns ";
			} else {
				$columns = "";
			}
		
			$col_width = (100 - (($cols -1) * 4)) / $cols;
		
			?>
		
			
				<!-- BEGIN POST -->
	
				<div <?php post_class('post-loop'.$preload.$first_column.$columns); ?> style="width: <?php echo $col_width; ?>%;">
						
				
					<!-- BEGIN IMAGE -->
				
					<?php if(has_post_thumbnail() && $images == "true") { ?>	
							
						<div class="post-thumbnail<?php if($image_wrap == "true") { ?> wrap<?php } ?>">
				
							<?php if(($link == "image" OR $link == "both") && get_post_meta($post->ID, $dirname.'_link_type', true) != "None") { ?>
								<a href="<?php if(get_post_meta($post->ID, $dirname.'_link_type', true) == "Lightbox Video") { ?>file=<?php echo get_post_meta($post->ID, $dirname.'_custom_url', true); } elseif(get_post_meta($post->ID, $dirname.'_link_type', true) == "Lightbox Image") { if(get_post_meta($post->ID, $dirname.'_custom_url', true)) { echo get_post_meta($post->ID, $dirname.'_custom_url', true); } else { echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); }} else { if(get_post_meta($post->ID, $dirname.'_custom_url', true)) { echo get_post_meta($post->ID, $dirname.'_custom_url', true); } else { the_permalink(); }} ?>"<?php if(get_post_meta($post->ID, $dirname.'_link_type', true) == "Lightbox Image" OR get_post_meta($post->ID, $dirname.'_link_type', true) == "Lightbox Video") { ?> rel="prettyPhoto[<?php echo $name; the_ID(); ?>]"<?php } ?>>
							<?php } ?>
										
								<?php if($link == "image" OR $link == "both") { ?>
									<?php if(get_post_meta($post->ID, $dirname.'_link_type', true) == "Lightbox Image") { ?><span class="hover-image"></span><?php } elseif(get_post_meta($post->ID, $dirname.'_link_type', true) == "Lightbox Video") { ?><span class="hover-video"></span><?php } ?>
								<?php } ?>

								<?php $image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id(get_the_id())), $thumbnail_width, $thumbnail_height, $hard_crop, false, true); ?>
								<?php if(get_option($dirname.'_retina') == "0") { $retina = aq_resize(wp_get_attachment_url(get_post_thumbnail_id(get_the_id())),  $thumbnail_width*2, $thumbnail_height*2, $hard_crop, true, true); } else { $retina = ""; } ?>
								<img src="<?php echo $image[0]; ?>" data-rel="<?php echo $retina; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" class="wp-post-image" />

							<?php if(($link == "image" OR $link == "both") && get_post_meta($post->ID, $dirname.'_link_type', true) != "None") { ?></a><?php } ?>
						
						</div>					
									
						<?php if($image_wrap == "false") { ?><div class="clear"></div><?php } ?>
				
					<?php } ?>
				
					<!-- END IMAGE -->
				
				
					<!-- BEGIN LIGHTBOX IMAGES -->
				
					<?php if(get_post_meta($post->ID, $dirname.'_link_type', true) == "Lightbox Image" OR get_post_meta($post->ID, $dirname.'_link_type', true) == "Lightbox Video") { ?>
				
						<?php $args = array('post_type' => 'attachment', 'post_parent' => $post->ID, 'numberposts' => -1, 'orderby' => 'menu_order', 'order' => 'asc', 'post__not_in'	=> array(get_post_thumbnail_id())); $attachments = get_children($args); if($attachments) { foreach ($attachments as $attachment) { ?>
				
							<a href="<?php if(get_post_meta($attachment->ID, $dirname.'_lightbox_url', true)) { ?>file=<?php echo get_post_meta($attachment->ID, $dirname.'_lightbox_url', true); } else { echo wp_get_attachment_url($attachment->ID); } ?>" rel="prettyPhoto[<?php echo $name; the_ID(); ?>]" title="<?php echo $attachment->post_content; ?>" style="display: none;"><img src="" alt="<?php echo $attachment->post_title; ?>"></a>
				
						<?php }} ?>
				
					<?php } ?>
								
					<!-- END LIGHTBOX IMAGES -->
				
				
					<!-- BEGIN POST TEXT -->
				
					<div class="post-text">
				
					
						<!-- BEGIN TITLE -->
					
						<?php if($title == "true") { ?><h2 style="<?php echo $title_size.$title_font.$title_weight; ?>"><?php if($link == "title" OR $link == "both") { ?><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php } ?><?php the_title(); ?><?php if($link == "title" OR $link == "both") { ?></a><?php } ?></h2><?php } ?>
	
						<!-- END TITLE -->

					
						<!-- BEGIN POST META -->
					
						<?php if($meta == "true" && ($meta_date == "true" OR $meta_author == "true" OR $meta_cats == "true" OR $meta_comments == "true")) { ?>
					
							<div class="post-meta">
						
								<?php if($meta_author == "true") { ?><span class="author-icon"><a href="<?php echo get_author_posts_url($post->post_author); ?>"><?php the_author_meta('display_name', $post->post_author); ?></a></span><?php } ?>
							
								<?php if($meta_date == "true") { ?><span class="clock-icon"><?php the_time(get_option('date_format')); ?></span><?php } ?>
							
								<?php if($meta_cats == "true") { ?><span class="folder-icon"><?php the_category(', '); ?></span><?php } ?>
							
								<?php if($meta_comments == "true" && 'open' == $post->comment_status) { ?><span class="speech-icon"><?php comments_popup_link(__('0', 'gp_lang'), __('1', 'gp_lang'), __('%', 'gp_lang'), 'comments-link', ''); ?></span><?php } ?>
							
							</div>
						
						<?php } ?>
					
						<!-- END POST META -->
					
					
						<!-- BEGIN POST CONTENT -->
					
						<?php if($content_display == "full") { ?>	
					
							<?php global $more; $more = 0; the_content('&raquo;'); ?>
						
						<?php } else { ?>
					
							<?php if($excerpt_length != "0") { ?><p><?php echo gp_excerpt($excerpt_length); ?><?php if($read_more == "true") { ?> <a href="<?php the_permalink(); ?>" class="read-more" title="<?php the_title(); ?>"> &raquo;</a><?php } ?></p><?php } ?>
						
						<?php } ?>
					
						<!-- BEGIN POST CONTENT -->
					
					
						<!-- BEGIN POST TAGS -->
					
						<?php if($meta == "true" && $meta_tags == "true") { ?>
							<?php the_tags('<div class="post-meta post-tags"><span class="tag-icon">', ', ', '</span></div>'); ?>
						<?php } ?>
					
						<!-- END POST TAGS -->
					
					
					</div>
				
					<!-- END POST TEXT -->
				
	
				</div>
			
				<!-- END POST -->
			
				
				<?php if($cols > 1 && $counter %$cols == 0) { ?><div class="clear"></div><?php } ?>
			
			
			<?php endwhile; ?>
		
	
			<div class="clear"></div>
		

		</div>
	
		<!-- END POST WRAPPER -->
	

	<?php
	
		if($pagination == "true") { gp_pagination($featured_query->max_num_pages); }
	
		$output_string = ob_get_contents();
		ob_end_clean(); 
	
		wp_reset_query();
	
		return $output_string;

	}
}
add_shortcode("posts", "gp_posts");

?>