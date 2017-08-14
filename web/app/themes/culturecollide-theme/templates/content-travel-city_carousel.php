<div class="row cc-row travel__artist-guides">
  <div class="col-12 mb-4">
    <div class="d-flex justify-content-between">
      <div class="travel__artist-guides-title">
        City Guides
      </div>
      <div class="travel__artist-guides-button">
        <a href="/city" class="button button--small button--outline">
          all cities
        </a>
      </div>
    </div>
  </div>
</div>
<?php
  $args = array(
    "post_type" => "city",
    "numberposts" => "4",
    "orderby" => "rand",
    "order" => "asc"
  );
  $city_guides = get_posts($args);
  if( !empty ( $city_guides ) ):
?>
  <div class="col-12">
    <div class="travel__artist-guides__carousel row">
      <?php foreach( $city_guides as $post ): setup_postdata( $post ); ?>
      <div class="col-3">
        <?php get_template_part('layouts/card', 'card__1-1'); ?>
      </div>
    <?php endforeach; wp_reset_postdata(); ?>
    </div>
  </div>
<? endif; ?>
