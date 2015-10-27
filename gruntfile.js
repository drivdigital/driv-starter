module.exports = function(grunt) {

  grunt.registerTask('watch', [ 'watch' ]);

  grunt.initConfig({

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

    // Import whole folder into a file 
    sass_globbing: {
      target: {
        files: {
          'assets/scss/partials/_mixins.scss': 'assets/scss/partials/mixins/*.scss',
          'assets/scss/partials/_components.scss': 'assets/scss/components/*.scss'
        }
      }
    },
    
    // Compile SCSS
		sass: {
      stage: {     
        options: { 
          style: 'nested', 
          //loadPath: require('node-bourbon').includePaths
        },   
        files: {
          'assets/css/style.css' : 'assets/scss/style.scss',
          'assets/css/woocommerce.css' : 'assets/scss/woocommerce.scss',
          'assets/css/login.css' : 'assets/scss/login.scss'
        }
      },

			dist: {     
        options: { 
          style: 'compressed', 
          //loadPath: require('node-bourbon').includePaths
        },   
				files: {
          'assets/css/style.css' : 'assets/scss/style.scss',
          'assets/css/woocommerce.css' : 'assets/scss/woocommerce.scss',
          'assets/css/login.css' : 'assets/scss/login.scss'
				}
			}
		},
    
    // Combine MQ's, but lose critical css
    combine_mq: {
      target: {
        files: {
          'assets/css/woocommerce.css': ['assets/css/woocommerce.css'],
          'assets/css/style.css': ['assets/css/style.css']
        },
        options: {
          beautify: false
        }
      }
    },

    // Autoprefix
    postcss: {
        options: {
            map: false,
            processors: [
                require('autoprefixer-core')({
                    browsers: ['> 20%', 'last 10 versions', 'Firefox > 20']
                })
            ],
            remove: false
        },
        dist: {
            src: 'assets/css/*.css'
        }
    },

                /*
                * Fallback for Internet Explorer 
                */

                pixrem: {
                  options: {
                    rootvalue: '100%',
                    replace: true
                  },
                  dist: {
                    src: 'assets/css/style.css',
                    dest: 'assets/css/ie.css'
                  }
                },

                stripmq: {
                  options: {
                    width: 1400,
                    type: 'screen'
                  },
                  all: {
                    files: {
                      'assets/css/ie.css': ['assets/css/ie.css']
                    }
                  }
                },


                /*
                * End of Fallback for Internet Explorer 
                */

    // Watch for any changes
    watch: {
      js: {
        files: ['assets/js/*.js'],
        tasks: ['uglify:js']
      },
      css: {
        // Watch sass changes, then process new images and merge mqs
        files: [
        'assets/scss/*.scss', 
        'assets/scss/**/*.scss',
        'assets/scss/**/**/*.scss'],
        tasks: [
          'sass_globbing:target', 
          'sass:stage', 
          'postcss:dist', 
          'pixrem',
          'stripmq',
          'browserSync'
        ]
      },
      options: {
        spawn: false // Very important, don't miss this
      }
    },

    browserSync: {
      default_options: {
        bsFiles: {
          src: [
            "assets/css/*.css",
            "*.html,",
            "**/*.html,",
            "*.php,",
            "**/*.php,"
          ]
        },
        options: {
          watchTask: true,
        }
      }
    }
  });
 
  // Register everything used
  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

  // Run everything with 'grunt', these need to be in
  // a specific order so they don't fail.
  grunt.registerTask('default', [
    'sass_globbing:target', // Glob together needed folders
    'sass:stage', // Run sass
    'postcss:dist', // Post Process with Auto-Prefix
    'browserSync', // live reload
    'newer:imagemin:dynamic', // Compress all images
    'pixrem', // Fallback for IE and Android
    'stripmq',
    'watch' // Keep watching for any changes
  ]);

  // When we go live, run `grunt live` instead
  grunt.registerTask('live', [
    'uglify', 
    'sass_globbing:target', // Glob together needed folders
    'sass:dist', // Run sass
    'postcss:dist', // Post Process with Auto-Prefix
    'combine_mq', // Combine MQ's
    'newer:imagemin:dynamic', // Compress all images
    'pixrem', // Fallback for IE and Android
    'stripmq' // Take it all away.
  ]);
};
