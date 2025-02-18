<?php
function get_vcm_mental_blog_categories() {
	$blog_categories_raw = get_terms( 'category', 'orderby=name&hide_empty=0' );
	$blog_categories     = array( '' => '' );
	foreach ( $blog_categories_raw as $blog_category ) {
		$blog_categories[ $blog_category->term_id ] = $blog_category->name;
	}

	return $blog_categories;
}

add_filter( 'vc_before_init', 'register_vcm_mental_blog' );
function register_vcm_mental_blog() {
	vc_map( array(
		'icon'            => 'vcm-mental-blog',
		'name'            => __( 'Mentas Blog', 'mental' ),
		"base"            => "vcm_mental_blog", // bind with our shortcode
		"content_element" => true, // set this parameter when element will has a content
		//"is_container" => true, // set this param when you need to add a content element in this element
		"category"        => __( 'Mentas Elements' ),
		// Here starts the definition of array with parameters of our compnent
		"params"          => array(
			array(
				'type'       => 'dropdown',
				'param_name' => 'category',
				'heading'    => __( 'Posts category', 'mental' ),
				'value'      => get_vcm_mental_blog_categories()
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'type',
				'heading'    => __( 'Blog type', 'mental' ),
				'value'      => array(
					__( 'Normal Blog', 'mental' )     => 'vertical',
					__( 'Pinterest Style', 'mental' ) => 'masonry',
					__( 'Full text', 'mental' )       => 'full',
				)
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'load_on_scroll',
				'heading'    => __( 'Load new items on scroll (infinite scroll)', 'mental' ),
				'value'      => array(
					__( 'No', 'mental' )  => 'no',
					__( 'Yes', 'mental' ) => 'yes',
				)
			),
			array(
				'type'       => 'textfield',
				'param_name' => 'items_per_page',
				'heading'    => __( 'Items per page', 'mental' ),
				'value'      => '10'
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'columns_count',
				'heading'    => __( 'Columns count', 'mental' ),
				'value'      => array(
					'2' => '2',
					'3' => '3',
					'4' => '4'
				)
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'show_load_more',
				'heading'    => __( 'Show Load more link', 'mental' ),
				'value'      => array(
					__( 'Yes', 'mental' ) => 'yes',
					__( 'No', 'mental' )  => 'no',
				)
			),
            array(
                'type'       => 'dropdown',
                'param_name' => 'show_excerpt',
                'heading'    => __( 'Show excerpt text', 'mental' ),
                'value'      => array(
                    __( 'Yes', 'mental' ) => 'yes',
                    __( 'No', 'mental' )  => 'no',
                )
            ),
            array(
                'type'       => 'dropdown',
                'param_name' => 'show_read',
                'heading'    => __( 'Show read more button', 'mental' ),
                'value'      => array(
                    __( 'Yes', 'mental' ) => 'yes',
                    __( 'No', 'mental' )  => 'no',
                )
            ),
            array(
                'type'       => 'dropdown',
                'param_name' => 'show_author',
                'heading'    => __( 'Show author', 'mental' ),
                'value'      => array(
                    __( 'Yes', 'mental' ) => 'yes',
                    __( 'No', 'mental' )  => 'no',
                )
            ),
            array(
                'type'       => 'dropdown',
                'param_name' => 'show_date',
                'heading'    => __( 'Show date', 'mental' ),
                'value'      => array(
                    __( 'Yes', 'mental' ) => 'yes',
                    __( 'No', 'mental' )  => 'no',
                )
            ),
            array(
                'type'       => 'dropdown',
                'param_name' => 'show_comments',
                'heading'    => __( 'Show comments', 'mental' ),
                'value'      => array(
                    __( 'Yes', 'mental' ) => 'yes',
                    __( 'No', 'mental' )  => 'no',
                )
            ),
			array(
				'type'       => 'textfield',
				'param_name' => 'id',
				'heading'    => __( 'Blog ID', 'mental' )
			),
		)
	) );
}

