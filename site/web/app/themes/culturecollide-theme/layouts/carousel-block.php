<div class="home__city-guides-block__carousel-block__item-wrapper">
  <div class="home__city-guides-block__carousel-block__item">
    <a href="<?php echo get_permalink(); ?>" class="block__link"></a>
    <div class="home__city-guides-block__carousel-block__image" style="background-image:url('<?php echo the_post_thumbnail_url('city-guide_thumbnail'); ?>')"></div>
    <div class="home__city-guides-block__carousel-block__item-filter"></div>
    <div class="home__city-guides-block__carousel-block__item-border"></div>
    <div class="home__city-guides-block__carousel-block__item__city-header">
      <div class="icon icon-travel-white"></div>
      <div><?php echo esc_html( get_the_title() ); ?></div>
    </div>
  </div>
</div>
