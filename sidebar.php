<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
  <div class="t-4 wrapper-sidebar">
    <div id="widget-area" class="widget-area" role="complementary">
      <div class="widget-area--inner w cf">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
      </div>
    </div>

  </div>
<?php endif; ?>
