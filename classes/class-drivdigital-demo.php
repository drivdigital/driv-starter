<?php

class drivdigital_activation_page {

  static function demo_front_page() {
    /**
     * Installing a page for us to set as the home page
     */
    if ( isset( $_GET['activated'] ) && is_admin() ) {
      $content = wp_remote_get( 'http://drivdigital.github.io/driv-starter/' );
      if( is_array($content) ) {
        $driv_theme_page_title    = 'Driv Theme Readme';
        $body = $content['body']; // use the content from drivdigital.github.io
      } else {
        $driv_theme_page_title    = 'Driv Theme Styleguide';
        $body = file_get_contents( get_stylesheet_directory_uri() . '/includes/_html-elements.html' );
      }
      $driv_theme_page_content  = $body;
      $driv_theme_page_template = 'page-templates/home.php';
      $page_check = get_page_by_title( $driv_theme_page_title );
      $driv_theme_page = array(
        'post_type'    => 'page',
        'post_title'   => $driv_theme_page_title,
        'post_content' => $driv_theme_page_content,
        'post_status'  => 'publish',
        'post_author'  => 1,
       );
      if( !isset( $page_check->ID ) ){
        $driv_theme_page_id = wp_insert_post( $driv_theme_page );
        if( !empty( $driv_theme_page_template ) ){
          update_post_meta( $driv_theme_page_id, '_wp_page_template', $driv_theme_page_template );

          update_option( 'show_on_front', 'page' );
          update_option( 'page_on_front', $driv_theme_page_id );
        }
      }
    }
  }
}