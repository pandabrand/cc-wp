<div class="row cc-row feature-block_color">
  <?php
    $main_post_object = get_field('main_feature');
    $post = $main_post_object;
    setup_postdata( $post );
  ?>
    <div class="col-md-6 col-sm-12">
    <?php include( locate_template('layouts/feature-block__1-2.php')); ?>
    </div>
  <?php
    wp_reset_postdata();
    $second_features = get_field('side_features');
  ?>
    <div class="col-md-6 col-sm-12">
      <?php
        while( have_rows( 'side_features' ) ):
          the_row();
          $post = get_sub_field( 'feature' );
          // var_dump( $post );
          setup_postdata( $post );
          include( locate_template('layouts/feature-block__2-1-long.php'));
          wp_reset_postdata();
        endwhile;
      ?>
    </div>
<?php wp_reset_query(); ?>
</div>
