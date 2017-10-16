<?php
  //get all widgets
  $all_widgets = wp_get_sidebars_widgets();
  //get the related ads widget
  $related_ad_widget = $all_widgets['related-ads'];
  //make sure this sidebar has an adbutler widget in it
  $filter_result = array_filter($related_ad_widget, function($v){
    return ( strpos($v, 'adbutler') !== false );
  });

  if( is_active_sidebar( 'related-ads' ) && !empty( $filter_result ) ):
?>
  <div class="ad">
    <?php dynamic_sidebar('related-ads'); ?>
  </div>
<?php
  else :
    $args = array(
      'posts_per_page' => 1,
      'post_type' => ['post', 'artist', 'city'],
      'orderby' => 'rand'
    );
    $filler_query = new WP_Query($args);
    if($filler_query->have_posts()) :
      while($filler_query->have_posts()):
        $filler_query->the_post();
        get_template_part('layouts/card', 'card__1-1');
      endwhile;
    endif;
  endif;
?>
