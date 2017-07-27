<div class="row cc-row related-content">
  <div class="col-sm-12 col-md-4 push-md-8 col-lg-3 push-lg-9">
    <?php get_template_part('layouts/ad', 'block'); ?>
  </div>
  <?php
    $args = array(
      'posts_per_page' => 3,
      'post_type' => ['post', 'city', 'artist'],
      'orderby' => 'rand'
    );
    $related_query = new WP_Query($args);
    if($related_query->have_posts()):
  ?>
  <div class="col-sm-12 col-md-8 pull-md-4 col-lg-9 pull-lg-3">
    <div class="related-content__carousel">
      <?php while($related_query->have_posts()): $related_query->the_post(); ?>
      <div class="related-content__carousel__item">
        <div class="related-content__item">
          <?php get_template_part('layouts/card', 'card__1-1'); ?>
        </div>
      </div>
      <?php endwhile;?>
    </div>
  </div>
  <?php endif; ?>
</div>
