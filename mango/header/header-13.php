<?php
/**
 * The template for header 13
 *
 *
 * @package WordPress
 * @subpackage mango
 * @since mango 1.0
 */
global $mango_settings, $mobile_menu, $search_button_class,$filter;
?>
<header id="header" class="header11 mango_header13" role="banner">
    <div class="container">
        <div id="header-top" class="clearfix">
            <div class="nav-left">
                <div class="header-row">
                    <?php get_template_part("inc/language"); ?>
                    <?php mango_phone_info() ?>
                </div><!-- End .header-row -->
            </div><!-- End .nav-left -->
            <div class="nav-right">
                <?php get_template_part("inc/social-icons"); ?>
            </div><!-- End .nav-left -->
        </div><!-- End #header-top -->
        <div id="header-inner" class="clearfix">
            <div class="nav-logo nav-left">
                <h1 class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo get_bloginfo("description"); ?>"><img src="<?php echo esc_url(mango_get_logo_url());?>" alt="<?php bloginfo("title") ?>"></a><span><?php echo get_bloginfo("description"); ?></span></h1>
            </div><!-- End .nav-left -->
            <div class="nav-center nav-left">
                <?php mango_get_header_box(13); ?>
            </div><!-- End .nav-center -->
            <div class="nav-right">
                <div class="header-row">			
				<?php if($mango_settings['show-loginform']){?>				
				<?php if(is_user_logged_in()){ ?>					 
				<div class="dropdown language-dropdown btt-dropdown">										
				<a class="dropdown-toggle header-link" href="#"  id="logout-dropdown" data-toggle="dropdown" aria-expanded="true">		
				<i class="fa fa-user"></i><span class="header-text"><?php _e("My Account",'mango')?></span><i class="fa fa-caret-down"></i> 
				</a> 					
				<ul class="dropdown-menu" role="menu">										
				<li  role="presentation" tabindex="-1" href="<?php 	echo wp_logout_url( home_url() ); ?>">						
				<a href="<?php 	echo wp_logout_url( home_url() ); ?>">					<i class="fa fa-sign-out"></i>			
				<span class="">						
				<?php _e("Logout",'mango') ;?>					
				</span>						
				</a>						 				
				</li>						
				<li  role="presentation" tabindex="-1" href="<?php 	echo wp_logout_url( home_url() ); ?>">				
				<a href="<?php echo site_url('my-account'); ?>">						<i class="fa fa-user"></i>							
				<span class="">							
				<?php _e("My Account",'mango') ;?>					
				</span>					
				</a>						 					
				</li>					
				<ul>						
				</div>					
				<?php  }else { ?>			
				<div class="dropdown search-dropdown ">			
				<a class="dropdown-toggle  " href="<?php echo site_url('login');  ?>">			<i class="fa fa-lock"></i>				
				<span class="header-text">						
				<?php _e("Login",'mango') ?>					
				</span>							
				</a>						
				</div>					
				<?php } } ?>				
                   <?php mango_compare_wishlist_links() ?>
                    <?php mango_minicart(); ?>
                    <?php if($mobile_menu){ ?>
                        <button type="button" id="mobile-menu-btn">
                            <span class="sr-only"><?php __("Toggle navigation",'mango') ?></span>
                            <i class="fa fa-navicon"></i>
                        </button>
                    <?php } ?>
                </div><!-- End .header-row -->
            </div><!-- End .nav-right -->
        </div><!-- End #header-inner -->
        <div id="menu-container" class="sticky-menu fullwidth-sticky">
           <div class="row">
               <div class="container">
                    <div class="nav-left">
                        <span class="menu-cat-top-title"><?php
                            echo ($mango_settings['mango_header13_left_title'])? esc_attr($mango_settings['mango_header13_left_title']) :__('Product Categories','mango');
                            ?></span>
                    </div><!-- End .nav-left -->
                    <nav class="nav-center">
                        <?php if($mango_settings['show-searchform']) {
                            $search_button_class = " btn-custom2";
                             get_template_part("inc/mango_searchform");
                        } ?>
                        <?php if(has_nav_menu('main_menu')) { ?>
                                    <?php
                                    wp_nav_menu (
                                        array (
                                            'theme_location' => 'main_menu',
                                            'menu_id' => 'menu-main-navigation',
                                            'menu_class' => 'menu ttb-dropdown',
                                            "depth" => 5,
                                            'container'       => false,
                                            'walker' => new mango_top_navwalker
                                        ) );
                              }  ?>
                    </nav>
                    <div class="nav-right">
                        <?php if(has_nav_menu('main_menu')) { ?>
                            <a href="#" id="menu-display-btn"><i class="fa fa-navicon"></i><i class="fa fa-times"></i><?php _e("Menu",'mango') ?></a>
                        <?php } ?>
                    </div><!-- End nav-right -->
                </div><!-- End .container -->
            </div><!-- end .row -->
        </div><!-- End .menu-cotainer -->
    </div><!-- End .container -->
</header><!-- End #header -->