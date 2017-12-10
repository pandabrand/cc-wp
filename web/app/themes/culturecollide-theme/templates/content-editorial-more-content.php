<?php
$exclude_posts = array();
$exclude_cats = array();
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
  $tags = get_the_tags(get_the_ID());
  if( !empty( $tags ) ) {
    foreach (get_the_tags() as $tag) {
      $post_tags[] = $tag->term_id;
    }
  }
  $post_types[] = 'city';
  $post_types[] = 'artist';
}
$reservedObj = get_category_by_slug('reserved');
$exclude_cats[] = $reservedObj->term_id;

// $paged = ( null == get_query_var( 'more_paged' ) || get_query_var( 'more_paged' ) == 0 ) ? '1' : get_query_var( 'more_paged' );
if ( get_query_var( 'paged' ) ) { $paged = get_query_var( 'paged' ); }
elseif ( get_query_var( 'page' ) ) { $paged = get_query_var( 'page' ); }
else { $paged = 1; }
$args = array(
'posts_per_page' => 12,
'post_type' => $post_types,
'orderby' => 'date',
'order' => 'DESC',
'paged' => $paged,
'post__not_in' => $exclude_posts,
'category__not_in' => $exclude_cats,
);
if( is_single() && !empty($post_tags) ) {
  $args['tag__in'] = $post_tags;
}

$more_query = new WP_Query($args);
$has_more_posts = $more_query->have_posts();

// if there are no more posts and paged is less than 11 change 'tag__in to empty
if(is_single() && !$has_more_posts && $paged < 11) {
  $args['tag__in'] = array();
  $more_query = new WP_Query($args);
  $has_more_posts = $more_query->have_posts();
}

if($more_query->have_posts()): $counter = 1; ?>
<div class="row cc-row d-flex justify-content-center">
  <div class="editorial__title">
    <?php if( !is_page( 'editorial' ) ): ?>
      related
    <?php endif; ?>
  </div>
</div>
<div class="row cc-row editorial__block">
  <div class="col-sm-12 col-md-4 push-md-8 col-lg-3 push-lg-9">
    <?php get_template_part('layouts/ad', 'block'); ?>
  </div>
  <?php while($more_query->have_posts()): $more_query->the_post(); ?>
    <?php if ($counter == 1) : ?>
      <div class="col-sm-6 col-md-8 pull-md-4 col-lg-6 pull-lg-3">
        <?php get_template_part('layouts/card', 'card__2-1'); ?>
      </div>
    <?php elseif($counter == 2): ?>
      <div class="col-sm-6 col-md-8 pull-md-4 col-lg-3 pull-lg-3">
        <?php get_template_part('layouts/card', 'card__1-1'); ?>
      </div>
    <?php else: ?>
      <div class="infinite-item col-xs-12 col-sm-4">
        <?php get_template_part('layouts/card', 'card__3-1'); ?>
      </div>
  <?php endif; ?>
  <?php $counter++; endwhile; ?>
</div>
<?php 
    $paged++;
  endif;
  wp_reset_query();
  $current_url = home_url( $post->post_name );
?>
<div class="row cc-row d-flex justify-content-center">
    <?php if( $paged < 11 && $has_more_posts): ?>
      <a class="infinite-more-link button button--outline" onclick="javascript:(event.preventDefault())" href="<?php echo trailingslashit($current_url), $paged; ?>">More <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw loader-anim"></i></a>
    <?php endif; ?>
</div>
