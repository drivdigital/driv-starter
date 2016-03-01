<?php

/**
 * drivdigital theme - Emoji class
 * Disable emoji that have by some bizarre reason been introduced in WP 4.2
 * http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
 */
class drivdigital__Emoji {
  /**
   * Disable emoji accross WordPress
   */
  static function disable_wp_emojicons() {
    // all actions related to emojis
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

    // filter to remove TinyMCE emojis
    add_filter( 'tiny_mce_plugins', 'drivdigital__Emoji::disable_emojicons_tinymce' );
  }

  /**
   * Filter to disable emoji in tiny mce
   */
  static function disable_emojicons_tinymce( $plugins ) {
    if ( is_array( $plugins ) )
      return array_diff( $plugins, array( 'wpemoji' ) );
    else
      return array();
  }
}
