<?php

	/*
	*	Goodlayers Misc File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		Goodlayers
	* 	@link		http://goodlayers.com
	* 	@copyright	Copyright (c) Goodlayers
	*	---------------------------------------------------------------------
	*	This file contains all of the necessary function for the front-end to
	*	easily used. You can see the description of each function below.
	*	---------------------------------------------------------------------
	*/
	
	// Get sidebar size array
	function gdl_get_sidebar_size( $sidebar = ''){
		global $sidebar_type;
		
		$sidebar_type = 'no-sidebar';
		$sidebar_array = array('sidebar_class'=>'','page_left_class'=>'twelve columns', 'page_item_class'=>'twelve columns');
		if( $sidebar == "left-sidebar" ){
			$sidebar_type = 'one-sidebar';
			$sidebar_array['sidebar_class'] = "single-sidebar left-sidebar";
			$sidebar_array['page_left_class']= "twelve columns";
			$sidebar_array['page_item_class'] = "eight columns";
		}else if( $sidebar == "right-sidebar" ){
			$sidebar_type = 'one-sidebar';		
			$sidebar_array['sidebar_class'] = "single-sidebar right-sidebar";	
			$sidebar_array['page_left_class'] = "eight columns";	
			$sidebar_array['page_item_class'] = "twelve columns";					
		}else if( $sidebar == "both-sidebar" ){
			$sidebar_type = 'both-sidebar';	
			$sidebar_array['sidebar_class'] = "both-sidebar";
			$sidebar_array['page_left_class'] = "nine columns";		
			$sidebar_array['page_item_class'] = "eight columns";
		}	
		
		return $sidebar_array;
	}
	
	// Check if url is from which type of video
	function get_video($url, $width = 640, $height = 480){
	
		if(strpos($url,'youtube')){		
			get_youtube($url, $width, $height);
		}else if(strpos($url,'youtu.be')){
			get_youtube($url, $width, $height, 'youtu.be');
		}else if(strpos($url,'vimeo')){
			get_vimeo($url, $width, $height);
		}
	}
	
	// Print HTML5 Video
	function get_html5_video($video){
		if(function_exists('jwplayer_tag_callback')){
			echo jwplayer_tag_callback($video);
		}
	}
	
	// Print youtube video
	function get_youtube($url, $width = 640, $height = 480, $type = 'youtube', $return = false){
		if( $type == 'youtube' ){
			preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$url,$id);
		}else{
			preg_match('/youtu.be\/([^\\?\\&]+)/', $url, $id);
		}
		
		$attr = "";
		if( strpos($url, 'autoplay=1') > 0 ) $attr = "&autoplay=1";		
		if( strpos($url, 'rel=0') > 0 ) $attr = $attr . "&rel=0";		
		
		if( !$return ){
			echo '<iframe src="http://www.youtube.com/embed/' . $id[1] . '?wmode=transparent' . $attr . '" width="' . $width . '" height="' . $height . '" ></iframe>';
		}else{
			return '<iframe src="http://www.youtube.com/embed/' . $id[1] . '?wmode=transparent' . $attr . '" width="' . $width . '" height="' . $height . '" ></iframe>';
		}
	}
	
	// Print vimeo video
	function get_vimeo($url, $width = 640, $height = 480, $return = false){
		preg_match('/https?:\/\/vimeo.com\/(\d+)$/', $url, $id);
		
		if( !$return ){
			echo '<iframe src="http://player.vimeo.com/video/' . $id[1] . '?title=0&amp;byline=0&amp;portrait=0" width="' . $width . '" height="' . $height . '"></iframe>';
		}else{
			return '<iframe src="http://player.vimeo.com/video/' . $id[1] . '?title=0&amp;byline=0&amp;portrait=0" width="' . $width . '" height="' . $height . '"></iframe>';
		}
	}
	
	function print_custom_slider($slider_xml, $size='full', $height = 560){
		echo '<div class="custom-slider" id="gdl-custom-slider">';

		$caption_array = array(); 
		$caption_num = 0;	
		
		$active = 'active';
		echo '<div class="custom-slides">';
		foreach($slider_xml->childNodes as $slider){
			$caption = html_entity_decode(find_xml_value($slider, 'caption'));
			$image_url = wp_get_attachment_image_src(find_xml_value($slider, 'image'), $size);
			$alt_text = get_post_meta(find_xml_value($slider, 'image') , '_wp_attachment_image_alt', true);
				
			echo '<div class="' . $active . '" style="background: url(\'' . $image_url[0] . '\') center 0px no-repeat;" ';
			if ( !empty($caption)){
				$caption_array[$caption_num] = $caption;
				echo ' data-caption="caption-' . $caption_num . '"';
				$caption_num++;
			}			
			echo ' ></div>';
			
			$active = '';
		}		
		echo '</div>';
		
		$active = 'active';
		echo '<div class="custom-caption-row row">';
		echo '<div class="custom-caption-column twelve columns mb0" data-height="' . $height . '" style="height: ' . $height . 'px;">';
		for( $i=0; $i<$caption_num; $i++ ){
			echo '<div class="custom-caption ' . $active . '" data-caption="caption-' . $i . '" >';
			echo '<span class="gdl-slider-title">';
			echo $caption_array[$i];
			echo '</span>';
			echo '</div>';
			
			$active = '';
		}		
		echo '</div>';
		echo '</div>';
		
		echo '<div class="custom-slider-nav-wrapper">';
		echo '<div class="custom-slider-nav"></div>';
		echo '</div>';
		
		echo '</div>'; // gdl-custom-slider
	}
	
	// Print nivo slider
	function print_nivo_slider($slider_xml, $size='940x360'){
		if( empty($slider_xml) ) return;

		global $gdl_element_id;
		
		$caption_array = array(); 
		$caption_num = 0;	
		
		echo '<div class="nivoSliderWrapper">';
		echo '<div class="nivoSlider gdl-slider">';	
		foreach($slider_xml->childNodes as $slider){
			$title = find_xml_value($slider, 'title');
			$caption = html_entity_decode(find_xml_value($slider, 'caption'));
			$link = find_xml_value($slider, 'link');
			$link_type = find_xml_value($slider, 'linktype');
			$image_url = wp_get_attachment_image_src(find_xml_value($slider, 'image'), $size);
			$alt_text = get_post_meta(find_xml_value($slider, 'image') , '_wp_attachment_image_alt', true);
			
			if($link_type == 'Lightbox'){
				$image_full_url = wp_get_attachment_image_src(find_xml_value($slider, 'image'), 'full');
				echo '<a data-rel="fancybox" data-fancybox-group="gal' . $gdl_element_id . '" href="' . $image_full_url[0] . '"  title="' . $alt_text . '">';	
			}else if($link_type == 'Link to Video'){
				echo '<a data-rel="fancybox" data-fancybox-group="gal' . $gdl_element_id . '" href="' . $link . '"  title="' . $alt_text . '">';	
			}else if($link_type != 'No Link'){
				echo '<a href="' . $link . '" >';
			}
				
			echo '<img class="gdl-no-preload" src="' . $image_url[0];
			if ( !empty($title) || !empty($caption)){
				$caption_array[$caption_num]['title'] = $title;
				$caption_array[$caption_num]['caption'] = $caption;
				echo '" title="#nivo-caption' . $caption_num;
				$caption_num++;
			}			
			echo '" alt="' . $alt_text . '" />';
			
			if($link_type != 'No Link'){
				echo '</a>';
			}
		}
		echo "</div>"; // nivo slider
		echo "</div>"; // nivo slider wrapper
		
		for( $i=0; $i<$caption_num; $i++ ){
			echo "<div class='nivo-caption' id='nivo-caption" . $i . "' >";
			if( !empty($caption_array[$i]['title']) ){
				echo "<h2 class='gdl-slider-title'>" . $caption_array[$i]['title'] . "</h2>";
				echo "<div class='clear'></div>";
			}
			if( !empty($caption_array[$i]['caption']) ){
				echo "<div class='gdl-slider-caption'>" . $caption_array[$i]['caption'] . "</div>";
				echo "<div class='clear'></div>";
			}
			echo "</div>";
		}
		
		 $gdl_element_id++;
	}

	// Print flex slider
	function print_flex_slider($slider_xml, $size="940x360"){
		if( empty($slider_xml) ) return;
		
		global $gdl_element_id;
		
		echo '<div class="flexslider gdl-slider" >';
		echo '<ul class="slides">';
		foreach($slider_xml->childNodes as $slider){
		
			$title = find_xml_value($slider, 'title');
			$caption = html_entity_decode(find_xml_value($slider, 'caption'));
			$link = find_xml_value($slider, 'link');
			$link_type = find_xml_value($slider, 'linktype');
			$image_url = wp_get_attachment_image_src(find_xml_value($slider, 'image'), $size);
			$alt_text = get_post_meta(find_xml_value($slider, 'image') , '_wp_attachment_image_alt', true);
			
			echo '<li>';
			if($link_type == 'Lightbox'){
				$image_full_url = wp_get_attachment_image_src(find_xml_value($slider, 'image'), 'full');
				echo '<a data-rel="fancybox" data-fancybox-group="gal' . $gdl_element_id . '" href="' . $image_full_url[0] . '"  title="' . $alt_text . '">';	
			}else if($link_type == 'Link to Video'){
				echo '<a data-rel="fancybox" data-fancybox-group="gal' . $gdl_element_id . '" href="' . $link . '"  title="' . $alt_text . '">';	
			}else if($link_type != 'No Link'){
				echo '<a href="' . $link . '" >';
			}
				
			echo '<img src="' . $image_url[0] . '" alt="' . $alt_text . '" />';
			if( !empty($title) || !empty($caption) ){
				echo '<div class="flex-caption">';
				if( !empty($title) ){
					echo '<h2 class="gdl-slider-title">' . $title . '</h2>';
					echo "<div class='clear'></div>";
				}
				if( !empty($caption) ){
					echo '<div class="gdl-slider-caption">'. $caption . '</div>';
					echo "<div class='clear'></div>";
				}
				echo '</div>'; 
			}
			
			if($link_type != 'No Link'){
				echo '</a>';
			}
			echo '</li>';
			
		}
		echo "</ul>";
		
		$gdl_element_id++;
		echo "</div>"; // flex slider
	}
	
	
	// Print carousel slider
	function print_carousel_slider($slider_xml, $size="940x360"){
		if( empty($slider_xml) ) return;
		
		global $gdl_element_id;
		
		echo '<div class="flexslider gdl-slider carousel-included" >';
		echo '<ul class="slides">';
		foreach($slider_xml->childNodes as $slider){
		
			$title = find_xml_value($slider, 'title');
			$caption = html_entity_decode(find_xml_value($slider, 'caption'));
			$link = find_xml_value($slider, 'link');
			$link_type = find_xml_value($slider, 'linktype');
			$image_url = wp_get_attachment_image_src(find_xml_value($slider, 'image'), $size);
			$alt_text = get_post_meta(find_xml_value($slider, 'image') , '_wp_attachment_image_alt', true);
			
			echo '<li>';
			if($link_type == 'Lightbox'){
				$image_full_url = wp_get_attachment_image_src(find_xml_value($slider, 'image'), 'full');
				echo '<a data-rel="fancybox" data-fancybox-group="gal' . $gdl_element_id . '" href="' . $image_full_url[0] . '"  title="' . $alt_text . '">';	
			}else if($link_type == 'Link to Video'){
				echo '<a data-rel="fancybox" data-fancybox-group="gal' . $gdl_element_id . '" href="' . $link . '"  title="' . $alt_text . '">';	
			}else if($link_type != 'No Link'){
				echo '<a href="' . $link . '" >';
			}
				
			echo '<img src="' . $image_url[0] . '" alt="' . $alt_text . '" />';
			if( !empty($title) || !empty($caption) ){
				echo '<div class="flex-caption">';
				if( !empty($title) ){
					echo '<h2 class="gdl-slider-title">' . $title . '</h2>';
					echo "<div class='clear'></div>";
				}
				if( !empty($caption) ){
					echo '<div class="gdl-slider-caption">'. $caption . '</div>';
					echo "<div class='clear'></div>";
				}
				echo '</div>'; 
			}
			
			if($link_type != 'No Link'){
				echo '</a>';
			}
			echo '</li>';
			
		}
		echo "</ul>";
		
		$gdl_element_id++;
		echo "</div>"; // flex slider
		
		$thumbnail_width = get_option(THEME_SHORT_NAME.'_flex_thumbnail_width', '75');
		$thumbnail_height = get_option(THEME_SHORT_NAME.'_flex_thumbnail_height', '50');
		
		echo '<div class="flex-carousel carousel-included">';
		echo '<ul class="slides">';
		foreach($slider_xml->childNodes as $slider){
			$image_url = wp_get_attachment_image_src(find_xml_value($slider, 'image'), $thumbnail_width . 'x' . $thumbnail_height );
			$alt_text = get_post_meta(find_xml_value($slider, 'image') , '_wp_attachment_image_alt', true);
			
			echo '<li>';	
			echo '<img src="' . $image_url[0] . '" alt="' . $alt_text . '" />';
			echo '</li>';
		}
		echo "</ul>"; // slides		
		echo '</div>'; // flex-carousel		
	}
	
	// Print anything slider
	function print_anything_slider($slider_xml, $size='940x360'){
		if( empty($slider_xml) ) return;
		
		global $gdl_element_id;

		echo '<ul id="slider" class="anythingSlider gdl-slider" style="width:' . gdl_get_width($size) . 'px; height:' . gdl_get_height($size). 'px;">';
		foreach($slider_xml->childNodes as $slider){
		
			$title = find_xml_value($slider, 'title');
			$caption = html_entity_decode(find_xml_value($slider, 'caption'));
			$link = find_xml_value($slider, 'link');
			$link_type = find_xml_value($slider, 'linktype');
			$image_url = wp_get_attachment_image_src(find_xml_value($slider, 'image'), $size);
			$alt_text = get_post_meta(find_xml_value($slider, 'image') , '_wp_attachment_image_alt', true);
			
			echo '<li>';
			
			if($link_type == 'Link to Video'){
				echo get_video($link, gdl_get_width($size), gdl_get_height($size));	
			}else{
			
				if($link_type == 'Lightbox'){
					$image_full_url = wp_get_attachment_image_src(find_xml_value($slider, 'image'), 'full');
					echo '<a data-rel="fancybox" data-fancybox-group="gal' . $gdl_element_id . '" href="' . $image_full_url[0] . '"  title="' . $alt_text . '">';	
				}else if($link_type != 'No Link'){
					echo '<a href="' . $link . '" alt="" >';
				}
			
				echo '<img src="' . $image_url[0] . '" alt="' . $alt_text . '" />';
				if(!empty($title) || !empty($caption)){
					echo '<div class="anything-caption">';
					if( !empty($title) ){
						echo '<h2 class="gdl-slider-title">' . $title . '</h2>';
						echo "<div class='clear'></div>";
					}
					if( !empty($caption) ){
						echo '<div class="gdl-slider-caption">' . $caption . '</div>';
						echo "<div class='clear'></div>";
					}
					echo '</div>';
					
				};
					
				if($link_type != 'No Link'){
					echo '</a>';
				}
			}
			echo '</li>';
		}
		echo "</ul>";
		
		$gdl_element_id ++;
	}
	
	// send contact form email
	add_action('wp_ajax_submit_contact_form','gdl_submit_contact_form');
	add_action('wp_ajax_nopriv_submit_contact_form','gdl_submit_contact_form');
	function gdl_submit_contact_form(){

		global $gdl_admin_translator;
		
		if( $gdl_admin_translator == 'enable' ){
			$gdl_send_complete = get_option(THEME_SHORT_NAME.'_translator_contact_send_complete', 'The e-mail was sent successfully');
			$gdl_send_error = get_option(THEME_SHORT_NAME.'_translator_contact_send_error', 'Message cannot be sent to destination');
		}else{
			$gdl_send_complete = __('The e-mail was sent successfully','gdl_front_end');
			$gdl_send_error =  __('Message cannot be sent to destination','gdl_front_end');
		}	
		
		$return_data = array('success'=>'0');
		
		if(empty($_POST)){
			$return_data['value'] = 'Cannot send email to destination. No parameter receive form AJAX call.';	
			die ( json_encode($return_data) );
		}
		
		$name = $_POST['name'];		
		if(empty($name)){
			$return_data['value'] = 'Please enter your name.';
			die ( json_encode($return_data) );
		}
		
		$email = $_POST['email'];
		if(empty($email)){
			$return_data['value'] = 'Please enter a valid email address.';
			die ( json_encode($return_data) );		
		}
		
		$message = $_POST['message'];
		if(empty($message)){ 
			$return_data['value'] = 'Please enter message.';
			die ( json_encode($return_data) );				
		}
		
		$receiver = $_POST['receiver'];
		
		$messages = "You have received a new contact form message. \n";
		$messages = $messages . 'Name : ' . $name . " \n";
		$messages = $messages . 'Email : ' . $email . " \n";
		$messages = $messages . 'Message : ' . $message;
		
		$header = "From: " . $name . " <" . $email . "> \r\n";
		$header = $header . "Reply-To: " . $receiver . " \r\n";
		$header = $header . 'Content-Type: text/plain; charset=UTF-8 ' . " \r\n";
		
		if( wp_mail($receiver, 'New contact form received', $messages, $header) ){
			$return_data['success'] = '1';
			$return_data['value'] = $gdl_send_complete;
			die( json_encode($return_data) );
		}else{
			$return_data['value'] = $gdl_send_error;
			die( json_encode($return_data) );	
		}
		
	}	
?>