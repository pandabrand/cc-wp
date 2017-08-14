<div class="feature feature-1-4 col-12">
  <a class="feature__link" href="<?php echo get_permalink($post->ID); ?>"></a>
  <div class="img-fluid feature__image" style="background-image:<?php echo cc_background_image_filter(); ?>, url('<?php echo the_post_thumbnail_url('large-feature'); ?>')"></div>
  <div class="feature__category-block">
    <?php $post_categories = wp_get_post_categories( $post->ID ); ?>
    <?php $category = get_category($post_categories[0]); ?>
    <div class="icon <?php echo 'icon-',$category->slug,'-white'; ?>"></div>
    <div class="feature__category-block__category-details">
      <div class="feature__category-block__category-type">
        <?php $cat = $category->slug; echo ($cat == 'uncategorized') ? 'music' : $cat; ?>
      </div>
      <div class="feature__category-block__category-info">
        <?php echo get_field('secondary_title'); ?>
      </div>
    </div>
  </div>
  <div class="feature__filter"></div>
  <div class="feature__category-line"></div>
  <div class="feature__body">
    <div class="feature__copy">
      <div class="feature__title">
        <?php echo get_the_title(); ?>
      </div>
      <div class="feature__text">
        <?php echo the_excerpt(); ?>
      </div>
    </div>
  </div>
</div>
