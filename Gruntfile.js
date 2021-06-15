(function () {
	'use strict';
	module.exports = function (grunt) {


		// Project configuration.
		grunt.initConfig({
			pkg: grunt.file.readJSON('package.json'),
			uglify: {
				options: {
					banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
				},
				main: {
					src: ['assets/js/<%= pkg.name %>.js', 'node_modules/modaal/source/js/modaal.js'],
					dest: 'dist/js/<%= pkg.name %>.min.js'
				},
				isotope: {
					src: 'node_modules/isotope-layout/dist/isotope.pkgd.js',
					dest: 'dist/js/isotope.min.js'
				}
			},
			jshint: {
				options: {
					jshintrc: '.jshintrc'
				},
				all: [
					'Gruntfile.js',
					'assets/js/*.js',
					'!dist/*'
				]
			},
			'dart-sass': {
				target: {
					options: {
						outputStyle: 'compressed'
					},
					files: [
						{
							expand: true,
							cwd: 'assets/sass/',
							src: ['*.scss'],
							dest: 'dist/css',
							ext: '.min.css'
						},
						{
							expand: true,
							cwd: 'node_modules/modaal/source/css/',
							src: ['*.scss'],
							dest: 'dist/css',
							ext: '.min.css'
						}
					]
				}
			},
			watch: {
				options: {
					livereload: true
				},
				compass: {
					files: [
						'assets/sass/*.scss'
					],
					tasks: ['dart-sass']
				},
				js: {
					files: [
						'assets/js/*.js'
					],
					tasks: ['jshint', 'uglify']
				}
			},
			clean: {
				dist: [
					'dist/js/*',
					'dist/css/*'
				]
			}
		});

		// Load tasks
		grunt.loadNpmTasks('grunt-contrib-clean');
		grunt.loadNpmTasks('grunt-contrib-jshint');
		grunt.loadNpmTasks('grunt-contrib-uglify');
		grunt.loadNpmTasks('grunt-contrib-watch');
		grunt.loadNpmTasks('grunt-dart-sass');

		// Register tasks
		grunt.registerTask('default', [
			'clean',
			'dart-sass',
			'uglify'
		]);
		grunt.registerTask('dev', [
			'watch'
		]);

	};
}());

