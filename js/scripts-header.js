(function($, w){
  // A helper function to measure heights
  // If you're using borders or outlines
  var map_height = function (index, element) {
    return $(this).outerHeight();
  };

  // Equalise heights
  var equalise = function(element, group_size) {
    // Reset element height
    element.height('');

    // Group results
    if (group_size === undefined) { group_size = 0; }

    if (group_size == 1) {
      return;
    }
    var groups = [];
    if (group_size) {
      // Not a clone, but a different object of with the same selection
      var clone = $(element);
      while (clone.length > 0) {
        groups.push($(clone.splice(0, group_size)));
      }
    }
    else {
      groups = [element];
    }

    // Measure the heights and then apply the highest measure to all
    var heights, height;
    for (var i in groups) {
      heights = groups[i].map(map_height).get();
      height = Math.max.apply(null, heights);
      groups[i].height(height);
    }
  };

  // Add jQuery plugin
  $.fn.equalise = function(size) {
    equalise(this, size);
    return this;
  };

  // Determine if an url is external:
  var is_external = function () {
    var url = this;
    return (url.hostname && url.hostname.replace(/^www\./, '') !== location.hostname.replace(/^www\./, ''));
  };
  // Expose:
  w.is_external = is_external;


  // Min width detection
  var min_width;
  if ( Modernizr.mq('(min-width: 0px)') ) {
    // Browsers that support media queries
    min_width = function ( width ) {
      return Modernizr.mq( '(min-width: ' + width + 'em)' );
    };
  }
  else {
    // Fallback for browsers that does not support media queries
    min_width = function ( width ) {
      return jQuery(window).width() >= width * 16;
    };
  }
  // Expose:
  w.min_width = min_width;
} (jQuery, window) );

/* Removing padding for product images, so they will go from edge to edge in mobile devices */
jQuery( function( $ ) {

  // Create a clone of the image
  var img = $( '.product .images img' );
  var clone = img.clone().addClass( 'mo' );

  // Position the clone over the image
  clone.css( {
    position: 'absolute',
    left: '-0.75em', right: '-0.75em',
    width: $('#main').outerWidth(),
    'max-width': 'none'
  } ).insertBefore( img );

} );
