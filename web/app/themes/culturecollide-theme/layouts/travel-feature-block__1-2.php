<div class="feature-block">
  <div class="travel travel_1-2">
    <a class="travel__link" href="<?php echo get_permalink($post->ID); ?>">
      <div class="img-fluid travel__image" style="background-image:<?php echo cc_background_image_filter(); ?>, url('<?php echo the_post_thumbnail_url('large-feature'); ?>')">
      <div class="travel__category-block">
        <div class="icon icon-travel-white"></div>
        <div class="travel__category-block__category-details pl-2">
          <div class="travel__category-block__category-type">
            <?php echo get_category_type_title(); ?>
          </div>
          <div class="travel__category-block__category-info">
            <?php echo get_category_type_subject(); ?>
          </div>
        </div>
      </div>
      <div class="travel__filter"></div>
      <div class="travel__category-line"></div>
      <div class="travel__body">
        <div class="travel__copy">
          <div class="travel__title">
            <?php echo get_card_title(); ?>
          </div>
          <div class="travel__text">
            <?php echo get_card_excerpt(null, '100'); ?>
          </div>
        </div>
      </div>
    </div>
    </a>
  </div>
</div>
