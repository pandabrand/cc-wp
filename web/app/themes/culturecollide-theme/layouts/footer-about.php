<div class="menu-footer-about-container">
  <div class="text-center footer-cta">
    get in touch
  </div>
  <?php
  if (has_nav_menu('footer_menu_about')) :
    wp_nav_menu([
      'theme_location' => 'footer_menu_about',
      'menu_class' => 'nav navigation__list navigation__list__footer footer-nav-menu-about',
      'menu_id' => 'footer-menu-about',
    ]);
  endif;
  ?>
</div>
