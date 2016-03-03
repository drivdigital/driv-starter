module.exports = function(grunt) {

  require('jit-grunt')(grunt);

  grunt.initConfig({

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
          proxy: "drivstarter.dev:8080" // If your site runs through MAMP, whats the URL
        }
      }
    },

    // Watch for any changes
    watch: {
      js: {
        files: ['assets/js/*.js'],
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

  // Standard grunt task – compile css and watch
  grunt.registerTask('default', [
    'sass_globbing:target', // Glob together needed folders
    'sass', // Run sass
    'postcss:dist', // Post Process with Auto-Prefix
    'uglify', // minify javascript
    'browserSync', // live reload
    'watch' // Keep watching for any changes
  ]);

  // Minify everything from css to js
  grunt.registerTask('slim', [
    'uglify', // minify javascript
    'sass_globbing:target', // Glob together needed folders
    'sass', // Run sass
    'postcss:dist', // Post Process with Auto-Prefix
  ]);
};
