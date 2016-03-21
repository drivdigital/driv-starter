<?php

/**
 * drivdigital Theme - Base class
 */
class drivdigital_ {
  /**
   * Construct - Set up basic actions for the drivdigital
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
    require_once( 'classes/class-drivdigital-widget.php' );
    add_action( 'widgets_init', 'drivdigital_Widget::widget_area' );

    // Admin
    require_once( 'classes/class-drivdigital-admin.php' );
    new drivdigital__Admin();
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
    require_once( 'classes/class-drivdigital-post.php' );
    add_action( 'drivdigital-time', 'drivdigital__Post::print_time' );

    // Custom Demo Page
    require_once( 'classes/class-drivdigital-demo.php' );
    drivdigital_activation_page::demo_front_page();

    // Remove WP (generator) from rss feeds
    add_filter( 'the_generator', array( $this, 'return_empty' ) );

    // Fix p tag around images
    add_filter( 'the_content', array( $this, 'ptag_images' ) );

    // Remove Emoji functionality
    require_once( 'classes/class-drivdigital-emoji.php' );
    drivdigital__Emoji::disable_wp_emojicons();

    // Add walker for navigation
    require_once( 'classes/class-drivdigital-walker.php' );
  }

  /**
   * Theme support
   */
  public function theme_support() {
    // Register menus (used in header.php)
    register_nav_menus( array(
      'primary' => __( 'Primary Menu',   'drivdigital' ),
      'bar'     => __( 'Navigation bar', 'drivdigital' ),
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
    // require_once( 'classes/class-drivdigital-woocommerce.php' );
    // drivdigital__Woocommerce::woocommerce_support();
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
      wp_register_script( 'modernizr', $this->scry( '/assets/js/libs/modernizr.custom.min.js' ), array(), '2.5.3', false );
      wp_register_script( 'drivdigital-js-header', $this->scry( '/assets/js/scripts-header.min.js' ), array( 'jquery' ), '', false );
      wp_register_script( 'drivdigital-js-footer', $this->scry( '/assets/js/scripts-footer.min.js' ), array( 'jquery' ), '', true );

      // Enqueue scripts
      wp_enqueue_script( 'modernizr' );
      wp_enqueue_script( 'jquery' );
      wp_enqueue_script( 'drivdigital-js-header' );
      wp_enqueue_script( 'drivdigital-js-footer' );

      // Register styles
      wp_register_style( 'drivdigital-stylesheet', $this->scry( '/assets/css/style.css' ), array(), '', 'all' );
      wp_register_style( 'drivdigital-ie-only', $this->scry( '/assets/css/ie.css' ), array(), '' );

      // Add a conditional wrapper around the ie stylesheet
      $GLOBALS['wp_styles']->add_data( 'drivdigital-ie-only', 'conditional', 'lt IE 9' );

      // Enqueue styles
      wp_enqueue_style( 'drivdigital-stylesheet' );
      wp_enqueue_style( 'drivdigital-ie-only' );

      // Comment reply script for threaded comments
      if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
        wp_enqueue_script( 'comment-reply' );
      }

      // remove query string from scripts ?=4.4.2
      function _remove_script_version( $src ){
        $parts = explode( '?', $src );
        return $parts[0];
      }
      add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
      add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
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
    $uri = get_template_directory_uri();
    $dir = get_template_directory();
    $file_uri = $uri . $path .'?'. filemtime( $dir . $path );
    return apply_filters( 'drivdigital-scry', $file_uri );
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

// Allow SVGs to be used in the Media Uploader
function drivdigital_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'drivdigital_mime_types');


add_action( 'login_enqueue_scripts', 'drivdigital_login_css', 10 );
function drivdigital_login_css() { ?>
  <style type="text/css">
    <?php echo file_get_contents( get_template_directory() . '/assets/css/login.css' );?>
  </style>
<?php }

// URL to point to website
add_filter( 'login_headerurl', 'drivdigital_login_url' );
function drivdigital_login_url() {
  return home_url();
}

// Changing the alt text
add_filter( 'login_headertitle', 'drivdigital_login_title' );
function drivdigital_login_title() {
  return get_option( 'blogname' );
}

// Custom Backend Footer
function drivdigital_custom_admin_footer() {
  $developer = "Driv Digital AS";
  $url = "http://www.drivdigital.no";
  echo '<span id="footer-thankyou">' . __( 'Developed by', 'drivdigitaltheme' ) . ' <a href="' . $url . '" target="_blank">' . $developer . '</a></span>';
}

// Adding it to the admin area
add_filter( 'admin_footer_text', 'drivdigital_custom_admin_footer' );


$GLOBALS['drivdigital'] = new drivdigital_();
