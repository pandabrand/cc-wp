<div class="row cc-row related-content">
  <div class="col-sm-12 col-md-4 push-md-7 col-lg-3 push-lg-9">
    <?php get_template_part('layouts/ad', 'block'); ?>
  </div>
  <?php
    $exclude_posts = array();
    $exclude_cats = array();
    $reservedObj = get_category_by_slug('reserved');
    $exclude_cats[] = $reservedObj->term_id;
    $post_types = array('post');
    $tax_query = array();

    if( is_front_page() ):
      if( $category_post_type === 'travel' ) {
        $post_types[] = 'city';
        $post_types[] = 'artists';
        $tax_query[] = array (
          'taxonomy' => 'category',
          'field'    => 'slug',
          'terms'    => array( 'travel' ),
        );
      } else {
        $travelObj = get_category_by_slug('travel');
        $exclude_cats[] = $travelObj->term_id;
      }

      $feature_id = get_queried_object_id();
      $ex_culture_post_object = get_field('culture_post', $feature_id);
      $ex_travel_post_object = get_field('travel_post', $feature_id);
      $exclude_posts[] = $ex_culture_post_object->ID;
      $exclude_posts[] = $ex_travel_post_object->ID;
    endif;
    $args = array(
      'posts_per_page' => 5,
      'post_type' => $post_types,
      'post__not_in' => $exclude_posts,
      'category__not_in' => $exclude_cats,
      'ignore_sticky_posts' => true,
      'tax_query' => $tax_query,
      'order_by' => ['date'],
      'order' => 'DESC'
    );
    // $related_query = new WP_Query($args);
    $related_posts = get_posts( $args );
    $post = array_shift( $related_posts );
  ?>
  <div class="col-sm-12 col-md-6 pull-md-4 col-lg-9 pull-lg-3">
      <?php $travel_post = false; ?>
      <?php setup_postdata( $post ); ?>
      <?php include( locate_template( 'layouts/feature-block__3-1.php' ) ); ?>
      <?php wp_reset_postdata(); ?>
  </div>
</div>
<div class="row cc-row related-content">
  <?php foreach($related_posts as $post): setup_postdata( $post ); ?>
    <div class="col-sm-12 col-md-6 col-lg-3">
      <?php get_template_part('layouts/card', 'card__1-1'); ?>
    </div>
  <?php endforeach; wp_reset_postdata(); ?>
</div>
