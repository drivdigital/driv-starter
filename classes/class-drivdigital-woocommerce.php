<?php

/**
 * drivdigital theme - Woocommerce class
 */
class drivdigital__Woocommerce {
  /**
   * Define support for the woocommerce plugin
   * http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
   */
  static function woocommerce_support() {
    // Add support
    add_theme_support( 'woocommerce' );

    // Remove main woocommerce actions
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

    // Add theme woocommerce actions
    // Main content
    add_action( 'woocommerce_before_main_content', 'drivdigital__Woocommerce::wrapper_start' );
    add_action( 'woocommerce_after_main_content', 'drivdigital__Woocommerce::wrapper_end' );
    add_action( 'get_footer', 'drivdigital__Woocommerce::wrapper_page_end' );

    // Archive pages
    // add_action( 'woocommerce_before_shop_loop', 'drivdigital__Woocommerce::wrapper_loop_start' );
    // add_action( 'woocommerce_after_shop_loop', 'drivdigital__Woocommerce::wrapper_loop_end' );

    // Archive pages
    // add_action( 'drivdigital_archive_before', 'drivdigital__Woocommerce::wrapper_loop_start' );
    // add_action( 'drivdigital_archive_after', 'drivdigital__Woocommerce::wrapper_loop_end' );

    // Add custom css for woocommerce
    add_action( 'wp_enqueue_scripts', 'drivdigital__Woocommerce::scripts_and_styles', 999 );
  }

  /**
   * Scripts and styles
   */
  static function scripts_and_styles() {
    if ( !is_admin() ) {
      // Register styles
      wp_register_style( 'drivdigital-woocommerce-stylesheet', $GLOBALS['drivdigital']->scry( '/assets/css/woocommerce.css' ), array(), '', 'all' );

      // Enqueue styles
      wp_enqueue_style( 'drivdigital-woocommerce-stylesheet' );
    }
  }

  /**
   * Before woocommerce content
   */
  static function wrapper_start() {
    ?>
    <div id="content" class="cf w">
    <div id='main' class='t-8'>
    <?php
  }
  /**
   * After woocommerce content
   */
  static function wrapper_end() {
    ?>
    </div>
    <?php
  }

  /**
   * Before woocommerce content
   */
  static function wrapper_loop_start() {
    ?>
    <div class='t-8'>
    <?php
  }
  /**
   * After woocommerce content
   */
  static function wrapper_loop_end() {
    self::wrapper_end();
  }

  /**
   * After woocommerce content
   */
  static function wrapper_page_end( $name ) {
    if ( 'shop' !== $name )
      return;
    ?>
    </div>
    <?php
  }
}
