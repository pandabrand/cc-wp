<div class="row cc-row travel travel__header-color">
  <div class="col-12 travel travel__header">
    <?php
      $travel_page = get_page_by_path( 'travel' );
      $travel_title = $travel_page->post_title;
      $travel_sub_title = wp_strip_all_tags( $travel_page->post_content, true );
      $reservedObj = get_category_by_slug('reserved');
      $reservedId = $reservedObj->term_id;
      global $post;
      $cat_city_name;
      $artist_city;
      $cat_query_params = array();
      if(get_post_type() == 'artist') {
        $artist_city = get_field('artist_city', $post->ID)[0];
        $subject = $artist_city->post_title;
        $cat_city_name = $artist_city->post_title;
        $cat_city_id = $artist_city->ID;
        $cat_query_params['cat_artist'] = $post->post_name;
        $cat_query_params['cat_city'] = $cat_city_id;
      } elseif ( get_post_type() == 'city' ) {
        $cat_city_name = $post->post_title;
        $cat_city_id = $post->ID;
        write_log($cat_query_params);
        $cat_query_params['cat_city'] = $cat_city_id;
      } elseif ( is_tax( 'location_types' ) && get_query_var('cat_city') ) {
        $cat_city_id = get_query_var('cat_city');
        $tax_city = get_post( $cat_city_id );
        $cat_city_name = $tax_city->post_title;
      }

    ?>
    <div class="travel__header__title">
      <?= $travel_title; ?>
    </div>
    <div class="travel__header__subtitle mx-4">
      <?= $travel_sub_title; ?>
    </div>
  </div>
  <div class="col-12 travel travel__navigation">
    <div class="row travel__navigation-row">
      <div class="d-flex flex-row justify-content-around travel__navigation__wrapper">
        <nav class="hidden-sm-up navbar">
          <a class="btn btn-secondary travel__navigation__button travel__navigation__button--browse">
            BROWSE
          </a>
        </nav>
        <div class="hidden-sm-up">
          <a href="#" rel="noreferrer" class="btn btn-secondary travel__navigation__button travel__navigation__button--near-me">Near Me</a>
        </div>

        <div class="hidden-sm-down">
          <a href="#" rel="noreferrer" class="btn btn-secondary travel__navigation__button travel__navigation__button--near-me">Near Me</a>
        </div>
      </div>
      <div class="hidden-sm-down" id="travel-navigate">
        <div class="d-flex flex-row justify-content-start travel__navigation__dropdowns">
          <div class="dropdown full-width">
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
                      "numberposts" => "25",
                      "orderby" => "title",
                      "order" => "ASC"
                    );
                    $cities = get_posts( $args );
                    if( !empty( $cities ) ):
                      foreach( $cities as $city ):
                  ?>
                  <a href="<?php echo get_the_permalink($city->ID);?>" class="dropdown-item<?php echo ($city->ID == $post->ID) ? ' active' : ''; ?>" rel="nofollow"><?php echo $city->post_title; ?></a>
                  <?php
                      endforeach;
                    endif;
                  ?>
                  <a href="/city" class="button button--small button--outline button--width-fit" rel="nofollow">All Cities</a>
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
          <div class="dropdown full-width">
            <a href="#" rel="nofollow" class="btn btn-secondary dropdown-toggle" id="artistsMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Artists</a>
            <div class="dropdown-menu" aria-labelledby="artistsMenuLink">
              <div class="row">
                <div class="col-12 dropdown_notice font-weight-bold ml-4">
                  <?php
                    echo (get_post_type() != 'artist') ? 'Artists : ' : '', $cat_city_name;
                    if(get_post_type() == 'artist') {
                      echo ' : ', $subject;
                    }
                  ?>
                </div>
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
                    if( get_post_type() == 'city'
                        || get_post_type() == 'artist'
                        || ( is_tax( 'location_types' ) && get_query_var('cat_city') )
                      ) {
                      $city_id = (get_post_type() == 'city') ? $post->ID : $artist_city->ID;
                      if(!$city_id) {
                        $city_id = get_query_var('cat_city');
                      }
                      $meta = array(
                        array(
                          "key" => "artist_city",
                          "value" => $city_id,
                          "compare" => "LIKE"
                        )
                      );
                      $args["meta_query"] = $meta;
                    }

                    $artists = get_posts( $args );
                    if( !empty( $artists ) ):
                      foreach( $artists as $artist ):
                  ?>
                  <a href="<?php echo get_the_permalink($artist->ID);?>" class="dropdown-item<?php echo ($artist->ID == $post->ID) ? ' active' : '' ?>" rel="nofollow"><?php echo $artist->post_title; ?></a>
                  <?php
                      endforeach;
                      wp_reset_postdata();
                    endif;
                  ?>
                  <a href="/artist" class="button button--small button--outline button--width-fit" rel="nofollow">All Artists</a>
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
          <div class="dropdown full-width">
            <a href="#" rel="nofollow" class="btn btn-secondary dropdown-toggle" id="categoriesMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>
            <div class="dropdown-menu" aria-labelledby="categoriesMenuLink">
              <div class="row">
                <div class="col-12 dropdown-search">
                  <?php if(is_tax('location_types')): ?>
                  <div class="form-group">
                    Filter By City <select class="city-filter-select custom-select mb-2 mr-sm-2 mb-sm-0" id="inlineFormCustomSelect">
                      <?php
                        $dcargs = array(
                          "post_type" => "city",
                          "numberposts" => "-1",
                          "orderby" => "title",
                          "order" => "ASC"
                        );
                        $city_dropdowns = get_posts( $dcargs );
                        $selected_city = get_query_var('cat_city');
                        $cat_query_params['cat_city'] = $selected_city;
                      ?>
                      <option selected>All Cities...</option>
                      <?php foreach($city_dropdowns as $city_option): ?>
                        <option <?php echo ($selected_city == $city_option->ID) ? 'selected' : ''; ?> value="<?php echo $city_option->ID; ?>"><?php echo $city_option->post_title; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                <?php elseif (in_array(get_post_type(), ['artist','city'])): ?>
                  <div class="dropdown_notice font-weight-bold ml-4">
                    <?php
                      echo $post->post_title;
                      if(get_post_type() == 'artist') {
                        echo ' : ', $subject;
                      }
                    ?>
                  </div>
                <?php endif; ?>
                </div>
                <div class="col-xs-12 col-sm-6 dropdown-selections">
                  <?php
                    $args = array(
                      "taxonomy" => "location_types",
                      "hide_empty" => true,
                      "orderby" => "name",
                      "order" => "ASC"
                    );
                    $active_term = get_queried_object();
                    $locations_cats = get_terms($args);
                    if(!empty($locations_cats)):
                      foreach($locations_cats as $term):
                        $term_link = get_term_link( $term );
                  ?>
                    <a href="<?php echo add_query_arg($cat_query_params, esc_url( $term_link )); ?>" rel="nofollow" class="dropdown-item<?php echo $active_term->term_id == $term->term_id ? ' active' : ''; ?>"><?php echo $term->name ?></a>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                  <?php
                    $args = array(
                      "post_type" => ["city","post"],
                      "numberposts" => "2",
                      "category__not_in" => [$reservedId],
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
      </div>

    </div>
  </div>
</div>
