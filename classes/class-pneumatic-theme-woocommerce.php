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
  }

  static function wrapper_start() {
  }

  static function wrapper_end() {
  }
}
