<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <!--[if lt IE 9]><script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script><![endif]-->
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope="" itemtype="http://schema.org/WebPage">
  <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'drivdigital' ); ?></a>

  <div class="container" role="document">

    <header class="header">
      <div class="header--inner w cf">
        <a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
      </div>
      <?php if ( has_nav_menu( 'primary' ) ) : ?>
        <div class="menu-bar"></div>
      <?php endif; ?>
    </header>

    <?php if ( has_nav_menu( 'primary' ) ) : ?>
      <nav class="top-nav nav">
        <div class="top-nav--inner w cf">
          <p class="screen-reader-text label-site-nav"><?php _e( 'Site navigation menu', 'drivdigital' );?></p>
          <?php
          // Primary navigation menu.
          wp_nav_menu( array(
            'container'      => false,
            'menu_class'     => 'nav-menu-primary nav-menu',
            'theme_location' => 'primary',
            'depth'          => '5',
            'fallback_cb'    => false,
            // 'walker'         => new drivdigital__Walker()
            ) );
          ?>

          </div>
        </nav>
      <?php endif; ?>

      <?php /* Menu activation and hover scripts */
      require_once "includes/menu-script.php"; ?>