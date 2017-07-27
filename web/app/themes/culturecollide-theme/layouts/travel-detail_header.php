<div class="row cc-row">
  <div class="travel travel__detail__header billboard">
    <div class="billboard__image" style="background-image:url('<?php echo the_post_thumbnail_url('large-feature'); ?>')"></div>
    <div class="billboard__category-line travel__detail__category-line"></div>
    <div class="billboard__filter"></div>
    <div class="billboard__body travel__detail__body">
      <div class="billboard__copy">
        <div class="billboard__title h1">
          <?php echo get_card_title(); ?>
        </div>
      </div>
    </div>
    <div class="billboard__text travel__detail__text">
      <?php (get_post_type() == 'artist') ? the_content() : the_excerpt(); ?>
    </div>
    <div class="billboard__category-block">
      <div class="<?php echo get_post_icon_class(); ?>"></div>
      <div class="billboard__category-block__category-details">
        <div class="billboard__category-block__category-type">
          city guide:
        </div>
        <div class="billboard__category-block__category-info">
          <?php
            if( get_post_type() == 'artist' ):
              $city = get_field('artist_city')[0]; echo $city->post_title;
            else:
              echo get_the_title();
            endif;
          ?>
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
          <a class="share-fb" rel="external" href="<?php echo get_social_links()['facebook']; ?>" target="_blank">
            <i class="fa fa-facebook"></i>
          </a>
        </li>
        <li class="billboard__social-block__item">
          <a class="share-tb" rel="external" href="<?php echo get_social_links()['tumblr']; ?>">
            <i class="fa fa-tumblr"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
