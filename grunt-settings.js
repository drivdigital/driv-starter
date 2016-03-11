module.exports = {
  proxy:            'drivdigital.dev:8080',

  scssPartials:     'assets/scss/partials/',
  sassDir:          'assets/scss/',
  sassMainFileName: 'style',

  cssDir:           'assets/css/',
  cssMainFileName:  'style',

  jsDir:            'assets/js/',

  imgDir:           'assets/images/'
};

/*

These variables are pulled into the
gruntfile, allowing you to modify a
whole project's grunt task variables
from this file. What a mouth full!

<%= config.proxy %>
<%= config.scssPartials %>
<%= config.scssDir %>
<%= config.sassMainFileName %>
<%= config.cssDir %>
<%= config.cssMainFileName %>
<%= config.jsDir %>
<%= config.imgDir %>

*/