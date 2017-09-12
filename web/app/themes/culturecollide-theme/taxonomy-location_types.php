<?php get_template_part('templates/content', 'travel_header'); ?>
<div class="row cc-row travel travel__detail__map__row">
  <div class="col-sm-12 col-md-6 push-md-6">
    <?php get_template_part('layouts/travel', 'map_block'); ?>
  </div>
  <div class="col-sm-12 col-md-6 pull-md-6">
    <div class="travel__detail__map__list--wrapper">
      <div class="travel__detail__map__list">
        <?php if (!have_posts()) : ?>
          <div class="alert alert-warning">
            <?php _e('Sorry, no results were found.', 'sage'); ?>
          </div>
          <?php get_search_form(); ?>
        <?php else: ?>
          <?php while (have_posts()) : the_post(); ?>
            <div class="row travel__detail__map__item <?php get_the_id(); ?>" id="<?php echo get_the_id(); ?>">
              <div class="col-12">
                <div class="card card__2-1 card__2-1-travel d-flex flex-column">
                    <?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large-feature' ); ?>
                    <div class="card__image"  style="background-image:<?php echo cc_background_image_filter(); ?>, url('<?php echo esc_url( $large_image_url[0] ); ?>')">
                      <div class="card__category-block">
                        <div class="<?php echo get_post_icon_class(); ?> mr-2"></div>
                        <div class="card__category-block__category-details pl-3">
                          <div class="card__category-block__category-type">
                            <?php echo get_category_type_title();?>
                          </div>
                          <div class="card__category-block__category-info">
                            <?php echo get_category_type_subject(); ?>
                          </div>
                        </div>
                      </div>
                      <div class="card__category-line"></div>
                      <div class="card__filter"></div>
                    </div><!-- card__image -->
                    <div class="card__body">
                    	<div class="card__copy">
                    		<div class="card__title">
                    			<?php echo get_card_title(); ?>
                    		</div>
                    		<div class="card__text">
                    			<?php the_content(); ?>
                    		</div>
                    		<div class="card__address">
                    			<?php $address = get_field('address'); ?>
                    			<?php echo $address['address']; ?>
                    		</div>
                        <div class="card__links d-flex justify-content-between">
                          <div class="card__link">
                            <a href="<?php the_permalink(); ?>" rel="external" target="_blank"><i class="fa fa-desktop"></i> website</a>
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
          <?php endwhile; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
