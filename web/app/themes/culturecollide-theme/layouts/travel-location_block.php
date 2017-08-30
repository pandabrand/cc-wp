<?php
  $location_city_id = get_field('location_city', $location->ID);
  $location_city_object = get_post($location_city_id[0]);
?>
<div class="row travel__detail__map__item <?php $location->ID; ?>" id="<?php echo $location->ID; ?>" data-city="<?php echo $location_city_object->post_name; ?>" data-location-name="<?php echo $location->post_name; ?>">
  <div class="col-12">
    <div class="card card__2-1">
        <?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $location->ID ), 'large-feature' ); ?>
          <div class="card__image"  style="background-image:<?php echo cc_background_image_filter(); ?>, url('<?php echo esc_url( $large_image_url[0] ); ?>')">
            <div class="card__category-block">
              <div class="<?php echo get_post_icon_class($location); ?> mr-2"></div>
              <div class="card__category-block__category-details pl-3">
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
                  global $wpdb;
                  $artist_posts = $wpdb->get_results( "SELECT * FROM wp_postmeta WHERE meta_key LIKE 'artists_locations_%_location' AND meta_value LIKE '%{$loc_id}%'", OBJECT );
                  if( !empty( $artist_posts ) ) :
                ?>
                  <div class="card_reccomendations">
                    <div class="medium small_text pt-2">Recommended by</div>
                    <div class="d-flex flex-row flex-wrap">
                <?php foreach($artist_posts as $artist): ?>
                    <div class="card_reccomendations__title small_text pr-2">
                      <a href="<?= get_the_permalink($artist->post_id) ?>"><?= get_the_title($artist->post_id); ?></a>
                    </div>
                <?php endforeach; ?>
                    </div>
                  </div>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
                <div class="card__links mt-auto d-flex flex-row justify-content-start">
                  <div class="card__link">
                    <a href="<?php echo get_field('website', $location->ID); ?>" rel="external" target="_blank"><i class="fa fa-window-maximize"></i> website</a>
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
