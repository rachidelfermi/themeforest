<?php
/**
 * Recent Posts - Audio Post Format
 *
 * @package	HelpingHands
 * @author Skat
 * @copyright 2015, Skat Design
 * @link http://www.skat.tf
 * @since HelpingHands 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'sd-blog-entry sd-standard-entry clearfix sd-content-wide' ); ?>> 
	<div class="sd-entry-wrapper clearfix"> 
		<div class="row">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="col-md-4 col-sm-4 col-md-push-8 col-sm-push-8">
					<div class="sd-entry-thumb">
						<figure>
							<?php the_post_thumbnail( 'sd-latest-blog' ); ?>
						</figure>
					</div>
					<!-- sd-entry-thumb -->
				</div>
				<!-- col-md-4 -->
			<?php endif; ?>
			<div class="col-md-8 col-sm-8 col-md-pull-4 col-sm-pull-4">
				<!-- sd-entry-audio -->
				<div class="sd-entry-content">
					<header>
						<div class="sd-content-wrap">
							<h3 class="sd-entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink la %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">	<?php the_title(); ?></a>
							</h3>
							<div class="sd-latest-blog-meta">
								<span class="sd-latest-blog-date"><?php the_time( get_option( 'date_format') ); ?></span> <?php echo _x( 'BY', 'by author', 'sd-framework' ); ?>
								<span class="sd-latest-author-date"><?php the_author(); ?></span>
							</div>
						</div>
					</header>
					<p class="sd-latest-blog-excerpt"><?php echo $post->post_excerpt; ?></p>
					<a class="sd-more sd-link-trans" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e( 'LÆS MERE', 'sd-framework' ); ?></a>
				</div>
				<!-- sd-entry-content -->
			</div>
			<!-- col-md-8 -->
		</div>
		<!-- row -->
	</div>
	<!-- sd-entry-wrapper -->
</article>
