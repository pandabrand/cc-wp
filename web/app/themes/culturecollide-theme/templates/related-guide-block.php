<?php
  // Set the cache key
  $related_guide_cache_key = 'related_guide_cache_key';
  // delete_transient( $related_guide_cache_key );
  // if transient doesn't have our related detail array start the query
  if( ! $related_guide_details = get_transient( $related_guide_cache_key ) ) {
    $filter_result = array();

    // Get a list of tags and extract their names
    $post_tags = get_the_terms( $post->ID, 'post_tag' );
    write_log('$post_tags');
    write_log($post_tags);
    if ( ! empty( $post_tags ) && ! is_wp_error( $post_tags ) ) {
        $tags = wp_list_pluck( $post_tags, 'name' );
    }

    if ( ! empty( $post_tags ) && ! is_wp_error( $post_tags ) ) {
        $tag_ids = wp_list_pluck( $post_tags, 'term_id' );
    }
    write_log('$tag_ids');
    write_log($tag_ids);
    //ensure tags are lower case
    if( !empty( $tags ) ) {
      array_walk($tags, function( $tag ){
        $tag = strtolower($tag);
      });
    }

    // try to match tags to tags
    // first get all city tags or city IDS for tags
    if( !empty( $tag_ids ) ) {
      $filter_result = get_posts(
        array(
          'posts_per_page' => -1,
          'post_type' => 'city',
          'tag__in' => $tag_ids,
        )
      );
    }
    write_log('$filter_result');
    write_log($filter_result);
    // if filter_result is empty search content
    if( empty ( $filter_result ) ) {
      // Get a list of all current city post names
      $city_args = array(
        'post_type' => 'city',
        'posts_per_page' => -1,
      );

      $cities = get_posts( $city_args );

      $filter_result = array_filter( $cities, function( $city ){
        //get the terms of this city
        $city_terms = get_the_terms( $city->ID, 'post_tag' );
        $city_tags = array();
        //get the tag names of this city`
        if ( ! empty( $city_terms ) && ! is_wp_error( $city_terms ) ) {
            $city_tags = wp_list_pluck( $city_terms, 'name' );
        }
        //create a regex that will match any tag name with content in the post
        $regexp = '/(' . implode( '|',array_values( $city_tags ) ) . ')/i';
        $match_return = ( !empty( $city_tags ) ) ? preg_match( $regexp, get_the_content() ) : 0;
        return  ( $match_return === 1 );
      } );
    }

    // no match so we get a random city
    if( empty( $filter_result ) ) {
      $filter_result_key = array_rand($cities, 1);
      $rand_city = $cities[$filter_result_key];
      $filter_result[] = $rand_city;
    }

    //now make the $related_guide_details
    $related_guide_details = array();
    $related_guide_details['title'] = current( $filter_result )->post_title;
    $related_guide_details['url'] = get_permalink( current( $filter_result )->ID );
    $related_guide_details['image'] = get_the_post_thumbnail_url( current( $filter_result )->ID, 'large' );

    set_transient( $related_guide_cache_key, $related_guide_details, WEEK_IN_SECONDS );
  }
  $related_guide_detail = get_transient( $related_guide_cache_key );
?>
<style>
  .second-panel {
    background-image:linear-gradient(rgba(55,55,55,0.60) 0%, rgba(15,15,15,0.90) 100%),url('<?= $related_guide_detail['image']?>');
  }
</style>
<div class="row cc-row justify-content-center cc_cta-block-wrapper">
  <div class="col-sm-12 col-md-10 cc_cta-block">
    <a href="<?= $related_guide_detail['url']?>" rel="nofollow">
      <div class="first-panel d-flex flex-column align-items-center justify-content-center">
        <img src="<?php echo get_template_directory_uri() . '/dist/images/logo@2x.png'; ?>" srcset="<?php echo get_template_directory_uri() . '/dist/images/logo@1x.png'; ?> 1x, <?php echo get_template_directory_uri() . '/dist/images/logo@2x.png'; ?> 2x, <?php echo get_template_directory_uri() . '/dist/images/logo@3x.png'; ?> 3x" class="logo" height="47" />
        <div class="h2">
          Discover More With Purpose
        </div>
      </div>
      <div class="second-panel d-flex align-items-center justify-content-center" style="">
        <div class="panel-copy text-center">
          Click here to explore <?= $related_guide_detail['title'] ?> on Culture Collide.
        </div>
      </div>
    </a>
  </div>
</div>
