<div class="row cc-row editorial_header">
  <div class="col-12">
    <?php get_template_part('layouts/about', 'header'); ?>
  </div>
</div>
<div class="row cc-row justify-content-center editorial__detail__article about">
  <div class="col-11">
    <main>
      <article <?php post_class(); ?>>
        <div class="editorial__detail__feature_media">
        </div>
        <div class="row justify-content-center">
          <div class="editorial__detail__article__copy col-9">
            <?php the_content(); ?>
          </div>
        </div>
      </article>
    </main>
  </div>
</div>
