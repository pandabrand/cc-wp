<?php while (have_posts()) : the_post(); ?>
  <div class="row cc-row editorial_header">
    <div class="col-12">
      <?php get_template_part('layouts/event', 'header'); ?>
    </div>
  </div>
  <div class="row cc-row justify-content-center editorial__detail__article">
    <div class="col-sm-12 col-md-10">
      <main>
        <article <?php post_class(); ?>>
          <div class="row justify-content-center">
            <div class="editorial__detail__article__copy col-10">
              <div class="event__detail_subtitle">
                <div class="event__detail_subtitle__line">
                  When: <?php echo get_field('event_date'); ?>
                </div>
                <div class="event_detail_subtitle__line">
                  Where: <?php $address = get_field('event_address'); echo $address['address']; ?>
                </div>
              </div>
              <div class="editorial__detail__article__copy event__detail__article__copy">
                <?php the_content(); ?>
              </div>
            </div>
          </div>
        </article>
      </main>
    </div>
  </div>
  <?php get_template_part('templates/content', 'editorial-share-bar'); ?>
<?php endwhile; ?>
