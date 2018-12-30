<a class="feature__link" href="<?php echo get_permalink($post->ID); ?>">
  <div class="aspect-ratio__1_1">
    <div class="aspect-ratio_wrapper">
      <div class="feature-block feature-block_element">
          <div class="feature feature-1_3">
            <div class="feature__category-block">
              <?php echo $travel_post ? 'travel' : get_category_type_title();?>
            </div>
            <div class="feature__image">
              <img class="img-fluid" src="<?php echo the_post_thumbnail_url('large-feature'); ?>" />
            </div>
            <div class="feature__body">
              <div class="feature__copy">
                <div class="feature__subject"><?php echo get_category_type_subject(); ?></div>
                <div class="feature__title">
                  <?php echo (get_field('secondary_title')) ? get_field('secondary_title') : get_the_title(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </a>
