<div class="row cc-row travel travel__header-color">
  <div class="col-12 travel travel__header">
    <div class="travel__header__title">
      travel with purpose
    </div>
    <div class="travel__header__subtitle">
      Take a tour with today's top bands, artists, and tastemakers
    </div>
  </div>
  <div class="col-12 travel travel__navigation">
    <div class="row cc-row text-right">
      <nav class="hidden-sm-up navbar col-6">
        <a class="navbar-toggler btn btn-secondary travel__navigation__button  travel__navigation__button--browse" data-toggle="collapse" data-target="#travel-navigate" aria-controls="travel-navigate" aria-expanded="false" aria-label="Toggle navigation">
          BROWSE
        </a>
      </nav>
      <div class="hidden-sm-up col-6">
        <a href="#" rel="noreferrer" class="btn btn-secondary travel__navigation__button travel__navigation__button--near-me">Near Me</a>
      </div>

      <div class="row" id="travel-navigate">
        <div class="dropdown full-width col-xs-4 col-4">
          <a href="#" class="btn btn-secondary dropdown-toggle" id="citiesMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cities</a>
          <div class="dropdown-menu" aria-labelledby="citiesMenuLink">
            <div class="row">
              <div class="col-12 dropdown-search">
                <div class="form-group">
                  <input class="cc-autocomplete form-control" placeholder="search for a city name" data-post-type="city" />
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 dropdown-selections">
                <?php
                  $args = array(
                    "post_type" => "city",
                    "numberposts" => "25"
                  );
                  $cities = get_posts( $args );
                  if( !empty( $cities ) ):
                    foreach( $cities as $post ): setup_postdata( $post );
                ?>
                <a href="<?php echo get_the_permalink($post->ID);?>" class="dropdown-item" rel="nofollow"><?php echo $post->post_title; ?></a>
                <?php
                    endforeach;
                    wp_reset_postdata();
                  endif;
                ?>
              </div>
              <?php
                $args = array(
                  "post_type" => "city",
                  "numberposts" => "2",
                  "orderby" => "title",
                  "order" => "rand"
                );
                $cities = get_posts( $args );
                if( !empty( $cities ) ):
                  foreach( $cities as $post ): setup_postdata( $post );
              ?>
                <div class="hidden-xs-down col-sm-3 menu-feature">
                  <?php get_template_part('layouts/card', 'card__1-1'); ?>
                </div>
              <?php
                  endforeach;
                  wp_reset_postdata();
                endif;
              ?>
            </div>
          </div>
        </div>
        <div class="dropdown full-width col-xs-4 col-4">
          <a href="#" rel="nofollow" class="btn btn-secondary dropdown-toggle" id="artistsMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Artists</a>
          <div class="dropdown-menu" aria-labelledby="artistsMenuLink">
            <div class="row">
              <div class="col-12 dropdown-search">
                <div class="form-group">
                  <input class="cc-autocomplete form-control" placeholder="search for an artist name" data-post-type="artist" />
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 dropdown-selections">
                <?php
                  $args = array(
                    "post_type" => "artist",
                    "orderby" => "title",
                    "order" => "ASC",
                    "numberposts" => "25"
                  );
                  if(get_post_type() == 'city') {
                    $meta = array(
                      array(
                        "key" => "artist_city",
                        "value" => $post->ID,
                        "compare" => "LIKE"
                      )
                    );
                    $args["meta_query"] = $meta;
                  }

                  $artists = get_posts( $args );
                  if( !empty( $artists ) ):
                    foreach( $artists as $post ): setup_postdata( $post );
                ?>
                <a href="<?php echo get_the_permalink();?>" class="dropdown-item" rel="nofollow"><?php echo get_the_title(); ?></a>
                <?php
                    endforeach;
                    wp_reset_postdata();
                  endif;
                ?>
              </div>
              <?php
                $args = array(
                  "post_type" => "artist",
                  "orderby" => "title",
                  "order" => "rand",
                  "numberposts" => "2"
                );
                $artists = get_posts( $args );
                if( !empty( $artists ) ):
                  foreach( $artists as $post ): setup_postdata( $post );
              ?>
              <div class="hidden-xs-down col-sm-3 menu-feature">
                <?php get_template_part('layouts/card', 'card__1-1'); ?>
              </div>
              <?php
                  endforeach;
                  wp_reset_postdata();
                endif;
              ?>
            </div>
          </div>
        </div>
        <div class="dropdown full-width col-xs-4 col-4">
          <a href="#" rel="nofollow" class="btn btn-secondary dropdown-toggle" id="categoriesMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>
          <div class="dropdown-menu" aria-labelledby="categoriesMenuLink">
            <div class="row">
              <div class="col-xs-12 col-sm-6 dropdown-selections">
                <?php
                  $args = array(
                    "taxonomy" => "location_types",
                    "hide_empty" => true,
                    "orderby" => "name",
                    "order" => "ASC"
                  );
                  $locations_cats = get_terms($args);
                  if(!empty($locations_cats)):
                    foreach($locations_cats as $term):
                      $term_link = get_term_link( $term );
                ?>
                  <a href="<?php echo esc_url( $term_link ) ?>" rel="nofollow" class="dropdown-item"><?php echo $term->name ?></a>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
                <?php
                  $args = array(
                    "post_type" => ["city","post"],
                    "numberposts" => "2",
                    "order" => "rand"
                  );
                  $cat_extra = get_posts( $args );
                  if( !empty( $cat_extra ) ):
                    foreach( $cat_extra as $post ): setup_postdata( $post );
                ?>
                  <div class="hidden-xs-down col-sm-3 menu-feature">
                    <?php get_template_part('layouts/card', 'card__1-1'); ?>
                  </div>
                <?php
                    endforeach;
                    wp_reset_postdata();
                  endif;
                ?>
            </div>
          </div>
        </div>
      </div>
      <div class="hidden-sm-down col-6">
        <a href="#" rel="noreferrer" class="btn btn-secondary travel__navigation__button travel__navigation__button--near-me">Near Me</a>
      </div>
    </div>
  </div>
</div>
