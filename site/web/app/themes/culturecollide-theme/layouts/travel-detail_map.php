<?php
$current_post = $post;
?>
<div class="row cc-row travel travel__detail__map__row">
  <div class="col-6 push-6">
    <?php get_template_part('layouts/travel', 'map_block'); ?>
  </div>
  <div class="col-6 pull-6 travel__detail__map__list">
    <?php
      $locations;
      if($current_post->post_type == 'artist'):
        $locations = get_field('artists_locations', $current_post);
      elseif($current_post->post_type == 'city'):
        $locations = get_posts(array(
          "numberposts" => -1,
          "post_type" => "location",
          "meta_query" => array(
            array(
              'key' => 'location_city',
              'compare' => 'LIKE',
              'value' => $current_post->ID
            ),
          )
        ));
      endif;
      if( !empty( $locations ) ):
        foreach( $locations as $location_arr ):
          $location = ($current_post->post_type == 'artist') ? $location_arr['location'][0] : $location_arr;
          include( locate_template( 'layouts/travel-location_block.php', false, false ) );
        endforeach;
      endif;
    ?>
  </div>
</div>
