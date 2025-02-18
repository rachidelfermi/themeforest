<?php 
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    $DF_builder = new DF_home_builder; 
    //get block data
    $data = $DF_builder->get_data(); 
    //set query
    $my_query = $data[0]; 
    //extract array data
    extract($data[1]); 
?>
    <?php if($title) { ?>
        <div class="panel_title">
            <div>
                <h4>
                    <?php if($link) { ?>
                        <a href="<?php echo esc_url($link);?>">
                    <?php } ?>
                        <?php echo esc_html__($title);?>
                    <?php if($link) { ?>
                        </a>
                    <?php } ?>
                </h4>
            </div>
        </div>
    <?php } ?>
    <?php if ($my_query->have_posts()) : $my_query->the_post(); ?>
        <?php 
            $DF_builder->set_double($my_query->post->ID);
            $image = get_post_thumb($my_query->post->ID,0,0);

            //categories
            $categories = get_the_category($my_query->post->ID);
            $catCount = count($categories);
            //select a random category id
            $id = rand(0,$catCount-1);
            if(isset($categories[$id]->term_id)) {
                $titleColor = df_title_color($categories[$id]->term_id, "category", false); 
            } else {
                $titleColor = df_get_option(THEME_NAME."_pageColorScheme");
            }
            $audio = get_post_meta( $my_query->post->ID, "_".THEME_NAME."_audio", true );
        ?>
            <!-- Layout post 1 -->
            <div class="layout_post_1">
                <div class="item_thumb">
  
                        <?php if(df_option_compare("showTumbIcon","showTumbIcon", $my_query->post->ID)==true) { ?>
                            <div class="thumb_icon">
                                <a href="<?php the_permalink();?>" style="background-color: <?php echo esc_attr__($titleColor);?>"><?php df_image_icons($my_query->post->ID);?></a>
                            </div>
                        <?php } ?>
                        <div class="thumb_hover">
                            <a href="<?php the_permalink();?>">
                                <?php 
                                    if($columnID=="column4") {
                                        echo df_image_html($my_query->post->ID,500,300);
                                    } else if($columnID=="column6") {
                                        echo df_image_html($my_query->post->ID,420,280);
                                    } else if($columnID=="column8") {
                                        echo df_image_html($my_query->post->ID,530,300);
                                    }  else {
                                        echo df_image_html($my_query->post->ID,1900,500);
                                    } 
                                ?>
                            </a>
                        </div>

                    <div class="thumb_meta">
                        <?php 
                            if(count(get_the_category($my_query->post->ID))>=1 && df_option_compare("postCategory","postCategory", $my_query->post->ID)==true) {
                        ?>
                            <a href="<?php echo esc_url(get_category_link($categories[$id]->term_id));?>">
                                <span class="category" style="background-color: <?php echo esc_attr__($titleColor);?>">
                                    <?php echo esc_html__(get_cat_name($categories[$id]->term_id));?>
                                </span>
                            </a>
                        <?php } ?>
                        <?php if(df_option_compare("postComments","postComments", $my_query->post->ID)==true && comments_open()) { ?>
                            <span class="comments">
                                <a href="<?php the_permalink();?>#comment">
                                    <?php comments_number(esc_html__('0 Comments', THEME_NAME), esc_html__('1 Comment', THEME_NAME), esc_html__('% Comments', THEME_NAME)); ?>
                                </a>
                            </span>
                        <?php } ?>
                    </div>
                </div>
                <div class="item_content">
                    <h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                    <?php 
                        add_filter('excerpt_length', 'df_new_excerpt_length_30');
                        the_excerpt();
                        remove_filter('excerpt_length', 'df_new_excerpt_length_30');
                    ?>
                </div>
            </div><!-- End Layout post 1 -->
    <?php endif; ?>
    <?php if($columnID!="column12") { ?>
    <!-- List post -->
    <div class="list_posts">
    <?php } ?> 
        <!-- Post -->
        <?php if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>
            <?php 
                $DF_builder->set_double($my_query->post->ID);
                $image = get_post_thumb($my_query->post->ID,0,0);

                //categories
                $categories = get_the_category($my_query->post->ID);
                $catCount = count($categories);
                //select a random category id
                $id = rand(0,$catCount-1);
                if(isset($categories[$id]->term_id)) {
                    $titleColor = df_title_color($categories[$id]->term_id, "category", false); 
                } else {
                    $titleColor = df_get_option(THEME_NAME."_pageColorScheme");
                }

                $audio = get_post_meta( $my_query->post->ID, "_".THEME_NAME."_audio", true );
            ?>
            <div class="<?php if($columnID=="column12") { ?> layout_post_2<?php } else { ?> post<?php } ?> clearfix">
                <div class="item_thumb">

                        <div class="thumb_icon">
                            <a href="<?php the_permalink();?>" style="background-color: <?php echo esc_attr__($titleColor);?>"><?php df_image_icons($my_query->post->ID);?></a>
                        </div>
                        <div class="thumb_hover">
                            <a href="<?php the_permalink();?>">
                                <?php 
                                    if($columnID=="column12") {
                                        echo df_image_html($my_query->post->ID,500,300);
                                    } else {
                                        echo df_image_html($my_query->post->ID,500,500,"visible animated");
                                    } 
                                ?>
                            </a>
                        </div>

                    <?php if($columnID=="column12") { ?>
                        <div class="thumb_meta">
                            <?php 
                                if(count(get_the_category($my_query->post->ID))>=1 && df_option_compare("postCategory","postCategory", $my_query->post->ID)==true) {
                            ?>
                                <a href="<?php echo esc_url(get_category_link($categories[$id]->term_id));?>">
                                    <span class="category" style="background-color: <?php echo esc_attr__($titleColor);?>">
                                        <?php echo esc_html__(get_cat_name($categories[$id]->term_id));?>
                                    </span>
                                </a>
                            <?php } ?>
                            <?php if(df_option_compare("postComments","postComments", $my_query->post->ID)==true && comments_open()) { ?>
                                <span class="comments">
                                    <a href="<?php the_permalink();?>#comment">
                                        <?php comments_number(esc_html__('0 Comments', THEME_NAME), esc_html__('1 Comments', THEME_NAME), esc_html__('% Comments', THEME_NAME)); ?>
                                    </a>
                                </span>
                            <?php } ?>
                        </div>
                    <?php } ?> 
                </div>
                <div class="item_content">
                    <h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                    <?php 
                        if($columnID=="column12") {
                            add_filter('excerpt_length', 'df_new_excerpt_length_50');
                            the_excerpt();
                            remove_filter('excerpt_length', 'df_new_excerpt_length_50');
                        }
                    ?>
                    <div class="item_meta clearfix">
                        <?php if(df_option_compare('postDate','postDate',$my_query->post->ID)==true) { ?>
                            <span class="meta_date">
                                <a href="<?php echo esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))); ?>">
                                    <?php the_time(get_option('date_format'));?>
                                </a>
                            </span>
                        <?php } ?>
                        <?php if(df_option_compare('showLikes','showLikes',$my_query->post->ID)==true) { ?>
                            <span class="meta_likes">
                                <a href="<?php the_permalink();?>"><?php echo intval(get_post_meta( $my_query->post->ID, "_".THEME_NAME."_total_votes", true ));?></a>
                            </span>
                        <?php } ?>
                    </div>
                </div>
            </div><!-- End Post -->
        <?php endwhile; endif; ?>
    <?php if($columnID!="column12") { ?>
    </div><!-- End List post -->
    <?php } ?>