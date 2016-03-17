module.exports = function(grunt) {

  var PathConfig = require('./grunt-settings.js');
  require('jit-grunt')(grunt);

  grunt.initConfig({

    config: PathConfig,

    /**
     * Prompts and questions - https://github.com/dylang/grunt-prompt
     * We need to ask a few things from you first,
     * then the project can get underway!
     */
    prompt: {
      browserSync: {
        options: {
          questions: [
            {
              config:  'browserSync.default_options.options.proxy',     // arbitrary name or config for any other grunt task
              type:    'input',                                         // list, checkbox, confirm, input, password
              message: 'Enter the Vagrant URL', // Question to ask the user, function needs to return a string,
              default: 'drivdigital.dev:8080',                    // default value if nothing is entered
            }
          ]
        }
      },
    },


    /**
     * Compiling stylesheets
     */

    // Import whole folder into a file
    sass_globbing: {
      target: {
        files: {
          '<%= config.scssPartials %>_components.scss': '<%= config.scssDir %>components/*.scss',
          '<%= config.scssPartials %>_mixins.scss': '<%= config.scssPartials %>mixins/*.scss',
        }
      }
    },

    //sass
    sass: {
      dev: {
        options: {
          style: 'nested'
        },
        files: [
          {
            src: '<%= config.scssDir %><%= config.scssMainFileName %>.scss',
            dest: '<%= config.cssDir %><%= config.cssMainFileName %>.css'
          }
        ]
      },
      dist: {
        options: {
          style: 'nested'
        },
        files: [
          {
            expand: true,
            cwd: '<%= config.scssDir %>',
            src: ['**/*.scss', '!<%= config.scssMainFileName %>.scss'],
            dest: '<%= config.cssDir %>',
            ext: '.css'
          },
          {
            src: '<%= config.scssDir %><%= config.scssMainFileName %>.scss',
            dest: '<%= config.cssDir %><%= config.cssMainFileName %>.css'
          }
        ]
      },
      min: {
        options: {
          Style: 'compressed'
        },
        files: [
          {
            expand: true,
            cwd: '<%= config.scssDir %>',
            src: ['**/*.scss', '!<%= config.scssMainFileName %>.scss'],
            dest: '<%= config.cssDir %>',
            ext: '.min.css'
          },
          {
            src: '<%= config.scssDir %><%= config.scssMainFileName %>.scss',
            dest: '<%= config.cssDir %><%= config.cssMainFileName %>.min.css'
          }
        ]
      }
    },

    // Autoprefix
    postcss: {
      options: {
        map: false,
        processors: [
        require('autoprefixer')({
          browsers: ['> 20%', 'last 10 versions', 'Firefox > 20']
        })
        ],
        remove: false
      },
      dist: {
        src: '<%= config.cssDir %>*.css'
      }
    },

    /**
     * Minifications
     */

    // Make JS tiny
    uglify: {
      options: {
        mangle: false
      },
      js: {
        files: {
          '<%= config.jsDir %>scripts-header.min.js': ['<%= config.jsDir %>scripts-header.js'],
          '<%= config.jsDir %>scripts-footer.min.js': ['<%= config.jsDir %>scripts-footer.js']
        }
      }
    },

    // Minify Images
    imagemin: {
      dynamic: {
        files: [{
          expand: true,
          cwd: '<%= config.imgDir %>',
          src: ['**/*.{png,jpg,gif,svg}'],
          dest: '<%= config.imgDir %>'
        }]
      }
    },

    /**
     * Live reloading
     */
    // See your changes in the browser as they happen.
    browserSync: {
      default_options: {
        bsFiles: {
          src: [
          "<%= config.cssDir %>*.css",
          "*.php,",
          "**/*.php,"
          ]
        },
        options: {
          watchTask: true,
          proxy: "<%= config.proxy %>" // If your site runs through MAMP, whats the URL
        }
      }
    },

    // Watch for any changes
    watch: {
      js: {
        files: ['<%= config.jsDir %>*.js'],
      },
      css: {
        // Watch sass changes, merge mqs & run bs
        files: ['<%= config.scssDir %>*.scss', '<%= config.scssDir %>**/*.scss'],
        tasks: ['sass_globbing:target', 'sass:dist', 'postcss:dist' ]
      },
      dev: {
        // Watch sass changes, merge mqs & run bs
        files: ['<%= config.scssDir %>*.scss', '<%= config.scssDir %>**/*.scss'],
        tasks: ['sass_globbing:target', 'sass:dev', 'postcss:dist', 'browserSync' ]
      },
      options: {
        spawn: false // Very important, don't miss this
      }
    }
  });

  // Standard grunt task – compile css and watch
  grunt.registerTask('default', [
    'sass_globbing:target', // Glob together needed folders
    'sass:dist', // Run sass
    'postcss:dist', // Post Process with Auto-Prefix
    'uglify', // minify javascript
    'watch:css' // Keep watching for any changes
  ]);

  // Standard grunt task – compile css and watch
  grunt.registerTask('dev', [
    'prompt:browserSync', // Config
    'sass_globbing:target', // Glob together needed folders
    'sass:dev', // Run sass
    'postcss:dist', // Post Process with Auto-Prefix
    'uglify', // minify javascript
    'browserSync',
    'watch:dev' // Keep watching for any changes
  ]);

  // Minify everything from css to js
  grunt.registerTask('slim', [
    'uglify', // minify javascript
    'sass_globbing:target', // Glob together needed folders
    'sass:min', // Run sass
    'postcss:dist', // Post Process with Auto-Prefix
    ]);
};