<?php get_template_part('templates/page', 'header'); ?>
<?php if (!have_posts()) : ?>
  <div class="row cc-row justify-content-center">
    <div class="col-10">
      <div class="alert alert-warning">
        <?php _e('Sorry, no results were found.', 'sage'); ?>
      </div>
      <?php get_search_form(); ?>
    </div>
  </div>
<?php endif; ?>
<div class="row cc-row">
  <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
  <?php endwhile; ?>
</div>
<div class="row cc-row">
  <?php the_posts_navigation(
    array(
      "prev_text" => sprintf( __( 'More: %s' ), get_post_type() ),
      "next_text" => sprintf( __( 'Previous: %s' ), get_post_type() ),
      'screen_reader_text' => sprintf( __( '%s Navigation' ), get_post_type() )
    )
  ); ?>
</div>
