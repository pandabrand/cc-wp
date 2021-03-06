<div class="home__city-guides-block__carousel-block__item-wrapper">
  <div class="home__city-guides-block__carousel-block__item">
    <a href="<?php echo get_permalink(); ?>" class="block__link"></a>
    <div class="home__city-guides-block__carousel-block__image" style="background-image:<?php echo cc_background_image_filter(); ?>, url('<?php echo the_post_thumbnail_url('large-feature'); ?>')"></div>
    <div class="home__city-guides-block__carousel-block__item-filter"></div>
    <div class="home__city-guides-block__carousel-block__item-border"></div>
    <div class="home__city-guides-block__carousel-block__item__city-header">
      <div class="icon icon-travel-white"></div>
      <div class="ml-3"><?php echo esc_html( get_the_title() ); ?></div>
    </div>
  </div>
</div>
