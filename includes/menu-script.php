<script type="text/javascript">
  ( function( $ ) {
  // Menu & cart:
    // Hide the menu and cart
    var navigation = $( '.container > .nav' );
    navigation.addClass( 'hide' );

    // Create menu and cart buttons with a wrapper
    var menu_bar = $( '.menu-bar' );
    var btn_menu = $( '<div>' ).addClass( 'mto button-menu' ).text( '<?php _e( "Menu" ); ?>' );

    // Wait for doc ready
    $( function() {

      var content = $('#content, .header, .footer');
      // Show the menu on click
      btn_menu.click( function() {
        content.addClass( 'hide' );
        navigation.removeClass( 'hide' );
      } );
      // Add the buttons to the wrapper
      menu_bar.append( btn_menu );

      // Create a close button for the menu
      var btn_close = $( '<div>' ).addClass( 'button-close' ).text( '<?php _e( "Close" ); ?>' );
      btn_close.click( function() {
        content.removeClass( 'hide' );
        navigation.addClass( 'hide' );
      } );
      navigation.find( '.nav-menu-bar' ).prepend( $( '<li>' ).append( btn_close ) );

      // Hide sub-menus
      $( '.sub-menu', navigation ).each( function() {
        var item = $( this );
        item.addClass( 'hide' ).prev().one( 'click', function( e ) {
          if ( Modernizr.touch || !min_width( '64em' ) ) {
            e.preventDefault();
            $( this ).addClass( 'open' );
            item.removeClass( 'hide' );
          }
        } );
      } );
    } ); // - ready
  } ( jQuery ) );
</script>
