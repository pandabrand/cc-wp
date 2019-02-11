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
        global $post;
        $args = array(
          'posts_per_page' => 5,
          'offset' => rand(1, 9),
          'orderby' => 'date',
          'post_type' => 'post',
          'post_status' => 'publish',
          'date_query' => array(
            array(
              'year'  => $today['year'],
              'month' => $today['mon'],
            ),
          ),
        );

        $recent_posts = get_posts( $args );
        $key = array_rand( $recent_posts, 1 );
        $post = $recent_posts[$key];
      }
      $travel_post = false;
    	setup_postdata( $post );
      ?>
  <div class="col-md-12 col-lg-6">
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
          global $post;
          var_dump($today);
          $args = array(
            'posts_per_page' => 5,
            'orderby' => 'date',
            'offset' => rand(1, 9),
            'post_type' => ['city', 'artist', 'post'],
            'tax_query' => array(
              array (
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => array( 'travel' ),
              )
            ),
            'date_query' => array(
              array(
                'year'  => $today['year'],
                'month' => $today['mon'],
              ),
            ),
          );

          $travel_posts = get_posts( $args );
          $key = array_rand( $travel_posts, 1 );
          $post = $travel_posts[$key];
        }
        $travel_post = true;
        setup_postdata( $post );
  ?>
  <div class="col-md-12 col-lg-6">
    <?php include( locate_template( 'layouts/feature-block__1-1.php' ) ); ?>
  </div>
<?php
    endif;
    wp_reset_postdata();
?>
</div>
<?php wp_reset_query(); ?>
