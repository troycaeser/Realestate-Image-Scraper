/* File: gulpfile.js */

// grab our gulp packages
var gulp  = require('app/gulp'),
    gutil = require('app/gulp-util');

// create a default task and just log a message
gulp.task('default', function() {
	return gutil.log('Gulp is running!')
});