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
          'assets/js/scripts.js': ['assets/js/scripts.js']
        }
      }
    },

    // Minify Images
    imagemin: {
      dynamic: {
        files: [{
          expand: true,
          cwd: 'assets/img',
          src: ['**/*.{png,jpg,gif,svg}'],
          dest: 'assets/img'
        }]
      }
    },
    
    // Compile SCSS
		sass: {
			dist: {     
        options: { 
          style: 'compressed',
          loadPath: require('node-bourbon').includePaths
        },   
				files: {
					'assets/css/style.css' : 'assets/scss/style.scss',
					'assets/css/ie.css' : 'assets/scss/ie.scss',
					'assets/css/login.css' : 'assets/scss/login.scss'
				}
			}
		},
    
    // Combine MQ's, but lose critical css
    combine_mq: {
      target: {
        files: {
          'assets/css/ie.css': ['assets/css/ie.css'],
          'assets/css/style.css': ['assets/css/style.css'],
          'assets/css/login.css': ['assets/css/login.css']
        },
        options: {
          beautify: false
        }
      }
    },

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
          proxy: "project.local" // If your site runs through MAMP, whats the URL
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
            src: 'css/*.css'
        }
    },
    
    // Import whole folder into a file 
    sass_globbing: {
      target: {
        files: {
          'assets/scss/components.scss': 'assets/scss/components/*.scss'
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
        // Watch sass changes, then process new images and merge mqs
        files: ['assets/scss/*.scss', 'assets/scss/**/*.scss'],
        tasks: ['sass_globbing:target', 'sass', 'combine_mq:target', 'postcss:dist', 'browserSync' ]
      },
      options: {
          spawn: false // Very important, don't miss this
      }
    }
  });
 
  // Register everything used
  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

  // Run everything with 'grunt', these need to be in
  // a specific order so they don't fail.
  grunt.registerTask('default', [
    'uglify', 
    'sass_globbing:target', // Glob together needed folders
    'sass', // Run sass
    'combine_mq', // Combine MQ's
    'postcss:dist', // Post Process with Auto-Prefix
    'newer:imagemin:dynamic', // Compress all images
    'browserSync', // live reload
    'watch' // Keep watching for any changes
  ]);

};
