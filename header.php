<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <!--[if lt IE 9]>
  <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
  <![endif]-->
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'pneumatic-theme' ); ?></a>

    <div class="bar-nav nav">
      <div class="bar-nav--inner">
        <p class="screen-reader-text label-bar-nav">Quick navigation menu:</p>
      </div>
    </div>

    <header class="header" role="banner">
      <div class="header--inner">
        <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
        <p style="display:none;" class="top-nav-toggle toggle-button"><?php _e( 'Menu', 'pneumatic-theme' ); ?></button>
      </div>
    </header>

    <nav class="top-nav nav">
      <div class="top-nav--inner">
        <p class="screen-reader-text label-site-nav">Site navigation menu:</p>
      </div>
    </nav>

  <div class="container">
