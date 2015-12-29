var gulp = require('gulp');

// public/lib配下に展開したいnpmのパッケージ名
var modules = ['bootstrap-switch'];

gulp.task('export', function() {
  modules.map(function(name, index) {
    gulp.src('node_modules/' + name + '/**/*')
      .pipe(gulp.dest('public/packages/' + name));
  });
});

gulp.task('default', ['export']);
