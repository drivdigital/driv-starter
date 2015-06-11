<?php

/**
 * Pneumatic theme - Woocommerce class
 */
class Pneumatic_Theme_Woocommerce {
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
    add_action( 'woocommerce_before_main_content', 'Pneumatic_Theme_Woocommerce::wrapper_start' );
    add_action( 'woocommerce_after_main_content', 'Pneumatic_Theme_Woocommerce::wrapper_end' );

    // Add custom css for woocommerce
    add_action( 'wp_enqueue_scripts', 'Pneumatic_Theme_Woocommerce::scripts_and_styles', 999 );
  }

  /**
   * Scripts and styles
   */
  static function scripts_and_styles() {
    if ( !is_admin() ) {
      // Register styles
      wp_register_style( 'pneumatic-woocommerce-stylesheet', $GLOBALS['pneumatic-theme']->scry( '/css/woocommerce.css' ), array(), '', 'all' );

      // Enqueue styles
      wp_enqueue_style( 'pneumatic-woocommerce-stylesheet' );
    }
  }

  /**
   * Before woocommerce content
   */
  static function wrapper_start() {
    ?>
    <div class="content-wrapper">
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
}
