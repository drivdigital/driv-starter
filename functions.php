<?php

class Pneumatic_Theme {
  /**
   * Construct - Set up basic actions for the pneumatich-theme
   */
  public function __construct() {
    add_action( 'init', array( $this, 'init' ) );
  }

  /**
   * Init
   * Initialise the theme and configure necessary settings
   */
  public function init() {
    if ( define( 'DOING_AJAX' ) && DOING_AJAX ) {
      // Do not do unecessary processing during AJAX requests. Skip the rest from this point.
      return;
    }
    // Load the class files
    require_once( 'classes/class-pneumatic-theme-post.php' );
    add_action( 'pneumatic-theme-time', array( 'Pneumatic_Theme_Post::print_time' ) );

    // Add theme support
    $this->theme_support();

    // Remove WP (generator) from rss feeds
    add_filter( 'the_generator', array( $this, 'return_empty' ) );

    // Fix p tag around images
    add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  }

  /**
   * Theme support
   */
  public function theme_support() {
    // Featured images
    add_theme_support( 'post-thumbnails' );
    // Menus
    add_theme_support( 'menus' );
  }

  /**
   * <p> Tag on images - fix
   */
  function ptag_images( $content ) {
    // Remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
    return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
  }

  /**
   * Return an empty string
   * Useful as a filter
   */
  public function return_empty() {
    return '';
  }
}

new Pneumatic_Theme();
