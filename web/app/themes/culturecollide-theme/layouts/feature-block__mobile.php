<div class="feature-block feature-block_element">
  <div class="feature feature_mobile">
    <a class="feature__link" href="<?php echo get_permalink($post->ID); ?>"></a>
    <div class="img-fluid feature__image" style="background-image:<?php echo cc_background_image_filter(); ?>, url('<?php echo the_post_thumbnail_url('large-feature'); ?>')">
      <div class="feature__category-block">
        <?php $post_categories = wp_get_post_categories( $post->ID ); ?>
        <?php $category = get_category($post_categories[0]); ?>
        <div class="icon <?php echo 'icon-',$category->slug,'-white'; ?>"></div>
        <div class="feature__category-block__category-details pl-2">
          <div class="feature__category-block__category-type">
            <?php $cat = $category->slug; echo ($cat == 'uncategorized') ? 'music' : $cat; ?>
          </div>
          <div class="feature__category-block__category-info">

          </div>
        </div>
      </div>
    </div>
    <div class="feature__filter"></div>
    <div class="feature__category-line"></div>
    <div class="feature__body">
      <div class="feature__copy">
        <div class="feature__title">
          <?php echo (get_field('secondary_title')) ? get_field('secondary_title') : get_the_title(); ?>
        </div>
        <div class="feature__text">
          <?php echo substr(get_field('secondary_description') ,0, 50), '...'; ?>
        </div>
      </div>
    </div>
  </div>
</div>
