var gulp = require('gulp');

// public/packages配下に展開したいnpmのパッケージ名
var modules = ['bootstrap-switch'];

// modulesで指定されたnpmライブラリをpublic/packages配下に展開する
gulp.task('export', function() {
  modules.map(function(name, index) {
    gulp.src('node_modules/' + name + '/**/*')
      .pipe(gulp.dest('public/packages/' + name));
  });
});

gulp.task('default', ['export']);
