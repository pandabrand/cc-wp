<?php
  $args = array(
    'posts_per_page' => 8,
    'post_type' => ['city'],
  );
  $city_query = new WP_Query($args);
  if($city_query->have_posts()):
?>
<div class="row home__city-guides-row">
  <div class="col-12 home__city-guides-block">
    <div class="home__city-guides-block__title">
      city guides
    </div>
    <div class="col-12">
      <div class="home__city-guides-block__carousel-block">
        <div class="home__city-guides-block__carousel-block__list">
          <?php while($city_query->have_posts()): $city_query->the_post(); ?>
            <?php get_template_part('layouts/carousel', 'block'); ?>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
    <div class="col-12 text-center">
      <a href="/travel" class="button button--outline home__city-guides-block__carousel-block__link">explore travel</a>
    </div>
  </div>
</div>
<?php endif; ?>
<?php wp_reset_query(); ?>
