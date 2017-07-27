<div class="row travel__detail__map__item <?php $location->ID; ?>" id="<?php echo $location->ID; ?>">
  <div class="col-12">
    <div class="card card__2-1">
        <?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $location->ID ), 'large-feature' ); ?>
          <div class="card__image"  style="background-image:url('<?php echo esc_url( $large_image_url[0] ); ?>')">
            <div class="card__category-block">
              <div class="<?php echo get_post_icon_class($location); ?>"></div>
              <div class="card__category-block__category-details">
                <div class="card__category-block__category-type">
                  <?php echo get_category_type_title($location);?>
                </div>
                <div class="card__category-block__category-info">
                  <?php echo get_category_type_subject($location); ?>
                </div>
              </div>
            </div>
            <div class="card__category-line"></div>
            <div class="card__filter"></div>
            <div class="card__body">
              <div class="card__copy d-flex flex-column">
                <div class="card__title">
                  <?php echo get_card_title($location); ?>
                </div>
                <div class="card__text">
                  <?php echo $location->post_content; ?>
                </div>
                <div class="card__address">
                  <?php $address = get_field('address', $location->ID); ?>
                  <?php echo $address['address']; ?>
                </div>
                <?php
                  $loc_id = $location->ID;
                  // write_log($loc_id);
                  global $wpdb;
                  $artist_posts = $wpdb->get_results( "SELECT * FROM wp_postmeta WHERE meta_key LIKE 'artists_locations_%_location' AND meta_value LIKE '%{$loc_id}%'", OBJECT );
                  // write_log($artist_posts);
                  if( !empty( $artist_posts ) ) :
                ?>
                  <div class="card_reccomendations">
                    <div><strong>Artist Reccomendations</strong></div>
                    <div class="d-flex flex-row">
                <?php foreach($artist_posts as $artist): ?>
                    <div class="card_reccomendations__title small_text pr-2">
                      <?php echo get_the_title($artist->post_id); ?>
                    </div>
                <?php endforeach; ?>
                    </div>
                  </div>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
                <div class="card__links mt-auto d-flex justify-content-between">
                  <div class="card__link">
                    <a href="<?php the_permalink($location->ID); ?>" rel="external" target="_blank"><i class="fa fa-desktop"></i> website</a>
                  </div>
                  <div class="card__link">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $address['lat'],',',$address['lng']; ?>" rel="external" target="_blank">
                      <i class="fa fa-map"></i> directions
                    </a>
                  </div>
                </div>

              </div>
            </div>
          </div>

    </div>
  </div>
</div>
