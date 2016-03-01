<script type="text/javascript">
  ( function( $ ) {
  // Menu & cart:
    // Add a class to the body to allow css targeting. @see issue #8
    var body = $( 'body' ).addClass( 'menu-inactive' );
    // Hide the menu and cart
    var navigation = $( '.top-nav' );
    navigation.addClass( 'hide' );

    // Create menu and cart buttons with a wrapper
    var menu_bar = $( '.menu-bar' );
    var btn_menu = $( '<div>' ).addClass( 'mto button-menu' ).text( '<?php _e( "Menu" ); ?>' );

    // Wait for doc ready
    $( function() {
      // Show the menu on click
      btn_menu.click( function() {
        $(this).toggleClass('open');
        navigation.toggleClass( 'hide' );
        // Add a class to the body to allow css targeting. @see issue #8
        body.toggleClass( 'menu-active' ).toggleClass( 'menu-inactive' );
      } );
      // Add the buttons to the wrapper
      menu_bar.append( btn_menu );

      // Hide sub-menus
      $( '.sub-menu', navigation ).each( function() {
        var item = $( this );
        item.addClass( 'hide' ).prev().one( 'click', function( e ) {
          if ( Modernizr.touch || !min_width( 64 ) ) {
            e.preventDefault();
            $( this ).addClass( 'open' );
            item.removeClass( 'hide' );
          }
        } );
      } );
    } ); // - ready

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