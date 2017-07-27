<?php get_template_part('templates/content', 'travel_header'); ?>
<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('layouts/travel', 'detail_header'); ?>
  <?php get_template_part('layouts/travel', 'detail_map'); ?>
<?php endwhile; ?>
