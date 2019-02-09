<?php get_template_part('templates/content', 'feature_block'); ?>
<?php $category_post_type = 'culture'; ?>
<?php include( locate_template( 'templates/content-related-content.php' ) ); ?>
<?php $category_post_type = 'travel'; ?>
<?php include( locate_template( 'templates/content-related-content.php' ) ); ?>
<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
