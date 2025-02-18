<?php

/*--------------------------------------------------*/
/* Template Name: Event #2
/*--------------------------------------------------*/

get_header();

if (is_front_page()) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
}

$number      = get_post_meta($post->ID, "page_number", true);
$category    = get_post_meta($post->ID, "page_category", true);
$page_layout = wize_page_sidebar_layout();
$page_slider = wize_page_slider_layout();
if (!$category) {
    $query = array(
        'post_type' => 'event',
        'posts_per_page' => $number,
        'paged' => $paged
    );
} else {
    $query = array(
        'post_type' => 'event',
        'posts_per_page' => $number,
        'paged' => $paged,
        'tax_query' => array(
            array(
                'taxonomy' => 'events',
                'field' => 'slug',
                'terms' => $category
            )
        )
    );
}

switch ($page_slider) {
    case "sliderfull":
        require_once('slider-full.php');
    break;
    
    case "sliderboxed":
        require_once('slider-boxed.php');
    break;
}

echo '	
	<div id="wrap" class="fixed">';
	
if (!is_front_page()) {
    echo '
	<div class="page-title">
		<h1 class="blog">' . get_the_title() . '</h1>
	</div>';
}

switch ($page_layout) {
    case "sidebar-left":
        echo '
	<div id="blog-right">';
    break;
		
    case "sidebar-full":
        echo '
	<div id="blog-full">';
    break;
		
    case "sidebar-right":
        echo '
	<div id="blog-left">';
    break;
}

$wp_query = new WP_Query($query);
if (have_posts())
    while ($wp_query->have_posts()):
        $wp_query->the_post();
		global $post;
        $image_id   = get_post_thumbnail_id($post->ID);
        $cover      = wp_get_attachment_image_src($image_id, 'AdMx');
        $cover_full = wp_get_attachment_image_src($image_id, 'photo-large');
        $no_cover   = get_template_directory_uri();
        $venue      = get_post_meta($post->ID, 'ev_venue', true);
        $location   = get_post_meta($post->ID, 'ev_location', true);
        $start      = get_post_meta($post->ID, 'ev_start', true);
        $end        = get_post_meta($post->ID, 'ev_end', true);
        $allday     = get_post_meta($post->ID, 'ev_allday', true);  
        $coord 		= get_post_meta($post->ID, 'ev_coordinated', true);
        $date  		= get_post_meta($post->ID, 'ev_date', true);
		require('includes/language.php');
        $time  		= strtotime($date);
        $day   		= date('d', $time);
        $year  		= date('Y', $time);
        $out        = get_post_meta($post->ID, 'ev_out', true);
        $cancel     = get_post_meta($post->ID, 'ev_cancel', true);
        $free       = get_post_meta($post->ID, 'ev_free', true);
        $disable    = get_post_meta($post->ID, 'ev_disable', true);
        $ticket_url = get_post_meta($post->ID, 'ev_ticket_url', true);
        $text       = get_post_meta($post->ID, 'ev_text', true);
		
		/* display */
        
        echo '
		<div class="ev2">
			<div class="ev2-cover">
				<div class="ev2-bg"></div>';
        if ($image_id) {
            echo '
				<img src="' . esc_url($cover[0]) . '" alt="' . esc_attr(get_the_title()) . '" />';
        } else {
            echo '
				<img src="' . esc_url($no_cover) . '/images/no-cover/ev2.png" alt="no-cover" />';
        }
        echo '
				<a href="' . esc_url($cover_full[0]) . '" class="ev2-zoom" data-rel="prettyPhoto-cover"></a>';
		if ($coord) {
			echo '
				<a href="http://maps.google.com/maps?q=' . esc_attr($coord) . '&output=embed?iframe=true&width=640&height=480" class="ev2-map" data-rel="prettyPhoto"></a>';
		}
		if ($date) {
			echo '
				<div class="ev2-dm">' . esc_html($day, "wizedesign") . ' ' . esc_html($month, "wizedesign") . '</div>
				<div class="ev2-week"><span>' . esc_html($week, "wizedesign") . '</span></div>
				<div class="ev2-year">' . esc_html($year, "wizedesign") . '</div>';
		}
		echo '
			</div><!-- end .ev2-cover -->
			<div class="ev2-text">
				<div class="ev2-title">
					<h2><a href="' . esc_url(get_permalink()) . '">';
        if (strlen($post->post_title) > 65) {
            echo substr(get_the_title($before = '', $after = '', FALSE), 0, 65) . '...';
        } else {
            echo get_the_title();
        }
        echo '</a></h2>
				</div><!-- end .ev2-title -->
				<div class="ev2-info">	
					<div class="ev2-venue">' . esc_html($venue, "wizedesign") . '</div>';
        if ($allday == 'yes') {
            echo '
					<div class="ev2-time">' . esc_html__("All Day", "wizedesign") . '</div>';
        } elseif ($start != null) {
            echo '
					<div class="ev2-time">' . esc_html($start, "wizedesign") . '';
            if ($end != null) {
                echo ' - ';
            }
            echo '' . esc_html($end, "wizedesign") . '</div>';
        }
        echo '
				</div><!-- end .ev2-info -->
				<p>' . wize_excerpt(170) . '</p>
				<div class="ev2-bn">';
        if ($disable == 'no') {
            if ($text) {
                echo '
					<a href="' . esc_url($ticket_url) . '" class="ev2-button">' . esc_html($text, "wizedesign") . '</a>';
            } else {
                if ($out == 'yes') {
                    echo '
					<div class="ev2-none">' . __('Sold Out', 'wizedesign') . '</div>';
                } elseif ($cancel == 'yes') {
                    echo '
					<div class="ev2-none">' . __('Canceled', 'wizedesign') . '</div>';
                } elseif ($free == 'yes') {
                    echo '
					<div class="ev2-none">' . __('Free Entry', 'wizedesign') . '</div>';
                } else {
                    echo '
					<a href="' . esc_url($ticket_url) . '" class="ev2-button">' . esc_html__("Buy Tickets", "wizedesign") . '</a>';
                }
            }
        }
        echo '			
				</div><!-- end .ev2-bn -->
				<div class="ev2-lv">
					' . wize_like_info($post->ID) . '
					<div class="info-view">' . wize_get_views(get_the_ID()) . '</div>
				</div><!-- end .ev2-lv -->
			</div><!-- end .ev2-text -->	
		</div><!-- end .ev2 -->';
		
    endwhile;

if (function_exists("wize_pagination")) {
    wize_pagination();
}

echo '
	</div><!-- end #blog(left&full&right) -->';

switch ($page_layout) {
    case "sidebar-left":
		if ( is_active_sidebar( 'event-two-page' ) ) {
			echo '
	<div id="sidebar-left">';
        dynamic_sidebar( 'event-two-page' );
			echo '
	</div><!-- end #sidebar-left -->';
		}
    break;
		
    case "sidebar-right":
		if ( is_active_sidebar( 'event-two-page' ) ) {
			echo '
	<div id="sidebar-right">';
        dynamic_sidebar( 'event-two-page' );
			echo '
	</div><!-- end #sidebar-right -->';
		}
    break;
}

get_footer();