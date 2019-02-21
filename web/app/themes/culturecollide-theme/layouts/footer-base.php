<?php
if (has_nav_menu('footer_menu_one')) :
  wp_nav_menu([
    'theme_location' => 'footer_menu_one',
    'menu_class' => 'nav navigation__list navigation__list__footer footer-nav-menu',
    'menu_id' => 'footer-menu-one',
  ]);
endif;
?>
<div class="menu-footer-two-container">
  <ul id="footer-menu-two" class="nav menu-footer-two-container__list navigation__list navigation__list__footer footer-details">
    <li class="nav-item navigation__item navigation__item__footer"><div class="nav-link">&copy; <?= date( 'Y' ); ?> Culture Collide</div></li>
    <li class="nav-item navigation__item navigation__item__footer"><a class="nav-link" href="/terms-conditions/">Terms &amp; Conditions</a></li>
    <li class="nav-item navigation__item navigation__item__footer"><a class="nav-link" href="/privacy-policy/">Privacy Policy</a></li>
  </ul>
</div>
