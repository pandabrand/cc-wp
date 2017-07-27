<div class="row cc-row travel__artist-guides">
  <div class="col-12 mb-4">
    <div class="d-flex justify-content-between">
      <div class="travel__artist-guides-title">
        Artist Guides
      </div>
      <div class="travel__artist-guides-button">
        <a href="/artist" class="button button--small button--outline">
          all artists
        </a>
      </div>
    </div>
  </div>
</div>
<?php
  $args = array(
    "post_type" => "artist",
    "numberposts" => "4",
    "order" => "rand"
  );
  $artist_guides = get_posts($args);
  if( !empty ( $artist_guides ) ):
?>
  <div class="col-12">
    <div class="travel__artist-guides__carousel row">
      <?php foreach( $artist_guides as $post ): setup_postdata( $post ); ?>
      <div class="col-3">
        <?php get_template_part('layouts/card', 'card__1-1'); ?>
      </div>
    <?php endforeach; wp_reset_postdata(); ?>
    </div>
  </div>
<? endif; ?>
