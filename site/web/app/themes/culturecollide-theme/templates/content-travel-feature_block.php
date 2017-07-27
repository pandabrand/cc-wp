<div class="row cc-row travel travel-feature">
  <?php
    $feature_posts = get_field('travel_features');
    if( !empty( $feature_posts ) ):
      foreach( $feature_posts as $feature ):
        $post = $feature['feature'];
        setup_postdata( $post );
  ?>
  <div class="col-xs-12 col-sm-6 mb-4">
    <?php get_template_part('layouts/travel', 'feature-block__1-2'); ?>
  </div>
  <?php
endforeach;
      wp_reset_postdata();
    endif;
  ?>
</div>
