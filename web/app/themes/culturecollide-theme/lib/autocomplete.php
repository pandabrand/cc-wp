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
  $suggestions;
  $search_results = '';
  if( $post_type == 'location' ) {
    $suggestions = cc_category_search($term);
  } else {
    $suggestions = cc_post_search($term, $post_type);
  }
  $response = json_encode( $suggestions );
  echo $response;
  exit();
}

function cc_category_search($term) {
  $cc_category_search_cache_key = 'cc_category_search_cache_key';
  $suggestions = array();
  if( !$suggestions = get_transient( $cc_category_search_cache_key ) ) {
    global $wpdb;
    $search_results = $wpdb->get_results( "SELECT wp_terms.slug, wp_terms.name FROM wp_terms LEFT JOIN wp_term_taxonomy ON wp_terms.term_id = wp_term_taxonomy.term_taxonomy_id WHERE /*wp_terms.name LIKE '%{$term}%' AND*/ wp_term_taxonomy.taxonomy = 'location_types'", OBJECT );

    foreach( $search_results as $search_result ):
      $suggestion = array();
      $suggestion['label'] = $search_result->name;
      $suggestion['link'] = '/location-type/'.$search_result->slug;
      $suggestions[] = $suggestion;
    endforeach;

    set_transient( $cc_category_search_cache_key, $suggestions, WEEK_IN_SECONDS );
  }
  $suggestions = get_transient( $cc_category_search_cache_key );

  $filter_result = array();
  foreach ($suggestions as $suggestion) {
      $regex = '/(' . $term . ')/i';
    if( preg_match( $regex, $suggestion['label'] ) ) {
      $filter_result[] = $suggestion;
    }
  }

  return $filter_result;
  // return array_filter( $suggestions, function( $suggestion ) use ( $term ) {
  //   $regex = '/(' . $term . ')/i';
  //   return preg_match($regex, $suggestion['label']);
  // });
}

function cc_post_search($term, $post_type) {
  $post_suggestions = array();
  $cc_post_search_cache_key = 'cc_post_search_cache_key';
  // delete_transient( $cc_post_search_cache_key );
  if( !$post_suggestions = get_transient( $cc_post_search_cache_key ) ) {
    global $wpdb;
    $search_results = array();
    $post_types = implode( '|', array_values( array( 'city', 'artist' ) ) );

    $search_results = $wpdb->get_results( "SELECT ID, post_title, post_type FROM wp_posts WHERE  post_title LIKE '%{$term}%' AND post_type REGEXP '{$post_types}' AND post_status = 'publish'", OBJECT );
    foreach( $search_results as $search_result ):
      $suggestion = array();
      $suggestion['label'] = $search_result->post_title;
      $suggestion['link'] = get_the_permalink($search_result->ID);
      $suggestion['post_type'] = $search_result->post_type;
      $post_suggestions[] = $suggestion;
    endforeach;

    set_transient( $cc_post_search_cache_key, $post_suggestions, WEEK_IN_SECONDS );
  }

  $post_suggestions = get_transient( $cc_post_search_cache_key );

  $filter_result = array();
  foreach ($post_suggestions as $suggestion) {
      $regex = '/(' . $term . ')/i';
    if( preg_match($regex, $suggestion['label']) && $post_type === $suggestion['post_type'] ) {
      $filter_result[] = $suggestion;
    }
  }

  return $filter_result;
  // return array_filter( $post_suggestions, function( $suggestion ) use ( $term, $post_type ) {
  //   $regex = '/(' . $term . ')/i';
  //   return ( preg_match($regex, $suggestion['label']) && $post_type === $suggestion['post_type'] );
  // });
}
