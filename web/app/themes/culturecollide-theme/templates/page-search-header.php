<?php use Roots\Sage\Titles; ?>

<div class="container-fluid">
  <div class="row cc-row justify-content-center search-results-header">
    <div class="page-header col-6 text-center">
      <h3><?= cc_archive_title(); ?></h3>
      <div class="search-results">
        <?php
          $search_query = get_query_var('s');
        ?>
        Results for <?php echo "' ", $search_query, " '"; ?>
      </div>
    </div>
  </div>
</div>