add_shortcode( 'vcm_mental_blog', 'vcm_mental_blog_shortcode' );
function vcm_mental_blog_shortcode( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'id'             => 'blog-' . rand( 1, 999 ),
		'category'       => '',
		'type'           => get_mental_option( 'blog_type' ),
		'items_per_page' => get_mental_option( 'blog_items_per_page' ),
		'columns_count'  => get_mental_option( 'blog_masonry_columns' ),
		'show_load_more' => 'yes',
        'show_read' => 'yes',
        'show_excerpt' => 'yes',
        'show_author' => 'yes',
        'show_date' => 'yes',
        'show_comments' => 'yes',
		'load_on_scroll' => get_mental_option( 'blog_load_on_scroll' ) ? 'yes' : 'no'
	), $atts, 'vcm_mental_blog' );

	$atts['columns'] = calc_bootstrap_columns( $atts['columns_count'] );

	ob_start();
	?>

	<div id="<?php echo esc_attr( $atts['id'] ) ?>" class="<?php if ( $atts['type'] == 'masonry' ) {
		echo 'row';
	} ?>
		blog-list isotope-blog <?php echo 'blog-' . esc_attr( $atts['type'] ) ?>"
	     data-options="<?php echo esc_attr( azl_serialize_atts( $atts ) ); ?>">

		<?php vcm_mental_blog_loop( 0, $atts ) ?>

	</div> <!-- blog-default -->

	<?php if ( $atts['load_on_scroll'] == 'yes' ): ?>
		<div class="load-more-block lmb-on-scroll">
			<span class="loading-spinner"></span>
			<span class="no-more-items-sign"><?php _e( 'No more items', 'mental' ) ?></span>
		</div>
	<?php endif ?>

	<?php if ( $atts['show_load_more'] == 'yes' && $atts['load_on_scroll'] == 'no' ): ?>
		<div class="load-more-block">
			<a href="#" class="load-more-button"
			   data-blog-id="<?php echo esc_attr( $atts['id'] ) ?>"><?php _e( 'Load more', 'mental' ) ?></a>
			<span class="loading-spinner"></span>
			<span class="no-more-items-sign"><?php _e( 'No more items', 'mental' ) ?></span>
		</div>
	<?php endif ?>

	<?php
	return ob_get_clean();
}

/**
 * Mental Blog Loop
 *
 * @param int $offset
 * @param array $atts
 */
function vcm_mental_blog_loop( $offset = 0, $atts ) {
	$atts = shortcode_atts( array(
		'category'       => '',
		'type'           => get_mental_option( 'blog_type' ),
		'items_per_page' => get_mental_option( 'blog_items_per_page' ),
        'show_read' => 'yes',
        'show_excerpt' => 'yes',
        'show_author' => 'yes',
        'show_date' => 'yes',
        'show_comments' => 'yes',
		'columns'        => calc_bootstrap_columns( get_mental_option( 'blog_masonry_columns' ) ),
	), $atts, 'vcm_mental_blog' );

	$paged = ceil( $offset / $atts['items_per_page'] ) + 1;

	// Can work with or ID or Slug
	if ( intval( $atts['category'] ) ) {
		$tax_field = "term_id";
	} else {
		$tax_field = "slug";
	}

	if ( ! empty( $atts['category'] ) ) {
		$tax_query = array(
			array(
				'taxonomy' => 'category',
				'terms'    => $atts['category'],
				'field'    => $tax_field,
			)
		);
	} else {
		$tax_query = '';
	}

	query_posts( array(
		'post_type'      => 'post',
		'tax_query'      => $tax_query,
		'post_status'    => 'publish',
		'posts_per_page' => $atts['items_per_page'],
		'paged'          => $paged
	) );
	?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php vcm_mental_blog_item( $atts ); ?>

		<?php
	endwhile;
	wp_reset_query();
	?>
	<?php
}


/**
 * Renders Mental Blog Item
 *
 * @param $atts
 */
