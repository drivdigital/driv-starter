<?php

/**
 * drivdigital theme - Post class
 */
class drivdigital__Post {
  static function print_time( $classes ) {
    $format = '<time class="%s" datetime="%s" itemprop="datePublished">%s</time>';
    $datetime = get_the_time('Y-m-d');
    $time = get_the_time( get_option( 'date_format' ) );

    printf( $format, $classes, $datetime, $time );
  }
}
