/* File: gulpfile.js */

// grab our gulp packages
var gulp  = require('gulp'),
	util = require('gulp-util'),
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	rimraf = require('gulp-rimraf'),
	watch = require('gulp-watch'),
	php = require('gulp-connect-php'),
	browserSync = require('browser-sync').create();

var reload = browserSync.reload;

var paths = {
	app: 'app/**/*.js',
	dist: 'dist/'
};

gulp.task('php', function(){
	php.server({
		base: './',
		port: 8888,
		keepalive: true
	});
});

//delete all files in dist
gulp.task('rimraf', function(){
	return gulp.src('dist/*.js', {read: false})
		.pipe(rimraf());
});

gulp.task('watch', ['minify', 'browserSync'], function(){
	gulp.watch(['dist/app.js', 'api/**/*.php', paths.app], ['minify']).on('change', browserSync.reload);
});

//concatenate and minify
gulp.task('minify', ['rimraf'], function() {
	return gulp.src(paths.app)
		.pipe(uglify())
		.pipe(concat('app.min.js'))
		.pipe(gulp.dest(paths.dist))
});

//browserSync
gulp.task('browserSync', ['php'], function(){
	browserSync.init({
		proxy: 'localhost:8888'
	})
});