function vcm_mental_blog_item( $atts ) {

	$atts = shortcode_atts( array(
		'type'    => get_mental_option( 'blog_type' ),
		'columns' => calc_bootstrap_columns( get_mental_option( 'blog_masonry_columns' ) ),
        'show_read' => 'yes',
        'show_excerpt' => 'yes',
        'show_author' => 'yes',
        'show_date' => 'yes',
        'show_comments' => 'yes'

	), $atts );

	$post_format = get_post_format();

	$supported_post_format = in_array( $post_format, array( 'image', 'gallery', 'quote', 'video', 'audio' ) );

	?>

	<?php if ( $post_format == 'quote' ): // If quote format ?>

		<?php $qoute_format_meta = get_post_meta( get_the_ID(), 'quote_format', true ); ?>

		<div class="<?php if ( $atts['type'] == 'vertical' || $atts['type'] == 'full' ) {
			echo 'big-full';
		} else {
			echo 'col-sm-6 col-md-' . $atts['columns'];
		} ?> blog-item blog-item-quotation isotope-item">
			<blockquote>
				<?php echo wp_kses( get_the_content(), array(
					'cite' => array(),
					'a'    => array( 'href' => array(), 'target' => array() )
				) ); ?>
				<?php if ( ! empty( $qoute_format_meta['author'] ) ): ?>
					<footer><?php echo esc_html( $qoute_format_meta['author'] ); ?></footer>
				<?php endif ?>
			</blockquote>
			<p class="blog-info"><?php _e( 'Posted by', 'mental' ); ?> <?php the_author_posts_link(); ?> on
				<time
					datetime="<?php the_time( 'Y-m-d' ) ?>"><?php the_time( 'F j, Y' ); ?><?php the_time( 'g:i a' ); ?></time>
				/ <a href="<?php comments_link(); ?>"><?php $comments_count = wp_count_comments( get_the_ID() );
					echo (int) $comments_count->approved; ?><?php _e( 'Comments', 'mental' ); ?></a>
			</p>
		</div>

	<?php else: ?>

		<?php
		$item_classes = array();

		if ( $atts['type'] == 'full' ) {
			$item_classes[] = 'big-full';
		} else if ( $atts['type'] == 'masonry' ) {
			$item_classes[] = 'col-sm-6 col-md-' . $atts['columns'];
		} else {
			$item_classes[] = 'big-full';
		}

		if ( is_sticky() )
			$item_classes[] = 'blog-sticky';
		$item_classes[] = 'blog-item';
		$item_classes[] = 'isotope-item';
		?>

		<div class="<?php echo implode( ' ', $item_classes ); ?>">

			<div class="<?php echo ( $atts['type'] == 'vertical' || $atts['type'] == 'full' ) ? 'row' : ''; ?>">

				<?php if ( has_post_thumbnail() || $supported_post_format ): // If post thumbnail exists or supported post format ?>

					<div class="<?php if ( ( $atts['type'] == 'vertical' && ! is_sticky() ) ) {
						echo 'col-sm-6';
					} ?>
							<?php if ( ( $atts['type'] == 'vertical' && is_sticky() ) || $atts['type'] == 'full' )
						echo 'col-sm-12'; ?> blog-image">

						<?php if ( has_post_thumbnail() ): // Check if thumbnail exists {?>

							<a class="img-zoom-hover" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php the_post_thumbnail( ( is_sticky() ? 'large' : 'medium' ) ); ?>

								<?php
								if ( $post_format == 'gallery' ) {
									$post_format_icon = 'fa fa-picture-o';
								} elseif ( $post_format == 'video' )
									$post_format_icon = 'fa fa-play-circle-o';
								elseif ( $post_format == 'audio' )
									$post_format_icon = 'fa fa-music';
								else $post_format_icon = 'fa fa-eye';
								?>
								<i class="hover-icon <?php echo esc_attr( $post_format_icon ); ?>"></i>
							</a>

							<?php //elseif( $atts['type'] == 'full' ): ?>


						<?php elseif ( $post_format == 'video' && $video = get_post_video( get_the_content() ) ): ?>

							<div class="blog-video">
								<div class="responsive-embed">
									<?php echo mental_escape_iframe( $video ); ?>
								</div>
							</div>

						<?php elseif ( $post_format == 'audio' ): ?>

							<div class="blog-audio text-left">
								<?php the_mental_audio_excerpt(); ?>
								<?php the_mental_playlist_excerpt(); ?>
							</div>

						<?php elseif ( $post_format == 'gallery' && $gallery = get_post_gallery( get_the_ID(), false ) ) : // If Post gallery {?>

							<?php
							$img_srcs = array();
							if ( isset( $gallery['ids'] ) ) {
								$img_ids = explode( ',', $gallery['ids'] );
								foreach ( $img_ids as $img_id ) {
									$img_src    = wp_get_attachment_image_src( $img_id, ( is_sticky() ? 'large' : 'medium' ) );
									$img_srcs[] = $img_src[0];
								}
							} elseif ( isset( $gallery['src'] ) ) {
								$img_srcs = $gallery['src'];
							}
							?>

							<?php if ( $img_srcs ): ?>

								<?php $carousel_id = rand( 1, 999 ) ?>

								<div id="carousel-<?php echo (int) $carousel_id ?>" class="carousel slide" data-ride="carousel">

									<!-- Wrapper for slides -->
									<div class="carousel-inner">
										<?php $i = 0;
										foreach ( $img_srcs as $img_src ): ?>
											<div class="item <?php echo ( $i == 0 ) ? 'active' : '' ?>">
												<img src="<?php echo esc_url( $img_src ); ?>" alt="slide">
											</div>
											<?php $i ++; endforeach ?>
									</div>
									<!-- Indicators -->
									<ol class="carousel-indicators">
										<?php $i = 0;
										foreach ( $img_srcs as $img_src ): ?>
											<li data-target="#carousel-<?php echo (int) $carousel_id ?>"
											    data-slide-to="<?php echo (int) $i ?>"
											    class="<?php echo ( $i == 0 ) ? 'active' : '' ?>"></li>
											<?php $i ++; endforeach ?>
									</ol>

									<!-- Controls -->
									<a class="left carousel-control" href="#carousel-<?php echo (int) $carousel_id ?>"
									   data-slide="prev">
										<span></span>
									</a>
									<a class="right carousel-control" href="#carousel-<?php echo (int) $carousel_id ?>"
									   data-slide="next">
										<span></span>
									</a>

								</div> <!-- carousel -->

							<?php endif ?>

						<?php elseif ( $img_src = get_first_image_url( get_the_content() ) ) : // Check for first image from content ?>

							<a class="img-eye-hover" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<img src="<?php echo esc_url( $img_src ); ?>" alt="thumbnail">
							</a>

						<?php endif; ?>

					</div> <!-- blog-image -->

				<?php endif ?>

				<?php
				$body_classes = array();

				if ( $atts['type'] == 'vertical' && ( has_post_thumbnail() || $supported_post_format ) && ! is_sticky() ) {
					$body_classes[] = 'col-sm-6';
				} elseif ( $atts['type'] == 'vertical' || $atts['type'] == 'full' ) {
					$body_classes[] = 'col-sm-12';
				}

				$body_classes[] = 'blog-body';
				?>

				<div class="<?php echo implode( ' ', $body_classes ); ?>">
					<h3 class="blog-title"><a href="<?php the_permalink(); ?>"
					                          title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

					<p class="blog-info">
                        <?php if ( $atts['show_author'] == 'yes' ): ?>
                            <?php _e( 'Posted by', 'mental' ); ?>
                            <?php the_author_posts_link(); ?> on
                        <?php endif ?>
                        <?php if ( $atts['show_date'] == 'yes' ): ?>
                            <time
                                datetime="<?php the_time( 'Y-m-d' ) ?>"><?php the_time( 'F j, Y' ); ?><?php the_time( 'g:i a' ); ?>
                            </time> /
                        <?php endif ?>
                        <?php if ( $atts['show_comments'] == 'yes' ): ?>
						<a href="<?php comments_link(); ?> "><?php $comments_count = wp_count_comments( get_the_ID() );
							echo (int) $comments_count->approved; ?><?php _e( 'Comments', 'mental' ); ?></a>
                        <?php endif ?>
					</p>
					<div class="blog-excerpt">
						<?php if ( $atts['type'] == 'full' ): ?>
							<?php
							if ( ! has_post_thumbnail() ) {
								if ( get_post_format() == 'gallery' ) { // Remove gallery shortcode from content
									echo apply_filters( 'the_content', strip_shortcode_gallery( get_the_content() ) );
								} elseif ( get_post_format() == 'video' ) {
									echo apply_filters( 'the_content', strip_embed_content( get_the_content() ) );
								} elseif ( get_post_format() == 'audio' ) {
									echo apply_filters( 'the_content', azl_strip_audio_shortcodes( get_the_content() ) );
								} else {
									the_content();
								}
							} else {
								the_content();
							}
							?>
						<?php else: ?>
                            <?php if ( $atts['show_excerpt'] == 'yes' ): ?>
							<p><?php the_mental_excerpt(); ?></p>
                            <?php endif ?>
						<?php endif ?>
					</div>
					<?php if ( $atts['type'] != 'full' ): ?>
                        <?php if ( $atts['show_read'] == 'yes' ): ?>
						<a href="<?php the_permalink(); ?>"
						   class="btn btn-default blog-readmore"><?php _e( 'Read more', 'mental' ); ?>
                        </a>
                        <?php endif ?>
					<?php endif ?>
				</div>

			</div> <!-- row -->

		</div> <!-- blog-item -->

	<?php endif ?>

	<?php
}