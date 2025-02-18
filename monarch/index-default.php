<?php

   /**
    * The main template file
    *
    * Default Posts
    *
    * This is the most generic template file in a WordPress theme
    * and one of the two required files for a theme (the other being style.css).
    * It is used to display a page when nothing more specific matches a query.
    * e.g., it puts together the home page when no home.php file exists.
    *
    * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
    *
    * @package WordPress
    * @subpackage Monarch
    * @since Monarch 1.0
    */
   
get_template_part( 'header-panel' ); ?>

<!-- Content -->
<div class="content with-sb clearfix">

<!-- Main -->
<main class="main col-xs-12 col-sm-12 col-md-12 col-lg-7 col-bg-6" role="main">
  <?php if ( have_posts() ) : ?>

  <div id="jp-scroll">
    <?php
      // Start the loop.
      while ( have_posts() ) : the_post();
      
         /*
          * Include the Post-Format-specific template for the content.
          * If you want to override this in a child theme, then include a file
          * called content-___.php (where ___ is the Post Format name) and that will be used instead.
          */
         get_template_part( 'content', get_post_format() );
      
      // End the loop.
      endwhile;
    ?>
  </div>

  <div class="post-wrap pagination">
    <?php
      // Previous/next page navigation.
      the_posts_pagination( array(
        'mid_size' => 4,
        'prev_text'          => esc_html__( '&larr; Previous page', 'monarch' ),
        'next_text'          => esc_html__( 'Next page &rarr;', 'monarch' ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'monarch' ) . ' </span>',
      ) );
    ?>
  </div>
    
  <?php
    // If no content, include the "No posts found" template.
    else :
    get_template_part( 'content', 'none' );
    
    endif;
  ?>
</main>

<!-- Sidebar one and two -->
<?php get_sidebar(); ?>
  
</div>