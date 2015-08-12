<script type="text/javascript">
  ( function( $ ) {
  // Menu & cart:
    // Add a class to the body to allow css targeting. @see issue #8
    var body = $( 'body' ).addClass( 'menu-inactive' );
    // Hide the menu and cart
    var navigation = $( '.container > .nav' );
    navigation.addClass( 'hide' );

    // Create menu and cart buttons with a wrapper
    var menu_bar = $( '.menu-bar' );
    var btn_menu = $( '<div>' ).addClass( 'mto button-menu' ).text( '<?php _e( "Menu" ); ?>' );

    // Wait for doc ready
    $( function() {
      // @TODO: Figure out a more general way of selecting everything other thant the menu
      var content = $( '#content, .header, .footer, #widget-area, .content-wrapper' );
      // Show the menu on click
      btn_menu.click( function() {
        content.addClass( 'hide' );
        navigation.removeClass( 'hide' );
        // Add a class to the body to allow css targeting. @see issue #8
        body.addClass( 'menu-active' ).removeClass( 'menu-active' );
      } );
      // Add the buttons to the wrapper
      menu_bar.append( btn_menu );

      // Create a close button for the menu
      var btn_close = $( '<div>' ).addClass( 'button-close' ).text( '<?php _e( "Close" ); ?>' );
      btn_close.click( function() {
        content.removeClass( 'hide' );
        navigation.addClass( 'hide' );
        // Add a class to the body to allow css targeting. @see issue #8
        body.addClass( 'menu-inactive' ).removeClass( 'menu-inactive' );
      } );
      navigation.find( 'ul:eq(0)' ).prepend( $( '<li>' ).append( btn_close ) );

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
  } ( jQuery ) );
</script>
