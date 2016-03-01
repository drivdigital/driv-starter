<?php if ( is_active_sidebar( 'aside' ) ) : ?>
  <div class="t-4 wrapper-sidebar">
    <div id="widget-area" class="widget-area" role="complementary">
      <div class="widget-area--inner w cf">
        <?php dynamic_sidebar( 'aside' ); ?>
      </div>
    </div>

  </div>
<?php endif; ?>
