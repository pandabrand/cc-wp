<div class="row cc-row feature-block_color feature-block home">
  <?php
    if( is_front_page() ):
      $main_post_object = get_field('main_feature');
      // debug_var($main_post_object);
      // override $post
    	$post = $main_post_object;
    	setup_postdata( $post );
  ?>
  <div class="col-md-6">
    <?php include( locate_template( 'layouts/feature-block__1-2.php' ) ); ?>
  </div>
<?php
    endif;
    wp_reset_postdata();
    $second_features = get_field('secondary_main_feature');
    // debug_var($second_features);
?>
  <div class="col-md-6 col-sm-12">
  <?php
    $first_feature = $second_features[0];
    // debug_var($first_feature['feature_object']);
    $post = $first_feature['feature_object'];
    setup_postdata($post);
  ?>
  <?php include( locate_template('layouts/feature-block__2-1-long.php')); ?>
  <?php wp_reset_postdata(); ?>
    <?php
      $sec_feature = $second_features[1];
      $post = $sec_feature['feature_object'];
      setup_postdata($post);
    ?>
    <?php include( locate_template('layouts/feature-block__2-1-long.php')); ?>
    <?php wp_reset_postdata(); ?>
  </div>
</div>
<?php wp_reset_query(); ?>
