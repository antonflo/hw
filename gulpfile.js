var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    annotate = require('gulp-ng-annotate'),
    templateCache = require ('gulp-angular-templatecache')
;

var libs = [
    'web/vendor/angular-bootstrap/ui-bootstrap-tpls.js',
    'web/vendor/angular-bootstrap/ui-bootstrap.js',
    'web/vendor/angular-formly-templates-bootstrap/dist/angular-formly-templates-bootstrap.js',
    'web/vendor/angular-formly/dist/formly.js',
    'web/vendor/api-check/dist/api-check.js'
];

gulp.task('lib', function () {
    gulp.src(libs)
        .pipe(concat('lib.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('web/dist'))
});

gulp.task('partials', function () {
    return gulp.src('app/Resources/public/**/*.html')
        .pipe(templateCache('partials.js'), {module: 'app', root: ''})
        .pipe(gulp.dest('web/dist'));
});
gulp.task('js', ['partials'], function () {
    gulp.src(['app/Resources/public/**/*.js', 'web/dist/partials.js'])
        .pipe(annotate())
        .pipe(concat('app.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('web/dist'))
});
