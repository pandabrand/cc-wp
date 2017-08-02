<?php

use Roots\Sage\Assets;

function enqueue_scripts_styles_init() {
  if( is_single() || is_tax( 'location_types' ) || is_page( 9972 )):
    $args = array(
      "post_type" => "city",
      "numberposts" => -1,
    );
    $cities = get_posts( $args );
    $map_info = array( 'cities' => array( ) );
    foreach($cities as $city) {
      $city_output = array(
        'city_id' => $city->ID,
        'title' => get_the_title($city->ID),
        'link' => get_the_permalink($city->ID),
        'location' => get_field('city_location', $city->ID)
      );
      $map_info['cities'][] = $city_output;
    }

  	wp_register_script( 'ajax-script', Assets\asset_path('scripts/locate_user.js'), array('jquery'), null, true ); // jQuery will be included automatically
    wp_localize_script( 'ajax-script', 'map_info', $map_info );
    wp_enqueue_script('ajax-script');

  	wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); // setting ajaxurl
  endif;
}
add_action('wp_enqueue_scripts', 'enqueue_scripts_styles_init');
// add_action('init', 'enqueue_scripts_styles_init');

function ajax_action_stuff() {
	echo 'ajax submitted';
	die(); // stop executing script
}
add_action( 'wp_ajax_ajax_action', 'ajax_action_stuff' ); // ajax for logged in users
add_action( 'wp_ajax_nopriv_ajax_action', 'ajax_action_stuff' ); // ajax for not logged in users
