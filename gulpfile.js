const gulp = require('gulp');
const autoprefixer = require('gulp-autoprefixer');
const concat = require('gulp-concat');
const sass = require('gulp-sass');

const sassPaths = [
	'bower_components/foundation-sites/scss'
];

const jsPaths = [
	'bower_components/jquery/dist/jquery.min.js',
	'bower_components/foundation-sites/dist/foundation.min.js',
	'js/*.js'
];

gulp.task('sass', function() {
  return gulp.src('scss/*.scss').pipe(
	  sass({
    	includePaths: sassPaths
  	})
		.on('error', sass.logError))
  	.pipe(autoprefixer({
  		browsers: ['last 2 versions', 'ie >= 9']
  	}))
		.pipe(concat('app.css'))
		.pipe(gulp.dest('public/assets/css'));
});

gulp.task('scripts', function() {
	return gulp.src(jsPaths)
		.pipe(concat('app.js'))
		.pipe(gulp.dest('public/assets/js'));
});

gulp.task('watch', function() {
	gulp.watch(['scss/**/*.scss', 'js/*.js'], ['sass','scripts']);
});

gulp.task('default', ['sass', 'scripts']);
