<?php while (have_posts()) : the_post(); ?>
  <div class="row cc-row editorial_header">
    <div class="col-12">
      <?php get_template_part('layouts/editorial', 'header'); ?>
    </div>
  </div>
  <div class="row cc-row justify-content-center editorial__detail__article">
    <div class="col-sm-12 col-md-10">
      <main>
        <article <?php post_class(); ?>>
          <div class="row justify-content-center">
            <div class="editorial__detail__article__copy col-9">
              <?php if(get_field('background_image')): ?>
                <div class="editorial__detail__feature_media mb-4">
                    <img src="<?php echo the_post_thumbnail_url('large-feature'); ?>" class="img-fluid" />
                </div>
              <?php endif; ?>
              <?php the_content(); ?>
              <?php
                $photo_credit = get_field( 'photo_credit' );
                if($photo_credit):
              ?>
                <div class="editorial__detail__article-photo-credit">
                  photo by: <?= $photo_credit ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </article>
      </main>
    </div>
  </div>
  <?php get_template_part('templates/content', 'editorial-share-bar'); ?>
<?php endwhile; ?>
