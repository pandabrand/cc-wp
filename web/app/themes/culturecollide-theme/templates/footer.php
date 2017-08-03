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
        <div class="menu-footer-two-container">
          <ul id="footer-menu-two" class="nav justify-content-center navigation__list navigation__list__footer footer-details">
            <li class="nav-item navigation__item navigation__item__footer"><div class="nav-link">&copy; <?= date( 'Y' ); ?> Culture Collide</div></li>
            <li class="nav-item navigation__item navigation__item__footer"><a class="nav-link" href="https://culturecollide.dev/terms-conditions/">Terms &amp; Conditions</a></li>
            <li class="nav-item navigation__item navigation__item__footer"><a class="nav-link" href="https://culturecollide.dev/privacy-policy/">Privacy Policy</a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
