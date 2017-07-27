<div class="container-fluid">
  <div class="row cc-row">
    <footer role="contentinfo" class="footer col-12">
      <div class="footer-menu">
        <?php
        if (has_nav_menu('footer_menu_one')) :
          wp_nav_menu([
            'theme_location' => 'footer_menu_one',
            'menu_class' => 'nav justify-content-center navigation__list navigation__list__footer footer-nav-menu',
            'menu_id' => 'footer-menu-one',
            'container_class' => 'hidden-sm-down'
          ]);
        endif;
        ?>
        <?php
        if (has_nav_menu('footer_menu_two')) :
          wp_nav_menu([
            'theme_location' => 'footer_menu_two',
            'menu_class' => 'nav justify-content-center navigation__list navigation__list__footer footer-details',
            'menu_id' => 'footer-menu-two'
          ]);
        endif;
        ?>
      </div>
    </footer>
  </div>
</div>
