<div class="row cc-row travel travel__header-color">
  <div class="col-12 travel travel__header">
    <div class="travel__header__title">
      Events
    </div>
  </div>
</div>
<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<div class="row cc-row">
  <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
  <?php endwhile; ?>
</div>
<?php the_posts_navigation(); ?>
