<?php
  $args = array(
    'posts_per_page' => 1,
    'post_type' => ['ad_space'],
  );
  $ad_query = new WP_Query($args);
  if($ad_query->have_posts()):
?>
  <div class="ad">
    <a href="<?php echo get_field(''); ?>" target="_blank" rel="external">
      <img src="<?php echo the_post_thumbnail_url('ad-space-image'); ?>" class="img-fluid" height="100%"/>
    </a>
  </div>
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
