<?php

	/*	
	*	Goodlayers Include Script File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		Goodlayers
	* 	@link		http://goodlayers.com
	* 	@copyright	Copyright (c) Goodlayers
	*	---------------------------------------------------------------------
	*	This file manage to embed the stylesheet and javascript to each page
	*	based on the content of that page.
	*	---------------------------------------------------------------------
	*/
	
	add_action('init', 'register_all_gdl_scripts');
	function register_all_gdl_scripts(){
	
		//wp_deregister_script('jquery');
		//wp_register_script('jquery', GOODLAYERS_PATH.'/include/javascript/jquery.js', false, '1.7.1', false);
		wp_enqueue_script('jquery');
		
		if( $GLOBALS['pagenow'] != 'wp-login.php' ){
			if(is_admin()){
			
				wp_enqueue_style('gdl-back-office', GOODLAYERS_PATH.'/include/stylesheet/gdl-back-office.css');
				add_action('add_meta_boxes', 'register_meta_script');
				
			}else{
				
				wp_enqueue_style('style-custom', GOODLAYERS_PATH.'/style-custom.php');
				add_action('wp_print_styles','register_non_admin_styles');
				add_action('wp_print_scripts','register_non_admin_scripts');
				
			}
		}
		
	}
	/* 	---------------------------------------------------------------------
	*	This section include the back-end script
	*	---------------------------------------------------------------------
	*/ 
	
	function register_meta_script(){
		global $post_type;
		
		wp_enqueue_style('ie-style',GOODLAYERS_PATH . '/stylesheet/ie-style.php?path=' . GOODLAYERS_PATH);		
		
		// register style and script when access to the "page" post_type page
		if( $post_type == 'page' ){
		
			wp_enqueue_style('meta-css',GOODLAYERS_PATH.'/include/stylesheet/meta-css.css');
			wp_enqueue_style('page-dragging',GOODLAYERS_PATH.'/include/stylesheet/page-dragging.css');
			wp_enqueue_style('image-picker',GOODLAYERS_PATH.'/include/stylesheet/image-picker.css');
			wp_enqueue_style('confirm-dialog',GOODLAYERS_PATH.'/include/stylesheet/jquery.confirm.css');

			wp_deregister_script('image-picker');
			wp_register_script('image-picker', GOODLAYERS_PATH.'/include/javascript/image-picker.js', false, '1.0', true);
			wp_enqueue_script('image-picker');
		
			wp_deregister_script('page-dragging');
			wp_register_script('page-dragging', GOODLAYERS_PATH.'/include/javascript/page-dragging.js', false, '1.0', true);
			wp_enqueue_script('page-dragging');
			
			wp_deregister_script('edit-box');
			wp_register_script('edit-box', GOODLAYERS_PATH.'/include/javascript/edit-box.js', false, '1.0', true);
			wp_enqueue_script('edit-box');

			wp_deregister_script('confirm-dialog');
			wp_register_script('confirm-dialog', GOODLAYERS_PATH.'/include/javascript/jquery.confirm.js', false, '1.0', true);
			wp_enqueue_script('confirm-dialog');
			
		// register style and script when access to the "post" post_type page
		}else if( $post_type == 'post' || $post_type == 'portfolio' || $post_type == 'gallery' ){
		
			wp_enqueue_style('meta-css',GOODLAYERS_PATH.'/include/stylesheet/meta-css.css');
			wp_enqueue_style('image-picker',GOODLAYERS_PATH.'/include/stylesheet/image-picker.css');
			wp_enqueue_style('confirm-dialog',GOODLAYERS_PATH.'/include/stylesheet/jquery.confirm.css');
			
			wp_deregister_script('post-effects');
			wp_register_script('post-effects', GOODLAYERS_PATH.'/include/javascript/post-effects.js', false, '1.0', true);
			wp_enqueue_script('post-effects');
			
			wp_deregister_script('image-picker');
			wp_register_script('image-picker', GOODLAYERS_PATH.'/include/javascript/image-picker.js', false, '1.0', true);
			wp_localize_script( 'image-picker', 'URL', array('goodlayers' => GOODLAYERS_PATH ));
			wp_enqueue_script('image-picker');
			
			wp_deregister_script('confirm-dialog');
			wp_register_script('confirm-dialog', GOODLAYERS_PATH.'/include/javascript/jquery.confirm.js', false, '1.0', true);
			wp_enqueue_script('confirm-dialog');
		
		// register style and script when access to the "testimonial" post_type page		
		}else if( $post_type == 'testimonial' ){
		
			wp_enqueue_style('meta-css',GOODLAYERS_PATH.'/include/stylesheet/meta-css.css');
		
		}else if( $post_type == 'price_table' ){
		
			wp_enqueue_style('meta-css',GOODLAYERS_PATH.'/include/stylesheet/meta-css.css');
			
			wp_deregister_script('price-table-script');
			wp_register_script('price-table-script', GOODLAYERS_PATH.'/include/javascript/price-table-script.js', false, '1.0', true);
			wp_enqueue_script('price-table-script');
		
		}
		
	}
	
	// register script in goodlayers panel
	function register_goodlayers_panel_scripts(){

		wp_enqueue_style('ie-style',GOODLAYERS_PATH . '/stylesheet/ie-style.php?path=' . GOODLAYERS_PATH);	
	
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-slider');
	
		wp_deregister_script('cufon');
		wp_register_script('cufon', GOODLAYERS_PATH.'/javascript/cufon.js', false, '1.0', false);
		wp_enqueue_script('cufon');
	
		wp_deregister_script('gdl-panel');
		wp_register_script('gdl-panel', GOODLAYERS_PATH.'/include/javascript/gdl-panel.js', false, '1.0', true);
		wp_localize_script( 'gdl-panel', 'URL', array('goodlayers' => GOODLAYERS_PATH, 'sample_text' => FONT_SAMPLE_TEXT ));
		wp_enqueue_script('gdl-panel');
		
		wp_deregister_script('mini-color');
		wp_register_script('mini-color', GOODLAYERS_PATH.'/include/javascript/jquery.miniColors.js', false, '1.0', true);
		wp_enqueue_script('mini-color');
		
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		
		wp_deregister_script('confirm-dialog');
		wp_register_script('confirm-dialog', GOODLAYERS_PATH.'/include/javascript/jquery.confirm.js', false, '1.0', true);
		wp_enqueue_script('confirm-dialog');
		
	}
	
	// register style in goodlayers panel
	function register_goodlayers_panel_styles(){
	
		wp_enqueue_style('jquery-ui',GOODLAYERS_PATH.'/include/stylesheet/jquery-ui-1.8.16.custom.css');
		wp_enqueue_style('gdl-panel',GOODLAYERS_PATH.'/include/stylesheet/gdl-panel.css');
		wp_enqueue_style('mini-color',GOODLAYERS_PATH.'/include/stylesheet/jquery.miniColors.css');
		wp_enqueue_style('thickbox');
		wp_enqueue_style('confirm-dialog',GOODLAYERS_PATH.'/include/stylesheet/jquery.confirm.css');
	}
	
	/* 	---------------------------------------------------------------------
	*	this section include the front-end script
	*	---------------------------------------------------------------------
	*/ 
	
	// Register all stylesheet
	function register_non_admin_styles(){
	
		global $post;
		
		// Navigation Menu
		wp_enqueue_style('superfish',GOODLAYERS_PATH.'/stylesheet/superfish.css');
		
		wp_enqueue_style('prettyPhoto',GOODLAYERS_PATH.'/stylesheet/prettyPhoto.css');
		
		if( is_search() || is_archive() ){
		
			wp_enqueue_style('flex-slider',GOODLAYERS_PATH.'/stylesheet/flexslider.css');
			
		// Post post_type
		}else if( isset($post) && $post->post_type == 'post' || 
			isset($post) && $post->post_type == 'portfolio' ){
		
			// If using slider (flex slider)	
			global $gdl_post_thumbnail;
			$gdl_post_thumbnail = get_post_meta($post->ID,'post-option-inside-thumbnail-types', true);
			
			if( $gdl_post_thumbnail == 'Slider'){
			
				wp_enqueue_style('flex-slider',GOODLAYERS_PATH.'/stylesheet/flexslider.css');
				
			}
			
		// Page post_type
		}else if( isset($post) && $post->post_type == 'page' ){
		
			global $gdl_page_xml, $gdl_top_slider_type, $gdl_top_slider_xml;
			$gdl_page_xml = get_post_meta($post->ID,'page-option-item-xml', true);
			
			$gdl_top_slider_type = get_post_meta($post->ID,'page-option-top-slider-types', true);
			
			$gdl_top_slider_xml = get_post_meta($post->ID,'page-option-top-slider-xml', true);		
			
			// If using carousel slider
			if(	strpos($gdl_page_xml,'<slider-type>Carousel Slider</slider-type>') > -1 ){
				wp_enqueue_style('picachoose',GOODLAYERS_PATH.'/stylesheet/pikachoose.css');
			}
			
			// If using flex slider
			if(	strpos($gdl_page_xml,'<slider-type>Flex Slider</slider-type>') > -1 || 
				strpos($gdl_page_xml, '<Portfolio>') > -1 ||
				strpos($gdl_page_xml, '<Blog>') > -1 ||
				$gdl_top_slider_type == 'Flex Slider'){
				
				wp_enqueue_style('flex-slider',GOODLAYERS_PATH.'/stylesheet/flexslider.css');
				
			}
			
			if( strpos($gdl_page_xml, '<item-size>1/1 Blog Slide Show</item-size>') > -1 ){
				wp_enqueue_style('elastislide',GOODLAYERS_PATH.'/stylesheet/elastislide.css');
			}
			
		}

	}
	
	// Register all scripts
	function register_non_admin_scripts(){
	
		global $post;
		global $goodlayers_element;		

		// Navigation Menu
		wp_deregister_script('superfish');
		wp_register_script('superfish', GOODLAYERS_PATH.'/javascript/superfish.js', false, '1.0', true);
		wp_enqueue_script('superfish');	

		wp_deregister_script('supersub');
		wp_register_script('supersub', GOODLAYERS_PATH.'/javascript/supersub.js', false, '1.0', true);
		wp_enqueue_script('supersub');			
		
		wp_deregister_script('hover-intent');
		wp_register_script('hover-intent', GOODLAYERS_PATH.'/javascript/hoverIntent.js', false, '1.0', true);
		wp_enqueue_script('hover-intent');			
		
		wp_deregister_script('gdl-scripts');
		wp_register_script('gdl-scripts', GOODLAYERS_PATH.'/javascript/gdl-scripts.js', false, '1.0', true);
		wp_enqueue_script('gdl-scripts');
		
		wp_deregister_script('easing');
		wp_register_script('easing', GOODLAYERS_PATH.'/javascript/jquery.easing.js', false, '1.0', true);
		wp_enqueue_script('easing');
		
		wp_deregister_script('prettyPhoto');
		wp_register_script('prettyPhoto', GOODLAYERS_PATH.'/javascript/jquery.prettyPhoto.js', false, '1.0', true);
		wp_enqueue_script('prettyPhoto');	
				
		wp_deregister_script('fitvids');
		wp_register_script('fitvids', GOODLAYERS_PATH.'/javascript/jquery.fitvids.js', false, '1.0', true);
		wp_enqueue_script('fitvids');	
		
		// Search and archive page
		if( is_search() || is_archive() ){

			$flex_setting = get_gdl_slider_option_array($goodlayers_element['gdl_panel_flex_slider']);
			$flex_setting = array_merge($flex_setting, array('controlsContainer'=>'.flexslider'));
		
			wp_deregister_script('flex-slider');
			wp_register_script('flex-slider', GOODLAYERS_PATH.'/javascript/jquery.flexslider.js', false, '1.0', true);
			wp_localize_script( 'flex-slider', 'FLEX', $flex_setting);
			wp_enqueue_script('flex-slider');	
		
		// Post post_type
		}else if( isset($post) &&  $post->post_type == 'post' || 
			isset($post) &&  $post->post_type == 'portfolio'  ){
		
			// If using slider (flex slider)	
			global $gdl_post_thumbnail;
			
			if( $gdl_post_thumbnail == 'Slider'){
			
				$flex_setting = get_gdl_slider_option_array($goodlayers_element['gdl_panel_flex_slider']);
				$flex_setting = array_merge($flex_setting, array('controlsContainer'=>'.slider-wrapper'));
			
				wp_deregister_script('flex-slider');
				wp_register_script('flex-slider', GOODLAYERS_PATH.'/javascript/jquery.flexslider.js', false, '1.0', true);
				wp_localize_script( 'flex-slider', 'FLEX', $flex_setting);
				wp_enqueue_script('flex-slider');	
				
			}
		
		// Page post_type
		}else if( isset($post) &&  $post->post_type == 'page' ){
			
			global $gdl_page_xml, $gdl_top_slider_type, $gdl_top_slider_xml;
			
			//  If using jcarousellite
			if( strpos($gdl_page_xml,'<display-type>Testimonial Category</display-type>') > -1 ){
				wp_deregister_script('jcarousellite');
				wp_register_script('jcarousellite', GOODLAYERS_PATH.'/javascript/jquery.jcarousellite.js', false, '1.0', true);
				wp_enqueue_script('jcarousellite');
			}

			// If using carousel slider
			if(	strpos($gdl_page_xml,'<slider-type>Carousel Slider</slider-type>') > -1 ){
				$pikachoose_setting = get_gdl_slider_option_array($goodlayers_element['gdl_panel_carousel_slider']);
			
				wp_deregister_script('pikachoose');
				wp_register_script('pikachoose', GOODLAYERS_PATH.'/javascript/jquery.pikachoose.js', false, '1.0', true);
				wp_localize_script( 'pikachoose', 'PIKACHOOSE', $pikachoose_setting);
				wp_enqueue_script('pikachoose');	
			}
			
			// If using flex slider
			if( strpos($gdl_page_xml, '<slider-type>Flex Slider</slider-type>') > -1 ||
				strpos($gdl_page_xml, '<Portfolio>') > -1 ||
				strpos($gdl_page_xml, '<Blog>') > -1 ||
				$gdl_top_slider_type == 'Flex Slider'){
			
				$flex_setting = get_gdl_slider_option_array($goodlayers_element['gdl_panel_flex_slider']);
				$flex_setting = array_merge($flex_setting, array('controlsContainer'=>'.flexslider'));
			
				wp_deregister_script('flex-slider');
				wp_register_script('flex-slider', GOODLAYERS_PATH.'/javascript/jquery.flexslider.js', false, '1.0', true);
				wp_localize_script( 'flex-slider', 'FLEX', $flex_setting);
				wp_enqueue_script('flex-slider');	
					
			}
			
			// If using filterable plugin
			if( strpos($gdl_page_xml,'<filterable>Yes</filterable>') > -1 ){
			
				wp_deregister_script('filterable');
				wp_register_script('filterable', GOODLAYERS_PATH.'/javascript/jquery.filterable.js', false, '1.0', true);
				wp_enqueue_script('filterable');				
			
			}
			
			// If use contact-form
			if( strpos($gdl_page_xml,'<Contact-Form>') > -1 ){
			
				wp_deregister_script('contact-form');
				wp_register_script('contact-form', GOODLAYERS_PATH.'/javascript/gdl-contactform.js', false, '1.0', true);
				wp_localize_script( 'contact-form', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
				wp_enqueue_script('contact-form');				
						
			}
			
			if( strpos($gdl_page_xml, '<item-size>1/1 Blog Slide Show</item-size>') > -1 ){
				$elastislide_setting = get_gdl_slider_option_array($goodlayers_element['gdl_panel_elastislide']);
			
				wp_deregister_script('elastislide');
				wp_register_script('elastislide', GOODLAYERS_PATH.'/javascript/jquery.elastislide.js', false, '1.0', true);
				wp_localize_script( 'elastislide', 'ELASTISLIDE', $elastislide_setting);
				wp_enqueue_script('elastislide');	
			}			
			
		}
	
		// Comment Script
		if(is_singular() && comments_open() && get_option('thread_comments')){
		
			wp_enqueue_script( 'comment-reply' ); 
			
		}

	}
?>