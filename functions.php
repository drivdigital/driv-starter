<?php

/**
 * Pneumatic Theme - Base class
 */
class Pneumatic_Theme {
  /**
   * Construct - Set up basic actions for the pneumatic-theme
   */
  public function __construct() {
    // Add actions
    add_action( 'init', array( $this, 'init' ) );
    add_action( 'after_setup_theme', array( $this, 'theme_support' ) );

    // Add filters
    add_filter( 'jpeg_quality', array( $this, 'jpeg_quality' ) );
    add_filter( 'get_the_excerpt', array( $this, 'fix_excerpt' ), 9, 1 );
    add_filter( 'tiny_mce_before_init', array( $this, 'tinymce_options' ) );

    // Register widget areas (sidebars[sic])
    require_once( 'classes/class-pneumatic-theme-widget.php' );
    add_action( 'widgets_init', 'Pneumatic_Theme_Widget::widget_area' );
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
   * hooked on 'the_content'
   */
  function ptag_images( $content ) {
    // Remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
    return preg_replace( '/<p[^>]*>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
  }

  /**
   * JPEG Quality filter
   * hooked on 'jpeg_quality'
   */
  public function jpeg_quality( $q ) {
    return $q;
  }

  /**
   * Include icons file
   * hooked on 'wp_head'
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

  /**
   * Fix the excerpt
   * Use the excerpt if it is provided. (meta value)
   * Use above the fold <!--more--> text if there is no excerpt text.
   * Use trimmed text if neither alternative above is present.
   * @param  string $text Excerpt text
   * @return string       The fixed excerpt text
   */
  function fix_excerpt( $text ) {
    if ( !$text ) {
      global $page, $pages;
      if ( $page > count( $pages ) ) // if the requested page doesn't exist
        $page = count( $pages ); // give them the highest numbered page that DOES exist
      $content = $pages[$page - 1];
      if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
        $content = explode( $matches[0], $content, 2 );
        return $content[0];
      }
    }
    return $text;
  }


  /**
   * Adjust options for TinyMCE
   * hooked on 'tiny_mce_before_init'
   * @param array $init An array of setup parameters used by TinyMCE
   */
  public function tinymce_options( $init ) {

    $plugins = explode( ',', $init['toolbar2'] );
    foreach( array( 'underline', 'alignjustify', 'forecolor', 'pastetext', 'outdent', 'indent' ) as $undesirable ) {
      if ( ( $key = array_search( $undesirable, $plugins ) ) !== false ) {
        unset( $plugins[$key] );
      }
    }

    $init['toolbar2'] = implode( ',', $plugins );
    $init['block_formats'] = 'Paragraph=p;Pre=pre;Heading 2=h2;Heading 3=h3;Heading 4=h4';
    return $init;
  }

}

new Pneumatic_Theme();
