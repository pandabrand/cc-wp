<div class="editorial__detail__header <?php add_billboard_class(); ?>">
  <?php $image  = get_field('background_image'); if($image): $size = 'large-feature'; ?>
    <div class="billboard__image" style="background-image:url('<?php echo wp_get_attachment_url( $image, $size); ?>')"></div>
  <?php else: ?>
    <div class="billboard__image" style="background-image:url('<?php echo the_post_thumbnail_url('large-feature'); ?>')"></div>  <?php endif; ?>
  <div class="billboard__filter"></div>
</div>
