<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php get_template_part('templates/content', 'travel_header'); ?>
<div class="row cc-row travel travel__detail__map__row">
  <div class="col-6 push-6">
    <?php get_template_part('layouts/travel', 'map_block'); ?>
  </div>
  <div class="col-6 pull-6 travel__detail__map__list">
    <?php while (have_posts()) : the_post(); ?>
      <div class="row travel__detail__map__item <?php get_the_id(); ?>" id="<?php echo get_the_id(); ?>">
        <div class="col-12">
          <div class="card card__2-1">
              <a href="#" class="block__link">
                <?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large-feature' ); ?>
                <div class="card__image"  style="background-image:url('<?php echo esc_url( $large_image_url[0] ); ?>')">
                  <div class="card__category-block">
                    <div class="<?php echo get_post_icon_class(); ?>"></div>
                    <div class="card__category-block__category-details">
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
                  <div class="card__body">
                    <div class="card__copy">
                      <div class="card__title">
                        <?php echo get_card_title(); ?>
                      </div>
                      <div class="card__text">
                        <?php the_content(); ?>
                      </div>
                    </div>
                  </div>
                </div>
              </a>

          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>
