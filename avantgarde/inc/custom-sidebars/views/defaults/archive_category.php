<div class="defaultsSelector">
  
<h3 class="csh3title" title="<?php _e('Click to toogle', 'custom-sidebars'); ?>"><?php _e('Category archives','custom-sidebars'); ?></h3>
<div class="defaultsContainer"><?php if(!empty($categories)): foreach($categories as $c):?>
        <div id="category-page-<?php echo esc_attr($c->term_id); ?>" class="postbox closed" >
            <div class="handlediv" title="Haz clic para cambiar"><br /></div>
            <h3 class='hndle'><span><?php _e($c->name); ?></span></h3>
            
            <div class="inside">
            <?php if(!empty($modifiable)): foreach($modifiable as $m): $sb_name = $allsidebars[$m]['name'];?>
                <p><?php echo esc_attr($sb_name); ?>: 
                    <select name="category_page_<?php echo esc_attr($c->cat_ID); ?>_<?php echo esc_attr($m);?>">
                        <option value=""></option>
                    <?php foreach($allsidebars as $key => $sb):?>
                        <option value="<?php echo esc_attr($key); ?>" <?php echo (isset($defaults['category_pages'][$c->cat_ID][$m]) && $defaults['category_pages'][$c->cat_ID][$m]==$key) ? 'selected="selected"' : ''; ?>>
                            <?php echo esc_attr($sb['name']); ?>
                        </option>
                    <?php endforeach;?>
                    </select>
                    <?php if(!isset($cs_is_defaults)): ?>
                        <a href="#" class="selectSidebar"><?php printf(__('<- Set %s here.', 'custom-sidebars'), $current_sidebar['name']); ?></a>
                    <?php endif; ?>
                </p>
            <?php endforeach;else:?>
                <p><?php _e('There are no replaceable sidebars selected. You must select some of them in the form above to be able for replacing them in all the post type entries.','custom-sidebars'); ?></p>
            <?php endif;?>
            </div>
            
        </div>
        
        <?php endforeach;else: ?>
            <p><?php _e('There are no categories available.','custom-sidebars'); ?></p>
        <?php endif;?></div>
</div>