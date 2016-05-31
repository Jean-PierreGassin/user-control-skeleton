var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var concat = require('gulp-concat');

var sassPaths = [
	'bower_components/foundation-sites/scss'
];

var jsPaths = [
	'bower_components/jquery/dist/jquery.min.js',
	'bower_components/foundation-sites/dist/foundation.min.js',
	'js/*.js'
];

gulp.task('sass', function() {
  return gulp.src('scss/*.scss').pipe(
	  $.sass({
      	includePaths: sassPaths
    	})
		.on('error', $.sass.logError))
    	.pipe($.autoprefixer({
      		browsers: ['last 2 versions', 'ie >= 9']
    	})
	)
	.pipe(concat('app.css'))
    .pipe(gulp.dest('app/public/assets/css'));
});

gulp.task('scripts', function() {
	return gulp.src(jsPaths)
		.pipe(concat('app.js'))
		.pipe(gulp.dest('app/public/assets/js'));
});

gulp.task('default', ['sass', 'scripts'], function() {
	gulp.watch(['scss/**/*.scss', 'js/*.js'], ['sass','scripts']);
});
