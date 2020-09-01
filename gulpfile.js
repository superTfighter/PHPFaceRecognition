var gulp = require('gulp'),
    less = require('gulp-less'),
    watch = require('gulp-watch'),
    csso = require('gulp-csso'),
    exec = require('gulp-exec'),
    util = require('gulp-util'),
    plumber = require('gulp-plumber');
    install = require('gulp-install');

var onError = function(err) {
    console.log(err);
}

gulp.task('build', function(){

    gulp.src('bower_components/bootstrap/dist/css/bootstrap.min.css').pipe(gulp.dest('public/skeleton-assets/bootstrap/css'));
    gulp.src('bower_components/bootstrap/dist/js/bootstrap.min.js').pipe(gulp.dest('public/skeleton-assets/bootstrap/js'));

});

gulp.task('build-full', function(){

    gulp.src('bower_components/jquery/dist/jquery.min.js').pipe(gulp.dest('public/skeleton-assets'));
    
    gulp.src('bower_components/jquery-ui/themes/base/jquery-ui.min.css').pipe(gulp.dest('public/skeleton-assets/jquery-ui/css'));
    gulp.src('bower_components/jquery-ui/jquery-ui.min.js').pipe(gulp.dest('public/skeleton-assets/jquery-ui/js'));


    gulp.src('bower_components/jquery.cookie/jquery.cookie.js').pipe(gulp.dest('public/skeleton-assets'));

    gulp.src('bower_components/font-awesome/css/font-awesome.min.css').pipe(gulp.dest('public/skeleton-assets/font-awesome/css'));
    gulp.src('bower_components/font-awesome/fonts/*').pipe(gulp.dest('public/skeleton-assets/font-awesome/fonts'));

    gulp.src('bower_components/bootstrap/dist/css/bootstrap.min.css').pipe(gulp.dest('public/skeleton-assets/bootstrap/css'));
    gulp.src('bower_components/bootstrap/dist/js/bootstrap.min.js').pipe(gulp.dest('public/skeleton-assets/bootstrap/js'));

    gulp.src('bower_components/admin-lte/dist/css/AdminLTE.min.css').pipe(gulp.dest('public/skeleton-assets/adminlte/css'));
    gulp.src('bower_components/admin-lte/dist/css/skins/*.min.css').pipe(gulp.dest('public/skeleton-assets/adminlte/css/skins'));
    gulp.src('bower_components/admin-lte/dist/js/adminlte.min.js').pipe(gulp.dest('public/skeleton-assets/adminlte/js'));

    gulp.src('bower_components/bootstrap-confirmation2/bootstrap-confirmation.min.js').pipe(gulp.dest('public/skeleton-assets/bootstrap-confirmation/js'));

    gulp.src('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css').pipe(gulp.dest('public/skeleton-assets/dataTables/css'));
    gulp.src('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js').pipe(gulp.dest('public/skeleton-assets/dataTables/js'));
    gulp.src('bower_components/datatables.net/js/jquery.dataTables.min.js').pipe(gulp.dest('public/skeleton-assets/dataTables/js'));

    gulp.src('bower_components/PACE/pace.min.js').pipe(gulp.dest('public/skeleton-assets/pace/js'));

    gulp.src('bower_components/select2/dist/css/select2.min.css').pipe(gulp.dest('public/skeleton-assets/select2/css'));
    gulp.src('bower_components/select2/dist/js/select2.min.js').pipe(gulp.dest('public/skeleton-assets/select2/js'));

    gulp.src('bower_components/toastr/toastr.min.css').pipe(gulp.dest('public/skeleton-assets/toastr/css'));
    gulp.src('bower_components/toastr/toastr.min.js').pipe(gulp.dest('public/skeleton-assets/toastr/js'));

    gulp.src('app/Resources/fonts/**').pipe(gulp.dest('public/skeleton-assets'));

});

gulp.task('css', function(){
	gulp.src('app/Resources/less/*.less')
	    .pipe(plumber({
		errorHandler: onError
	    }))
	    .pipe(less())
	    .pipe(csso())
	    .pipe(gulp.dest('public/skeleton-assets/css'));

});

gulp.task('default', function() {
    return watch('app/Resources/less/*.less', 'css')
});