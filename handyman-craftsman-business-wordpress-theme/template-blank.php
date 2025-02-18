<?php
/**
 * Template Name: Blank Template
 *
 * The template for displaying a full width page without Contact and Map sections
 */

/**
 * Inner pages header
 */
get_header('handyman-inner');

/**
 * Include Header image & main navigation
 */
get_template_part('partials/header','page-featured' );
?>
    <section id="post-<?php the_ID(); ?>" <?php post_class( 'content-main container clearfix' ); ?>>
        <div class="grid">
        <?php if( have_posts() ) : ?>
            <?php while( have_posts() ) : the_post(); ?>
                    <article class="column-flush span-12">
                        <?php get_template_part( 'partials/content', 'handy-single' ); ?>
                    </article>
            <?php endwhile; // while has_post(); ?>
        <?php endif; // if has_post() ?>
        </div>
    </section>
<?php get_footer();