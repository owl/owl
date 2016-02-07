var gulp   = require('gulp'),
    stylus = require('gulp-stylus');

// public/packages配下に展開したいnpmのパッケージ名
var modules = [
  'bootstrap-switch',
  'pnotify',
  'zeroclipboard',
  'bootstrap'
];

// modulesで指定されたnpmライブラリをpublic/packages配下に展開する
gulp.task('export', function() {
  modules.map(function(name, index) {
    gulp.src('node_modules/' + name + '/**/*')
      .pipe(gulp.dest('public/packages/' + name));
  });
});

// stylus task
gulp.task('stylus', function () {
  var stylusPath = {
    'src': 'resources/assets/stylus/**/!(_)*.styl',
    'dest': 'public/css'
  }
  return gulp.src(stylusPath.src)
    .pipe(stylus({
      compress: true
    }))
    .on('error', function (err) {
      console.error('Error', err.message);
    })
    .pipe(gulp.dest(stylusPath.dest));
});

gulp.task('default', ['stylus', 'export']);
