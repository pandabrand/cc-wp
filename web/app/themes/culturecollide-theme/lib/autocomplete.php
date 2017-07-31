<?php

use Roots\Sage\Assets;

function cc_autocomplete_scripts() {
  wp_enqueue_script( 'jquery-ui-autocomplete' );
  wp_register_script( 'cc-autocomplete', Assets\asset_path('scripts/cc-autocomplete.js'), ['sage/js', 'jquery-ui-autocomplete'], null, true );
  wp_localize_script( 'cc-autocomplete', 'ccAutocomplete', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
  wp_enqueue_script( 'cc-autocomplete' );
}
add_action( 'wp_enqueue_scripts', 'cc_autocomplete_scripts' );

add_action( 'wp_ajax_cc_autocomplete_search', 'cc_autocomplete_search' );
add_action( 'wp_ajax_nopriv_cc_autocomplete_search', 'cc_autocomplete_search' );

function cc_autocomplete_search() {
  $term = strtolower( $_GET['term'] );
  $post_type = strtolower( $_GET['post_type'] );
  $suggestions = array();
  global $wpdb;
  $search_results = $wpdb->get_results( "SELECT ID, post_title FROM wp_posts WHERE  post_title LIKE '%{$term}%' AND post_type LIKE '%{$post_type}%' AND post_status = 'publish'", OBJECT );
  foreach( $search_results as $search_result ):
    $suggestion = array();
    $suggestion['label'] = $search_result->post_title;
    $suggestion['link'] = get_the_permalink($search_result->ID);
    $suggestions[] = $suggestion;
  endforeach;
  $response = json_encode( $suggestions );
  echo $response;
  exit();
}
