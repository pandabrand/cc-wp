<div class="editorial__detail__header <?php add_billboard_class(); ?>">
  <?php $image = get_field('background_image'); if($image): $size = 'editorial-feature'; ?>
    <div class="billboard__image" style="background-image:<?php echo cc_background_image_filter(); ?>, url('<?php echo $image["sizes"]["editorial-feature"]; ?>')"></div>
  <?php else: ?>
    <div class="billboard__image" style="background-image:<?php echo cc_background_image_filter(); ?>, url('<?php echo the_post_thumbnail_url('editorial-feature'); ?>')"></div>  <?php endif; ?>
  <div class="billboard__category-line"></div>
  <div class="billboard__filter"></div>
  <div class="billboard__body pl-4">
    <div class="billboard__copy">
      <div class="billboard__title h1 ml-3">
        <?php echo get_the_title(); ?>
      </div>
      <div class="billboard__text">
        <?php echo get_field('secondary_description'); ?>
      </div>
    </div>
  </div>
  <div class="billboard__category-block">
    <div class="<?php echo get_post_icon_class(); ?> mr-3"></div>
    <div class="billboard__category-block__category-details pl-2">
      <div class="billboard__category-block__category-type">
        <?php echo get_category_type_title();?>
      </div>
      <div class="billboard__category-block__category-info">
        <?php echo get_category_type_subject(); ?>
      </div>
    </div>
  </div>
  <div class="billboard__social-block">
    share
    <ul class="billboard__social-block__list">
      <li class="billboard__social-block__item">
        <a class="share-tw" rel="external" href="<?php echo get_social_links()['twitter']; ?>" target="_blank">
          <i class="fa fa-twitter"></i>
        </a>
      </li>
      <li class="billboard__social-block__item">
        <a class="share-fb" rel="external" href="<?php echo get_social_links()['facebook']; ?>">
          <i class="fa fa-facebook"></i>
        </a>
      </li>
      <li class="billboard__social-block__item">
        <a class="share-tb" href="<?php echo get_social_links()['tumblr']; ?>">
          <i class="fa fa-tumblr"></i>
        </a>
      </li>
    </ul>
  </div>
</div>
