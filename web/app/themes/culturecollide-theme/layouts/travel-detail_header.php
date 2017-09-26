<div class="row cc-row">
  <div class="travel travel__detail__header billboard">
    <?php $image_position = get_field('main_image_postition') ? ' billboard__image-bottom' : ''; ?>
    <div class="billboard__image<?php echo $image_position; ?>" style="background-image:<?php echo cc_background_image_filter(); ?>, url('<?php echo the_post_thumbnail_url('editorial-feature'); ?>')"></div>
    <div class="billboard__category-line travel__detail__category-line"></div>
    <div class="billboard__filter"></div>
    <div class="billboard__body travel__detail__body pl-4">
      <div class="billboard__copy">
        <div class="billboard__title h1 ml-3">
          <?php echo get_card_title(); ?>
        </div>
      </div>
    </div>
    <div class="billboard__text travel__detail__text">
      <div class="travel__detail__text-wrapper">
        <?php the_content(); ?>
      </div>
    </div>
    <div class="billboard__category-block">
      <div class="<?php echo get_post_icon_class(); ?> mr-2"></div>
      <div class="billboard__category-block__category-details pl-3">
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
    <?php if( get_field( 'sponsor_title' ) ): ?>
      <?php $sponsor_url = get_field( 'sponsor_url' ); ?>
      <div class="billboard_sponsor-block d-flex ml-auto pr-4 text-center<? echo $sponsor_url ? ' billboard_sponsor-block-pointer' : ''; ?>" onclick="<?php echo $sponsor_url ? "javascript: sendToSponsor('{$sponsor_url}');" : "javascript: void(0);"; ?>">
        <div class="d-flex flex-row">
          <div class="billboard_sponsor-callout my-auto">
            Presented by:
          </div>
          <?php if(get_field( 'sponsor_logo' ) ): ?>
            <?php $sponsor_logo = get_field( 'sponsor_logo' ); ?>
            <div class="billboard_sponsor-image_wrapper">
              <img src="<?php echo $sponsor_logo['url']; ?>" class="img-fluid billboard_sponsor-image" alt="<?php echo $sponsor_logo['alt']; ?>" />
            </div>
          <?php else: ?>
            <div class="billboard_sponsor-title">
              <?php the_field( 'sponsor_title' ); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
