<?php

/**
 * Pneumatic Theme - Base class
 */
class Pneumatic_Theme {
  /**
   * Construct - Set up basic actions for the pneumatic-theme
   */
  public function __construct() {
    // Add init actions
    add_action( 'init', array( $this, 'init' ) );
    add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
  }

  /**
   * Init
   * Initialise the theme and configure necessary settings
   */
  public function init() {
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
      // Skip any unecessary processing during AJAX requests.
      return;
    }

    // Register widget areas (sidebars[sic])
    require_once( 'classes/class-pneumatic-theme-widget.php' );
    add_action( 'widgets_init', 'Pneumatic_Theme_Widget::widget_area' );

    // Basic setup for posts
    require_once( 'classes/class-pneumatic-theme-post.php' );
    add_action( 'pneumatic-theme-time', 'Pneumatic_Theme_Post::print_time' );

    add_action( 'wp_head', array( $this, 'icons' ) );

    // Remove WP (generator) from rss feeds
    add_filter( 'the_generator', array( $this, 'return_empty' ) );

    // Fix p tag around images
    add_filter( 'the_content', array( $this, 'ptag_images' ) );
  }

  /**
   * Theme support
   */
  public function theme_support() {
    // Register menus (used in header.php)
    register_nav_menus( array(
      'primary' => __( 'Primary Menu',   'pneumatic-theme' ),
      'bar'     => __( 'Navigation bar', 'pneumatic-theme' ),
    ) );

    // Enqueue scripts and styles
    add_action( 'wp_enqueue_scripts', array( $this, 'scripts_and_styles'), 999 );
    // Custom image captions
    add_filter( 'img_caption_shortcode', array( $this, 'image_caption' ), 10, 3 );

    // Featured images
    add_theme_support( 'post-thumbnails' );
    // Menus
    add_theme_support( 'menus' );
    // Woocommerce
    require_once( 'classes/class-pneumatic-theme-woocommerce.php' );
    Pneumatic_Theme_Woocommerce::woocommerce_support();
    // Let WordPress handle the title
    add_theme_support( 'title-tag' );
    // Add HTML5 support
    add_theme_support( 'html5', array(
      'gallery',
      'comment-list',
      'search-form',
      'comment-form'
    ) );
  }

  /**
   * Scripts and styles
   */
  public function scripts_and_styles() {
    if (!is_admin()) {

      // Register scripts
      wp_register_script( 'modernizr', $this->scry( '/js/libs/modernizr.custom.min.js' ), array(), '2.5.3', false );
      wp_register_script( 'pneumatic-js-header', $this->scry( '/js/scripts-header.js' ), array( 'jquery' ), '', false );
      wp_register_script( 'pneumatic-js-footer', $this->scry( '/js/scripts-footer.js' ), array( 'jquery' ), '', true );

      // Enqueue scripts
      wp_enqueue_script( 'modernizr' );
      wp_enqueue_script( 'jquery' );
      wp_enqueue_script( 'pneumatic-js-header' );
      wp_enqueue_script( 'pneumatic-js-footer' );

      // Register styles
      wp_register_style( 'pneumatic-stylesheet', $this->scry( '/css/style.css' ), array(), '', 'all' );
      wp_register_style( 'pneumatic-ie-only', $this->scry( '/css/ie.css' ), array(), '' );

      // Add a conditional wrapper around the ie stylesheet
      $GLOBALS['wp_styles']->add_data( 'pneumatic-ie-only', 'conditional', 'lt IE 9' );

      // Enqueue styles
      wp_enqueue_style( 'pneumatic-stylesheet' );
      wp_enqueue_style( 'pneumatic-ie-only' );

      // Comment reply script for threaded comments
      if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
        wp_enqueue_script( 'comment-reply' );
      }

    }
  }

  /**
   * Image caption
   * Same as core, but adds a .wp-caption--inner wrapper for the content
   */
  public function image_caption( $caption, $attr, $content = null ) {
    extract( shortcode_atts( array(
      'id'    => '',
      'align' => 'alignnone',
      'width' => '',
      'caption' => ''
    ), $attr ) );
    if ( 1 > (int) $width || empty($caption) ) { return ''; }
    $id = $id ? ' id="' . esc_attr($id) . '" ' : $id;
    $align = esc_attr($align);
    return "<div$id  class=\"wp-caption  $align\"><div class=\"wp-caption--inner\">". do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div></div>';
  }

  /**
   * Scry - determine the css & js uri based on a relative path
   * Also implement cache busting basted on file make time
   */
  public function scry( $path ) {
    $uri = get_stylesheet_directory_uri();
    $dir = get_template_directory();
    $file_uri = $uri . $path .'?'. filemtime( $dir . $path );
    return apply_filters( 'pneumatic-theme-scry', $file_uri );
  }

  /**
   * <p> Tag on images - fix
   */
  function ptag_images( $content ) {
    // Remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
    return preg_replace( '/<p[^>]*>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
  }

  /**
   * Include icons file
   * hooked to wp_head
   */
  public function icons() {
    require_once get_template_directory() .'/includes/icons.php';
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
