module.exports = function (grunt) {
    grunt.initConfig({
        concat: { // https://github.com/gruntjs/grunt-contrib-concat
            options: {
                separator: ';',
            },
            dist: {
                src: [
                    //'public/templates/admin-lte/plugins/ckeditor/ckeditor.js',
                    'public/templates/admin-lte/plugins/jQuery/jquery-2.2.3.min.js',
                    'public/templates/admin-lte/bootstrap/js/bootstrap.min.js',
                    'public/templates/admin-lte/plugins/datepicker/bootstrap-datepicker.js',
                    'public/templates/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js',
                    'public/templates/admin-lte/plugins/fastclick/fastclick.js',
                    'public/templates/admin-lte/plugins/iCheck/icheck.min.js',
                    'public/templates/admin-lte/js/app.min.js',
                    'public/templates/admin-lte/js/demo.js',
                    'public/templates/admin-lte/plugins/validator/validation.js',
                    'public/templates/admin-lte/plugins/uploadfile/jquery.uploadfile.js',
                    'public/templates/admin-lte/plugins/datatables/jquery.dataTables.min.js',
                    'public/templates/admin-lte/plugins/datatables/dataTables.bootstrap.min.js',
                    'public/templates/admin-lte/plugins/datatables/jquery.dataTables.fnSetFilteringDelay.js',
                    'public/templates/admin-lte/plugins/validation/js/languages/jquery.validationEngine-en.js',
                    'public/templates/admin-lte/plugins/validation/js/jquery.validationEngine.js',
                    'public/templates/admin-lte/plugins/select2-3.5.1/select2.js',
                    'public/templates/admin-lte/js/spyr.js',
                    'public/templates/admin-lte/js/spyr-validation.js',
                    'public/templates/admin-lte/js/vue.js',
                    'public/templates/admin-lte/js/axios.min.js',
                    'public/templates/admin-lte/js/custom.js'
                ],
                dest: 'public/templates/admin-lte/js/combined.js',
            },

        },
        // define source files and their destinations
        uglify: {
            files: {
                src: 'public/templates/admin-lte/js/combined.js',  // source files mask
                dest: 'public/templates/admin-lte/js/',    // destination folder
                expand: true,    // allow dynamic building
                flatten: true,   // remove all unnecessary nesting
                ext: '.min.js'   // replace .js to .min.js
            }
        },
        cssmin: {
            options: {
                shorthandCompacting: false,
                roundingPrecision: -1,
                processImport: false
            },
            target: {
                files: {
                    'public/templates/admin-lte/css/combined.css': [
                        //'public/templates/admin-lte/css/font-awesome.min.css',
                        //'public/templates/admin-lte/css/ionicons.min.css',
                        'public/templates/admin-lte/css/skins/_all-skins.min.css',
                        //'public/templates/admin-lte/bootstrap/css/bootstrap.min.css',
                        'public/templates/admin-lte/css/AdminLTE.css',
                        'public/templates/admin-lte/plugins/datatables/dataTables.bootstrap.css',
                        'public/templates/admin-lte/plugins/validation/css/validationEngine.jquery.css',
                        'public/templates/admin-lte/plugins/select2-3.5.1/select2.css',
                        'public/templates/admin-lte/plugins/uploadfile/uploadfile.css',
                        'public/templates/admin-lte/css/custom.css'
                    ]
                }
            }
        },
        watch: {
            js: {
                files: [
                    'public/templates/admin-lte/css/custom.css',
                    'public/templates/admin-lte/js/custom.js',
                    'public/templates/admin-lte/js/spyr*.js'
                ],
                //tasks: ['concat','uglify'],
                tasks: ['concat', 'cssmin']
            },
        }
    });
    // load plugins
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    // register at least this one task
    //grunt.registerTask('default', ['concat','uglify']);
    grunt.registerTask('default', ['concat', 'cssmin']);
};