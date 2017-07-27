<?php

function load_map_data() {
  if( is_single() || is_tax( 'location_types' ) ):
    global $post;
    $json_locations = array('locations' => array());
    if( is_single() && get_post_type($post->ID) == 'artist' ) {
      if( have_rows( 'artists_locations', $post->ID ) ) {
        while( have_rows( 'artists_locations', $post->ID ) ): the_row();
          $location = get_sub_field('location')[0];
          $location_output = array(
            'location_id' => $location->ID,
            'title' => get_the_title($location->ID),
            'website' => get_field('website', $location->ID),
            'coords' => get_field('address', $location->ID)
          );
          $json_locations['locations'][] = $location_output;
        endwhile;
      }
      $related_city = get_field('artist_city', $post->ID)[0];
      $city = array(
        'title' => get_the_title($related_city->ID),
        'location' => get_field('city_location', $related_city->ID)
      );
      $json_locations['city'] = $city;
    } elseif ( is_single() && get_post_type() == 'city' ) {
      $locations = get_posts(array(
        "numberposts" => -1,
        "post_type" => "location",
        "meta_query" => array(
          array(
            'key' => 'location_city',
            'compare' => 'LIKE',
            'value' => $post->ID
          ),
        )
      ));
      if( !empty( $locations ) ) {
        foreach($locations as $location) {
          $location_output = array(
            'location_id' => $location->ID,
            'title' => get_the_title($location->ID),
            'website' => get_field('website', $location->ID),
            'coords' => get_field('address', $location->ID)
          );
          $json_locations['locations'][] = $location_output;
        }
      }
      $city = array(
        'title' => get_the_title($post->ID),
        'location' => get_field('city_location', $post->ID)
      );
      $json_locations['city'] = $city;
    } elseif( is_tax('location_types')  ) {
      $term_id = get_queried_object_id();
      $term = get_term($term_id);
      $locations = get_posts(array(
        "post_type" => "location",
        "numberposts" => -1,
        "orderby" => "meta_value",
        "meta_key" => "location_city",
        "order" => "asc",
        $term->taxonomy => $term->name
      ));
      if( !empty( $locations ) ) {
        foreach($locations as $location) {
          $location_output = array(
            'location_id' => $location->ID,
            'title' => get_the_title($location->ID),
            'website' => get_field('website', $location->ID),
            'coords' => get_field('address', $location->ID)
          );
          $json_locations['locations'][] = $location_output;
        }
        $first = get_field('location_city', $locations[0]->ID);
        $first_city = get_post($first[0]);
        $city = array(
          'title' => get_the_title($first_city->ID),
          'location' => get_field('city_location', $first_city->ID)
        );
        $json_locations['city'] = $city;
      }
    }
    $map_info = array(
      'api_key' => MAPBOX_API,
    );
    $json_locations['map_info'] = $map_info;
    $js_data = json_encode($json_locations);
    wp_register_script('map_js', get_template_directory_uri() . '/dist/scripts/map_data.js', array(), null, true);
    wp_localize_script( 'map_js', 'map_vars', $js_data );
    wp_enqueue_script('map_js');
  endif;
}
add_action('wp_enqueue_scripts', 'load_map_data');
