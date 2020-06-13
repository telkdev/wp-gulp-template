'use strict';

var gulp = require('gulp');
var uglify = require('gulp-uglify');
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var postcss = require('gulp-postcss');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('autoprefixer');
var cssnano = require('gulp-cssnano');
var browserSync = require('browser-sync').create();
var pump = require('pump');

var paths = {
    css: ['assets/css/*.css'],
    js: ['assets/js/*.js'],
    jsWatch: [
        // 'assets/libs/jquery.validate.min.js',
        // 'assets/libs/additional-methods.min.js',
        // 'assets/libs/jquery.cookie.js',
        // 'assets/libs/rangeslider.min.js',
        // 'assets/libs/select2.min.js',
        // 'assets/libs/akismet-form.js',
        // 'assets/libs/widget-api.js',
        'assets/js/scripts/**/*.js',
        'assets/js/scripts/**/*.min.js'
    ],
    scss: ['assets/scss/**/*.scss'],
    images: ['assets/img/**/*.png', 'assets/img/**/*.jpg']
};

gulp.task('scss', function () {
    return gulp.src(paths.scss)
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css'))
        .pipe(browserSync.stream());
});

gulp.task('css:minify', function () {
    return gulp.src(paths.css)
        .pipe(cssnano())
        .pipe(postcss([autoprefixer({browsers: ['ie >= 8', 'last 4 versions']})]))
        .pipe(gulp.dest('assets/css'));
});

gulp.task('amp-css:minify', function () {
    return gulp.src('amp/main-amp.css')
        .pipe(cssnano())
        // .pipe(postcss([autoprefixer({browsers: ['ie >= 8', 'last 4 versions']})]))
        .pipe(gulp.dest('amp/css'));
});

gulp.task('amp-css:minifyVendor', function () {
    return gulp.src('vendorAmp/*.css')
        .pipe(cssnano())
        // .pipe(postcss([autoprefixer({browsers: ['ie >= 8', 'last 4 versions']})]))
        .pipe(gulp.dest('vendorAmp/css'));
});

gulp.task('js', function () {
    return gulp.src(paths.jsWatch)
        .pipe(plumber())
        .pipe(concat('main.js'))
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(gulp.dest('assets/js'))
        .pipe(browserSync.stream());
});

gulp.task('js:minify', function () {
    return gulp.src(paths.js)
        .pipe(uglify())
        .pipe(gulp.dest('assets/js'));
});

gulp.task('compress', function (cb) {
    pump([
            gulp.src(paths.js),
            uglify(),
            gulp.dest('assets/js')
        ],
        cb
    );
});

gulp.task('watch', function () {
    gulp.watch(paths.scss, gulp.series('scss'));
    gulp.watch(paths.jsWatch, gulp.series('js'));
});