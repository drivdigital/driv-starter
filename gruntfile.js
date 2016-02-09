module.exports = function(grunt) {

  grunt.registerTask('watch', [ 'watch' ]);

  grunt.initConfig({

    // Read package
    pkg: grunt.file.readJSON('package.json'),

    /**
     * Project banner, currently unused.
     */
    tag: {
      banner: '/*!\n' +
              ' * <%= pkg.name %>\n' +
              ' * <%= pkg.title %>\n' +
              ' * <%= pkg.url %>\n' +
              ' * @version <%= pkg.version %>\n' +
              ' */\n'
    },

    /**
     * Compiling stylesheets
     */

    // Import whole folder into a file
    sass_globbing: {
      target: {
        files: {
          'assets/scss/partials/_components.scss': 'assets/scss/components/*.scss',
          'assets/scss/partials/_mixins.scss': 'assets/scss/partials/mixins/*.scss',
        }
      }
    },

    // Compile SCSS
		sass: {
			dist: {
        options: {
          style: 'compressed',
        },
				files: {
					'assets/css/style.css' : 'assets/scss/style.scss',
					'assets/css/ie.css' : 'assets/scss/ie.scss',
					'assets/css/login.css' : 'assets/scss/login.scss'
				}
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
        src: 'assets/css/*.css'
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
          'assets/js/scripts-header.min.js': ['assets/js/scripts-header.js'],
          'assets/js/scripts-footer.min.js': ['assets/js/scripts-footer.js']
        }
      }
    },

    // Minify Images
    imagemin: {
      dynamic: {
        files: [{
          expand: true,
          cwd: 'assets/images',
          src: ['**/*.{png,jpg,gif,svg}'],
          dest: 'assets/images'
        }]
      }
    },

    // Combine MQ's, but lose critical css
    combine_mq: {
      target: {
        files: {
          'assets/css/style.css': ['assets/css/style.css']
        },
        options: {
          beautify: false
        }
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
            "assets/css/*.css",
            "*.php,",
            "**/*.php,"
          ]
        },
        options: {
          watchTask: true,
          proxy: "drivstarter.dev" // If your site runs through MAMP, whats the URL
        }
      }
    },

    // Watch for any changes
    watch: {
      js: {
        files: ['assets/js/*.js'],
        tasks: ['uglify:js']
      },
      css: {
        // Watch sass changes, merge mqs & run bs
        files: ['assets/scss/*.scss', 'assets/scss/**/*.scss'],
        tasks: ['sass_globbing:target', 'sass', 'postcss:dist', 'browserSync' ]
      },
      options: {
          spawn: false // Very important, don't miss this
      }
    }
  });

  grunt.registerTask('BrowserSync Reminder', function() {
    grunt.log.writeln(
      'Remember to change your BrowserSync Proxy if \n' +
      'you are running this project for the first time. \n' +
      'Otherwise, you will find that things refuse to work'
    );
  });


  // Register everything used
  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

  // Standard grunt task – compile css and watch
  grunt.registerTask('default', [
    'sass_globbing:target', // Glob together needed folders
    'sass', // Run sass
    'postcss:dist', // Post Process with Auto-Prefix
    'browserSync', // live reload
    'BrowserSync Reminder',
    'watch' // Keep watching for any changes
  ]);

  // Minify everything from css to js
  grunt.registerTask('slim', [
    'uglify',
    'sass_globbing:target', // Glob together needed folders
    'sass', // Run sass
    'combine_mq', // Combine MQ's
    'postcss:dist', // Post Process with Auto-Prefix
  ]);
};
