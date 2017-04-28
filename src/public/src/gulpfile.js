'use strict';

var gulp = require('gulp');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');
var ngAnnotate = require('gulp-ng-annotate');
var es = require('event-stream');
var ngConstant = require('gulp-ng-constant');
var argv = require('yargs').argv;
var jshint = require('gulp-jshint');
var enviroment = argv.env || 'dev';
var sass = require('gulp-sass');

gulp.task('config', function () {
  var config = gulp.src('config/' + enviroment + '.json')
    .pipe(ngConstant(
    {
        name: 'app.config',
        space: '\t',
        wrap: false
    }));  
  return config
    .pipe(concat('app-config.js'))
    .pipe(gulp.dest('.'))
    .on('error', function() { });
});

gulp.task('build-js', ['config'], function () {
  gulp.src(['app-config.js', 'app_modules/**/module.js', 'app_modules/**/*.js'])
    .pipe(sourcemaps.init())
      .pipe(concat('app.js'))
      .pipe(ngAnnotate())
      //.pipe(uglify())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('.'))
})

gulp.task('build-css', function() {
  return gulp.src('app_modules/**/*.scss')
    .pipe(sass({
        //outputStyle: 'compressed',
        includePaths: ['./app_modules/']
    }).on('error', sass.logError))
    .pipe(sourcemaps.init())
      .pipe(concat('app.css'))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('.'));
});

gulp.task('lint', function() {
  return gulp.src('./lib/*.js')
    .pipe(jshint())
    .pipe(jshint.reporter('default', { verbose: true }));
});

gulp.task('watch', ['lint','build-js','build-css'], function () {
  gulp.watch('app_modules/**/*.js', ['build-js'])
  gulp.watch('app_modules/**/*.scss', ['build-css']);
})
