<?php

/**
 * Pneumatic theme - Admin class
 * Enables utility features in the front-end for site admins
 */
class Pneumatic_Theme_Admin {
  function __construct() {
    if ( current_user_can( 'administrator' ) ) {
      add_action( 'wp_head',   array( $this, 'region_styles' ) );
      add_action( 'wp_footer', array( $this, 'footer_toggle' ) );
    }
  }
  public function region_styles() { ?>
    <style type="text/css">
      .region-toggle {
        cursor: pointer;
        position: fixed;
        right: 1em;
        bottom: 1em;
        opacity: 0.5;
      }
      .region-toggle:focus,
      .region-toggle:hover {
        opacity: 1;
      }
      .show-regions .w {
        outline: 3px solid rgba(100,0,100,0.5);
      }
      .show-regions .article{
        background: rgba(31, 103, 142, 0.5);
        outline: 3px solid rgba(53, 142, 31, 0.5);
      }
      .show-regions .container {
        outline: 5px solid rgba(100,0,200,0.1);
      }
      .show-regions #content,
      .show-regions #main {
        outline: 3px solid rgba(100,0,200,0.5);
      }
      .show-regions .article--inner {
        outline: 3px solid rgba(53, 142, 31, 0.5);
        background: rgba(53, 142, 31, 0.1);
      }
      .show-regions .article--header,
      .show-regions .article--content {
        background: #FFF;
        outline: 3px solid rgba(53, 142, 31, 0.5);
      }
      .show-regions .widget {
        outline: 3px solid rgba(53, 142, 31, 0.5);
      }
      .show-regions p {
        background: rgba(53, 142, 31, 0.5);
      }
    </style>
    <?php
  }

  public function footer_toggle() { ?>
    <div class="region-toggle btn">toggle regions</div>
    <script type="text/javascript">
      jQuery('.region-toggle').click( function() {
        jQuery('body').toggleClass( 'show-regions' );
      } );
    </script>
    <?php
  }
}
