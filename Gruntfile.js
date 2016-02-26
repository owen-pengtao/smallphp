// Generated on 2015-03-15 using
// generator-webapp 0.5.1
'use strict';

// # Globbing
// for performance reasons we're only matching one level down:
// 'test/spec/{,*/}*.js'
// If you want to recursively match all subfolders, use:
// 'test/spec/**/*.js'

module.exports = function (grunt) {

  // Load grunt tasks automatically
  require('load-grunt-tasks')(grunt);

  // Configurable paths
  var config = {
    app: 'app'
  };

  // Define the configuration for all the tasks
  grunt.initConfig({

    // Project settings
    config: config,

    // Watches files for changes and runs tasks based on the changed files
    watch: {
      html: {
        options: {
          livereload: true
        },
        files: ['<%= config.app %>/**/*.js', '<%= config.app %>/**/*.html', '**/*.php']
      },
      less: {
        tasks: ['less:development'],
        options: {
          livereload: true
        },
        files: ['<%= config.app %>/styles/*.less']
      }
    },
    less: {
      development: {
        options: {
          sourceMap: false
        },
        files: [
          {
            expand: true,
            cwd: '<%= config.app %>',
            src: '**/styles/*.less',
            dest: '<%= config.app %>/',
            rename: function (dest, src) {
              return dest + src.replace('.less', '.css');
            }
          }
        ]
      }
    }
  });

  grunt.registerTask('default', ['watch']);
};
