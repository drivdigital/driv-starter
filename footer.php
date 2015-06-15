
    </div>

    <!-- Insert content in Footer widget in WP-admin in order to make it visible,
    the footer is designed to hold three columns -->
    <?php if ( is_active_sidebar( 'footer' ) ) : ?>
      <footer class="footer widget-area" role="footer">
        <div class="widget-area--inner w">
        <?php dynamic_sidebar( 'footer' ); ?>
        </div>
      </footer>
    <?php endif; ?>
    <?php wp_footer(); ?>

  </body>
</html>
