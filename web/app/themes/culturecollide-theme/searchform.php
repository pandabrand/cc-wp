<form class="form search-form" action="/" method="get">
  <div class="d-flex justify-content-end">
    <input type="text" name="s" id="search" class="input form__input form-control search-form__input" placeholder="search..." value="<?php the_search_query(); ?>" />
    <button class="btn btn-outline-secondary search-form__button" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    <button class="btn btn-outline-secondary search-form__button search-form__button-close" type="submit"><i class="fa fa-times" aria-hidden="true"></i></button>
  </div>
</form>
