<div class="col-xs-12 col-sm-6 event__block">
  <div class="event-block-wrapper__square">
    <div class="event-block__square">
      <div class="event-image__square" style="background-image:url('<?php echo the_post_thumbnail_url('large-feature'); ?>')">
        <div class="event-block">
          <div class="event-block__title">
            <?php the_title(); ?>
          </div>
          <div class="event-block__details d-flex justify-content-between">
            <div class="event-block__details-date">
              <?php echo get_field('event_date'); ?>
            </div>
            <div class="event-block__details-location">
              <?php $address = get_field('event_address'); echo $address['address']; ?>
            </div>
          </div>
          <div class="event-block__excerpt hidden-xs-down">
            <?php the_excerpt(); ?>
          </div>
          <a href="<?php the_permalink(); ?>" class="invert button button--outline button--outline--white button--small">
            More info
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
