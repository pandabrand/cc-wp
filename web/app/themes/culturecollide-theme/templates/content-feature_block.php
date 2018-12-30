<div class="row cc-row feature-block_color feature-block home">
  <?php
    if( is_front_page() ):
      $today = new DateTime('now');
      $culture_post_object = get_field('culture_post');
      $culture_start_date = new DateTime(get_field('culture_feature_post_start'));
      $culture_end_date = new DateTime(get_field('culture_feature_post_end'));
      if($culture_start_date < $today && $today < $culture_end_date) {
        $post = $culture_post_object;
      } else {
        $args = array(
          'numberposts' => 5,
          'offset' => 0,
          'category' => 0,
          'orderby' => 'post_date',
          'order' => 'RAND',
          'post_type' => 'post',
          'post_status' => 'publish',
          'suppress_filters' => true
        );

        $recent_posts = wp_get_recent_posts( $args, OBJECT );
        $post = $recent_posts[0];
      }
      $travel_post = false;
    	setup_postdata( $post );
      ?>
  <div class="col-sm-12 col-md-6">
    <?php include( locate_template( 'layouts/feature-block__1-1.php' ) ); ?>
  </div>
  <?php
        wp_reset_postdata();
        $travel_post_object = get_field('travel_post');
        $travel_start_date = new DateTime(get_field('travel_feature_post_start'));
        $travel_end_date = new DateTime(get_field('travel_feature_post_end'));
        if($travel_start_date < $today && $today < $travel_end_date) {
          $post = $travel_post_object;
        } else {
          $args = array(
            'numberposts' => 5,
            'offset' => 0,
            'category' => 0,
            'orderby' => 'post_date',
            'order' => 'RAND',
            'post_type' => 'city, artist, post',
            'post_status' => 'publish',
            'suppress_filters' => true,
            'tax_query' => array(
              array (
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => array( 'travel' ),
              )
            )
          );

          $recent_posts = wp_get_recent_posts( $args, OBJECT );
          $post = $recent_posts[0];
        }
        $travel_post = true;
        setup_postdata( $post );
  ?>
  <div class="col-sm-12 col-md-6">
    <?php include( locate_template( 'layouts/feature-block__1-1.php' ) ); ?>
  </div>
<?php
    endif;
    wp_reset_postdata();
?>
</div>
<?php wp_reset_query(); ?>
