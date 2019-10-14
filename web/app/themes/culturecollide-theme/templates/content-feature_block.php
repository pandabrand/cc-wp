<div class="row cc-row feature-block_color feature-block home">
  <?php
    if( is_front_page() ):
      $today = new DateTime('now');
      $reservedObj = get_category_by_slug('reserved');
      $exclude_cats = array($reservedObj->term_id);
      $culture_post_object = get_field('culture_post');
      $culture_start_date = new DateTime(get_field('culture_feature_post_start'));
      $culture_end_date = new DateTime(get_field('culture_feature_post_end'));
      $exclude_posts = array();
      if($culture_start_date < $today && $today < $culture_end_date) {
        $post = $culture_post_object;
        $exclude_posts[] = $post->ID;
      } else {
        global $post;
        $args = array(
          'posts_per_page' => 5,
          'offset' => rand(1, 9),
          'orderby' => 'date',
          'post_type' => 'post',
          'post_status' => 'publish',
          'category__not_in' => $exclude_cats,
          'date_query' => array(
            array(
              'before' => '1 month ago'
              // 'year' => date('Y'),
              // 'month' => date('M')
            ),
          ),
        );

        $recent_posts = get_posts( $args );
        $key = array_rand( $recent_posts, 1 );
        $post = $recent_posts[$key];
        $exclude_posts[] = $post->ID;
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
          $exclude_cats[] = 'travel';
          $args = array(
            'posts_per_page' => 5,
            'offset' => rand(1, 9),
            'orderby' => 'date',
            'post_type' => 'post',
            'post_status' => 'publish',
            'category__not_in' => $exclude_cats,
            'post__not_in' => $exclude_posts,
            'date_query' => array(
              array(
                'before' => '1 month ago'
                // 'year' => date('Y'),
                // 'month' => date('M')
              ),
            )
            // 'posts_per_page' => 5,
            // 'orderby' => 'date',
            // 'offset' => rand(1, 9),
            // 'post_type' => ['city', 'post'],
            // 'category__not_in' => $exclude_cats,
            // 'tax_query' => array(
            //   array (
            //     'taxonomy' => 'category',
            //     'field'    => 'slug',
            //     'terms'    => array( 'travel' ),
            //   )
            // ),
            // 'date_query' => array(
            //   array(
            //     'before' => '9 month ago'
            //     // 'year' => date('Y'),
            //     // 'month' => date('M')
            //    ),
            // ),
          );

          $travel_posts = get_posts( $args );
          $key = array_rand( $travel_posts, 1 );
          $post = $travel_posts[$key];
        }
        $travel_post = false;
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
