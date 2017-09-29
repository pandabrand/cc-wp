<?php
$exclude_posts = array();
$post_tags = array();
$post_types = array('post');
if( is_page('editorial') ) {
  $main_post_object = get_field('main_feature');
  $exclude_posts[] = $main_post_object->ID;
  $second_features = get_field('side_features');
  while( have_rows( 'side_features' ) ){
    the_row();
    $ex_post = get_sub_field( 'feature' );
    $exclude_posts[] = $ex_post->ID;
  }
} elseif( is_single() ) {
  $exclude_posts[] = get_the_ID();
  foreach (get_the_tags() as $tag) {
    $post_tags[] = $tag->term_id;
  }
  $post_types[] = 'city';
  $post_types[] = 'artist';
}
$reservedObj = get_category_by_slug('reserved');
$exclude_cats = array($reservedObj->term_id);

if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
else { $paged = 1; }
$args = array(
'posts_per_page' => 12,
'post_type' => $post_types,
'order_by' => ['date'],
'order' => 'DESC',
'paged' => $paged,
'post__not_in' => $exclude_posts,
'category__not_in' => $exclude_cats,
);
if( is_single() && !empty($post_tags) ) {
  $args['tag__in'] = $post_tags;
}

$more_query = new WP_Query($args);
if($more_query->have_posts()): $counter = 1; ?>
<div class="row cc-row d-flex justify-content-center">
  <div class="editorial__title">
    <?php if( !is_page( 'editorial' ) ): ?>
      related
    <?php endif; ?>
  </div>
</div>
<div class="row cc-row editorial__block">
  <?php while($more_query->have_posts()): $more_query->the_post(); ?>
    <?php if($counter > 6) { $counter = 1; } ?>

    <?php if ($counter == 1) : ?>
      <div class="col-sm-12 col-md-4 push-md-8 col-lg-3 push-lg-9">
        <?php get_template_part('layouts/ad', 'block'); ?>
      </div>
    <?php elseif($counter == 2): ?>
      <div class="col-sm-6 col-md-8 pull-md-4 col-lg-6 pull-lg-3">
        <?php get_template_part('layouts/card', 'card__2-1'); ?>
      </div>
    <?php elseif($counter == 3): ?>
      <div class="col-sm-6 col-md-8 pull-md-4 col-lg-3 pull-lg-3">
        <?php get_template_part('layouts/card', 'card__1-1'); ?>
      </div>
    <?php else: ?>
      <div class="col-xs-12 col-sm-4">
        <?php get_template_part('layouts/card', 'card__3-1'); ?>
      </div>
  <?php endif; ?>
  <?php $counter++; endwhile; ?>
</div>
<?php endif; ?>
<?php wp_reset_query(); ?>
<?php
  global $wp;
  $current_url = home_url( $wp->query_vars['name'] );
?>
<div class="row cc-row d-flex justify-content-center">
    <?php if( $paged + 1 < 11 ): ?>
      <a class="infinite-more-link button button--outline" href="<?php echo trailingslashit($current_url), $paged + 1; ?>">More</a>
    <?php endif; ?>
</div>
