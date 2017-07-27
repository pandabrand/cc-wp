<a href="<?php echo the_permalink();?>" class="block__link">
  <div class="card__image"  style="background-image:url('<?php echo the_post_thumbnail_url('large-feature'); ?>')">
    <div class="card__category-block">
      <div class="<?php echo get_post_icon_class(); ?>"></div>
      <div class="card__category-block__category-details">
        <div class="card__category-block__category-type">
          <?php echo get_category_type_title();?>
        </div>
        <div class="card__category-block__category-info">
          <?php echo get_category_type_subject(); ?>
        </div>
      </div>
    </div>
    <div class="card__category-line"></div>
    <div class="card__filter"></div>
    <div class="card__body">
      <div class="card__copy">
        <div class="card__title">
          <?php echo get_card_title(); ?>
        </div>
        <div class="card__text">
          <?php echo get_card_excerpt(); ?>
        </div>
      </div>
    </div>
  </div>
</a>
