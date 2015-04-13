<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <!--[if lt IE 9]>
  <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
  <![endif]-->
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'pneumatic-theme' ); ?></a>

<div class="container">

  <div class="bar-nav nav">
    <div class="bar-nav--inner w cf">
      <p class="screen-reader-text label-bar-nav">Navigation bar:</p>
      <?php
        // Navigation bar.
        wp_nav_menu( array(
          'container'      => false,
          'menu_class'     => 'nav-menu-bar nav-menu',
          'theme_location' => 'bar',
          'depth'          => '2',
          'fallback_cb'    => false,
        ) );
      ?>
    </div>
  </div>

  <header class="header" role="banner">
    <div class="header--inner w cf">
      <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
    </div>
    <div class="menu-bar"></div>
  </header>

  <?php if ( has_nav_menu( 'primary' ) ) : ?>
    <nav class="top-nav nav">
      <div class="top-nav--inner w cf">
        <p class="screen-reader-text label-site-nav">Site navigation menu:</p>
        <?php
          // Primary navigation menu.
          wp_nav_menu( array(
            'container'      => false,
            'menu_class'     => 'nav-menu-primary nav-menu',
            'theme_location' => 'primary',
            'depth'          => '5',
            'fallback_cb'    => false,
          ) );
        ?>
      </div>
    </nav>
  <?php endif; ?>
  <?php require_once "includes/menu-script.php"; ?>
  <script type="text/javascript">
  ( function( $ ) {
    // Expose the "clicked" handler to scripts in the footer
    window.clicked_handler = function() {
      $( '.clicked' ).removeClass( 'clicked' );
      $( this ).addClass( 'clicked' );
    };
    $(window).on( 'beforeunload', function() {
      $('body').addClass( 'unloading' );
    } );
    $( '.nav-menu a' ).click( window.clicked_handler );
  } ( jQuery ) );
  </script>

  <?php get_sidebar(); ?>
