jQuery( function( $ ) {
  // Use highlight.js to hightlight code snippets
  var code_queue = [];
  $('pre').each( function() {
    var text = $( this ).text();
    if ( text.match( /[\{\[\;\[]|function/) ) {
      code_queue.push( this );
    }
  } );

  if ( code_queue.length ) {
    $( '<link/>', {
      rel: 'stylesheet',
      href: '//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.5/styles/solarized_light.min.css'
    } ).appendTo( 'head' );
    $.getScript( '//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.5/highlight.min.js', function() {
      $.each( code_queue, function( i, block ) {
        hljs.highlightBlock( hljs.fixMarkup( block ) );
      } );
    } );
  }
} );
