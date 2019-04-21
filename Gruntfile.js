module.exports = function(grunt) {
  require('jit-grunt')(grunt);

  grunt.initConfig({

    uglify: {

      options: {
        manage: false
      },
      my_target: {
        files: {
          'app/scripts/main.js' : ['_frontdev/js/*.js']
        }
      }
    },

    less: {
      development: {
        options: {
          compress: false,
          yuicompress: true,
          optimization: 2
        },
        files: {
          'app/styles/main.css': ['_frontdev/less/*.less']
        }
      }
    },
    wiredep: {

  task: {

    // Point to the files that should be updated when
    // you run `grunt wiredep`
    src: [
      'index.php',   // .html support...

    ],

    options: {
      // See wiredep's configuration documentation for the options
      // you may pass:

      // https://github.com/taptapship/wiredep#configuration
    }
  }
},
    watch: {
      styles: {
        files: ['_frontdev/**/*.less'], // which files to watch
        tasks: ['less'],
        options: {
          nospawn: true
        }
      },
      js: {
        files: ['_frontdev/**/*.js'],
        tasks: ['uglify']

      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.registerTask('default', ['less', 'watch']);
  grunt.registerTask('default', ['uglify', 'watch']);
  grunt.loadNpmTasks('grunt-wiredep');
};
