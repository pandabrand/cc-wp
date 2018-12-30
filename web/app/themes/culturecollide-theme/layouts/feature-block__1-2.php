<div class="feature-block feature-block_element">
  <a class="feature__link" href="<?php echo get_permalink($post->ID); ?>">
    <div class="feature feature_1-2">
      <div class="feature__category-block">
        <?php $post_categories = wp_get_post_categories( $post->ID ); ?>
        <?php $category = get_category($post_categories[0]); ?>
        <?php $cat = $category->slug; echo ($cat == 'uncategorized') ? 'music' : $cat; ?>
      </div>
      <div class="img-fluid feature__image">
        <img src="<?php echo the_post_thumbnail_url('large-feature'); ?>" />
      </div>
      <div class="feature__body">
        <div class="feature__copy">
          <div class="feature__subject">travel</div>
          <div class="feature__title">
            <?php echo (get_field('secondary_title')) ? get_field('secondary_title') : get_the_title(); ?>
          </div>
        </div>
      </div>
    </div>
  </a>
</div>
