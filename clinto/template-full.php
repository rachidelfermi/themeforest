<?php /* Template Name: FullPage */ ?>

<?php get_header(); ?>
<?php get_template_part( 'partials/primary-nav' ); ?>

<section class="container">

	<!-- Article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_content' ); ?>>

		<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>

			<?php if ( has_post_thumbnail() ) : // the current post has a thumbnail

					//Get the Thumbnail URL
					$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'slides', false, '' ); ?>

					<div class="row-fluid">
						<div class="span12 header" style="background-image:url(<?php echo $src[0] ?>); ">
							<div class="carousel-caption span8 offset2">
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							</div>
						</div>
					</div>

			<?php endif; ?>

			<div class="row-fluid">
				<div class="offset2 span8 entry">

					<?php the_content(); ?>

				</div>
			</div>

		<?php endwhile; else: ?>

			<div class="row-fluid">
				<div class="offset2 span8 entry">

					<!-- Post Title -->
					<h2 class="post-title"><?php _e( 'Sorry, nothing to display.', 'spritz' ); ?></h2>
					<p><?php _e( 'You are looking for an empty page. We are sorry for the inconvenience.', 'spritz' ); ?></p>
					<p><a href="/"><?php _e( 'Return to home', 'spritz' ); ?></a></p>

				</div>
			</div>

		<?php endif; ?>

	</article>
	<!-- /Article -->

</section>

<?php get_footer(); ?>