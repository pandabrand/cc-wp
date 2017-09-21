<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <?php get_template_part('templates/mobile_header'); ?>
    <div id="panel" class="cc-container">
      <!--[if IE]>
        <div class="alert alert-warning">
          <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
        </div>
      <![endif]-->
      <?php
        do_action('get_header');
        get_template_part('templates/header');
      ?>
      <div class="wrap container-fluid" role="document">
        <!-- div class="content row" -->
          <!-- main class="main" -->

            <?php include Wrapper\template_path(); ?>
          <!-- /main--><!-- /.main -->
        <!-- /div--><!-- /.content -->
      </div><!-- /.wrap -->
      <?php
        do_action('get_footer');
        get_template_part('templates/footer');
      ?>
    </div>
    <?php wp_footer(); ?>
  </body>
</html>
