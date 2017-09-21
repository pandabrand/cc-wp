<nav id="slideout-menu" class="navbar navbar__slideout-menu navbar-custom">
  <div class="d-flex flex-row justify-content-between">
    <div class="navbar__logo__wrapper">
      <a href="/">
        <img src="<?php echo get_template_directory_uri() . '/dist/images/logo@1x.png'; ?>" srcset="<?php echo get_template_directory_uri() . '/dist/images/logo@1x.png'; ?> 211w, <?php echo get_template_directory_uri() . '/dist/images/logo@2x.png'; ?> 422w, <?php echo get_template_directory_uri() . '/dist/images/logo@3x.png'; ?> 633w" class="navbar-brand logo" height="30" />
      </a>
    </div>
    <button class="navbar-toggler" type="button">
      <i class="fa fa-times"></i>
    </button>
  </div>
  <div class="navbar__mobile__wrapper">
    <?php
      if (has_nav_menu('primary_navigation')):
        wp_nav_menu([
          'theme_location' => 'primary_navigation',
          'menu_class' => 'navbar-nav justify-content-center navigation__list navigation__list__header navbar__navigation__list__header',
          'menu_id' => 'header-menu'
        ]);
      endif;
    ?>
    <div class="social-icons social-icons__header mt-4">
      <div class="social-icons__header-row">
        <div class="social-icons__cta social-icons__cta__header d-flex flex-row">
          Follow
          <ul class="social-icons__list social-icons__list__header">
            <li class="social-icons__item social-icons__item__header">
              <a href="https://www.facebook.com/culturecollideofficial">
                <i class="fa fa-facebook"></i>
              </a>
            </li>
            <li class="social-icons__item social-icons__item__header">
              <a href="https://twitter.com/@culturecollide">
                <i class="fa fa-twitter"></i>
              </a>
            </li>
            <li class="social-icons__item social-icons__item__header">
              <a href="https://www.instagram.com/officialculturecollide/">
                <i class="fa fa-instagram"></i>
              </a>
            </li>
            <li class="social-icons__item social-icons__item__header">
              <a href="https://www.linkedin.com/company-beta/3774623/">
                <i class="fa fa-linkedin"></i>
              </a>
            </li>
            <li class="social-icons__item social-icons__item__header">
              <a href="http://culturecollideofficial.tumblr.com">
                <i class="fa fa-tumblr"></i>
              </a>
            </li>
            <li class="social-icons__item social-icons__item__header">
              <a href="https://www.youtube.com/user/culturecollide">
                <i class="fa fa-youtube-play"></i>
              </a>
            </li>
            <li class="social-icons__item social-icons__item__header">
              <a href="https://open.spotify.com/user/culturecollide">
                <i class="fa fa-spotify"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>
