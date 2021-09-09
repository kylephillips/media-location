var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefix = require('gulp-autoprefixer');
var livereload = require('gulp-livereload');
var notify = require('gulp-notify');
var minifycss = require('gulp-minify-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var pump = require('pump');

// Style Paths
var scss_admin = 'assets/scss/admin/*';
var scss_public = 'assets/scss/public/*';
var css = 'assets/css/';

// JS Paths
var js_source_admin = [
	'assets/js/src/admin/media-location.admin.map-form.js',
	'assets/js/src/admin/media-location.admin.factory.js'
];
var js_source_public = [
	
];
var js_compiled = 'assets/js/';

/**
* Process the styles
*/
var styles_admin = function(){
	return gulp.src(scss_admin)
		.pipe(sass({sourceComments: 'map', sourceMap: 'sass', style: 'compact'}))
		.pipe(autoprefix('last 5 version'))
		.pipe(minifycss({keepBreaks: false}))
		.pipe(gulp.dest(css))
		.pipe(livereload())
		.pipe(notify('Media Location Admin styles compiled & compressed.'));
}

/**
* Concatenate and minify scripts
*/
var js_admin = function(){
	return gulp.src(js_source_admin)
		.pipe(concat('admin-scripts.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest(js_compiled));
};

/**
* Watch Task
*/
gulp.task('watch', function(){
	livereload.listen();
	gulp.watch(scss_admin, gulp.series(styles_admin));
	gulp.watch(js_source_admin, gulp.series(js_admin));
});

/**
* Default
*/
gulp.task('default', gulp.series(styles_admin, js_admin, 'watch'));