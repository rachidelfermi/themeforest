<?php

	/*
	*
	*	Custom Portfolio Widget
	*	------------------------------------------------
	*	Swift Framework
	* 	Copyright Swift Ideas 2016 - http://www.swiftideas.net
	*
	*/
	
	// Register widget
	add_action( 'widgets_init', 'init_sf_recent_portfolio' );
	function init_sf_recent_portfolio() { return register_widget('sf_recent_portfolio'); }
	
	class sf_recent_portfolio extends WP_Widget {
	
		function __construct() {
			parent::__construct( 'sf_recent_custom_portfolio', $name = 'Swift Framework Recent Portfolio' );
		}
	
		function widget( $args, $instance ) {
			global $post;
			extract($args);
	
			// Widget Options
			$title 	 = apply_filters('widget_title', $instance['title'] ); // Title		
			$number	 = $instance['number']; // Number of posts to show
			$category	 = $instance['category']; // Category to show
			
			if ($category == "All") {$category = "all";}
			if ($category == "all") {$category = '';}
			$category_slug = str_replace('_', '-', $category);
			
			echo $before_widget;
			
		    if ( $title ) echo $before_title . $title . $after_title;
				
			$recent_portfolio = new WP_Query(
				array(
					'post_type' => 'portfolio',
					'posts_per_page' => $number,
					'portfolio-category' => $category_slug,
					)
			);
			
			if( $recent_portfolio->have_posts() ) : 
			
			?>
			
			<ul class="recent-posts-list">
				
				<?php while( $recent_portfolio->have_posts()) : $recent_portfolio->the_post();
				
				$post_title = get_the_title();
				$post_permalink = get_permalink();
				$thumb_image = get_post_thumbnail_id();
				$thumb_img_url = wp_get_attachment_url( $thumb_image, 'widget-image' );
				$image = sf_aq_resize( $thumb_img_url, 94, 75, true, false);
				$image_alt = sf_get_post_meta($thumb_image, '_wp_attachment_image_alt', true);
				?>
				<li>
					<a href="<?php echo $post_permalink; ?>" class="recent-post-image">
						<?php if ($image) { ?>
						<img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php echo $image_alt; ?>" />
						<?php } ?>
					</a>
					<div class="recent-post-details">
						<a class="recent-post-title" href="<?php echo $post_permalink; ?>" title="<?php echo $post_title; ?>"><?php echo $post_title; ?></a>
					</div>
				</li>
				
				<?php wp_reset_query(); endwhile; ?>
			</ul>
				
			<?php endif; ?>			
			
			<?php
			
			echo $after_widget;
		}
	
		/* Widget control update */
		function update( $new_instance, $old_instance ) {
			$instance    = $old_instance;
				
			$instance['title']  = strip_tags( $new_instance['title'] );
			$instance['number'] = strip_tags( $new_instance['number'] );
			$instance['category'] = strip_tags( $new_instance['category'] );
			return $instance;
		}
		
		/* Widget settings */
		function form( $instance ) {	
		
			    // Set defaults if instance doesn't already exist
			    if ( $instance ) {
					$title  = $instance['title'];
			        $number = $instance['number'];
			        $category = $instance['category'];
			    } else {
				    // Defaults
					$title  = '';
			        $number = '5';
			        $category = '';
			    }
				
				// The widget form
				?>
				<p>
					<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __( 'Title:', 'swift-framework-admin' ); ?></label>
					<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" class="widefat" />
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('number'); ?>"><?php echo __( 'Number of items to show:', 'swift-framework-admin' ); ?></label>
					<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category', 'wp_widget_plugin'); ?></label>
					<select name="<?php echo $this->get_field_name('category'); ?>" id="<?php echo $this->get_field_id('category'); ?>" class="">
					<?php
					$options = sf_get_category_list('portfolio-category');
					foreach ($options as $option) {
						echo '<option value="' . $option . '" id="' . $option . '"', $category == $option ? ' selected="selected"' : '', '>', $option, '</option>';
					}
					?>
					</select>
					</p>
				</p>
		<?php 
		}
	
	}

?>