<?php

/**
 * Pneumatic theme - Widget class
 */
class Pneumatic_Theme_Widget {
  /**
   * Register all widget areas used in the theme
   */
  static function widget_area() {
    // Register sidebars
    register_sidebar( array(
      'name'          => __( 'Widget Area', 'pneumatic-theme' ),
      'id'            => 'sidebar-1',
      'description'   => __( 'Add widgets here to appear in your sidebar.', 'pneumatic-theme' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
      'name'          => __( 'Footer', 'pneumatic-theme' ),
      'id'            => 'footer',
      'description'   => __( 'Add widgets here to appear in your footer.', 'pneumatic-theme' ),
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    ) );
  }
}
