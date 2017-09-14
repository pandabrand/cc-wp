<header class="header banner">
  <nav class="navbar navbar-toggleable-md navbar-custom">
    <div class="navbar__mobile__wrapper">
      <div class="navbar-toggler navbar-toggler-right link_search-form_opener link_search-mobile_link"><a href="#" class="nav-link">search</a></div>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavigationListHeader" aria-controls="navbarNavigationListHeader" aria-expanded="false" aria-label="Toggle Navigation">
        <i class="fa fa-bars"></i>
      </button>
    </div>
    <div class="navbar__logo__wrapper">
      <a href="/">
        <img src="<?php echo get_template_directory_uri() . '/dist/images/logo@1x.png'; ?>" srcset="<?php echo get_template_directory_uri() . '/dist/images/logo@1x.png'; ?> 211w, <?php echo get_template_directory_uri() . '/dist/images/logo@2x.png'; ?> 422w, <?php echo get_template_directory_uri() . '/dist/images/logo@3x.png'; ?> 633w" class="navbar-brand logo" height="47" />
      </a>
    </div>
    <div class="collapse navbar-collapse justify-content-end navbar__navigation__header" id="navbarNavigationListHeader">
      <div class="social-icons social-icons__header">
        <div class="social-icons__header-row">
          <div class="social-icons__cta social-icons__cta__header">
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
      <?php
        if (has_nav_menu('primary_navigation')):
          wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'menu_class' => 'navbar-nav justify-content-end pull-right navigation__list navigation__list__header navbar__navigation__list__header',
            'menu_id' => 'header-menu'
          ]);
        endif;
      ?>
    </div>
  </nav>
</header>
<div class="container-fluid search search-form__container">
  <div class="row cc-row search-form-row">
    <div class="search-form-wrapper col-12 rounded-bottom">
      <?php get_search_form(); ?>
    </div>
  </div>
</div>
