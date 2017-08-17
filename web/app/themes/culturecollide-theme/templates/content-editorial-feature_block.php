<?php
$args = array(
'posts_per_page' => 3,
'post_type' => ['post'],
'orderby' => ['rand','title'],
'order' => 'ASC'
);
$feature_query = new WP_Query($args);
if($feature_query->have_posts()): ?>
<div class="row cc-row feature-block_color">
<?php
while ($feature_query->have_posts()): $feature_query->the_post();
?>
<?php switch ($feature_query->current_post):
case 0: ?>
<div class="col-md-6 col-sm-12">
<?php include( locate_template('layouts/feature-block__1-2.php')); ?>
</div>
<?php
break;
case 1: ?>
<div class="col-md-6 col-sm-12">
<?php include( locate_template('layouts/feature-block__2-1-long.php')); ?>
<?php
break;
case 2:
?>
<?php include( locate_template('layouts/feature-block__2-1-long.php')); ?>
</div>
<?php break ;?>
<?php endswitch; ?>
<?php endwhile; ?>
</div>
<?php endif; ?>
<?php wp_reset_query(); ?>
