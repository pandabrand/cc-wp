<div class="container-fluid">
  <div class="row cc-row">
    <footer role="contentinfo" class="footer col-12">
      <div class="<?php echo is_page('about') ? 'footer-menu-about' : 'footer-menu' ?>">
        <?php if( is_page('about') ): ?>
          <?php get_template_part('layouts/footer', 'about'); ?>
        <?php else: ?>
          <?php get_template_part('layouts/footer', 'base'); ?>
        <?php endif; ?>
      </div>
    </footer>
  </div>
</div>
