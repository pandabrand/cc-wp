// ## Globals
var argv         = require('minimist')(process.argv.slice(2));
var autoprefixer = require('gulp-autoprefixer');
var browserSync  = require('browser-sync').create();
var changed      = require('gulp-changed');
var concat       = require('gulp-concat');
var flatten      = require('gulp-flatten');
var gulp         = require('gulp');
var gulpif       = require('gulp-if');
var imagemin     = require('gulp-imagemin');
var jshint       = require('gulp-jshint');
var lazypipe     = require('lazypipe');
var less         = require('gulp-less');
var merge        = require('merge-stream');
var cssNano      = require('gulp-cssnano');
var plumber      = require('gulp-plumber');
var rev          = require('gulp-rev');
var runSequence  = require('run-sequence');
var sass         = require('gulp-sass');
var sourcemaps   = require('gulp-sourcemaps');
var uglify       = require('gulp-uglify');
var spritesmith = require('gulp.spritesmith');
var notify = require('gulp-notify');
var debug = require('gulp-debug');
var buffer = require('vinyl-buffer');
var del = require( 'del' );
var combiner = require('stream-combiner2').obj;

// See https://github.com/austinpray/asset-builder
var manifest = require('asset-builder')('./assets/manifest.json');

// `path` - Paths to base asset directories. With trailing slashes.
// - `path.source` - Path to the source files. Default: `assets/`
// - `path.dist` - Path to the build directory. Default: `dist/`
var path = manifest.paths;

// `config` - Store arbitrary configuration values here.
var config = manifest.config || {};

// `globs` - These ultimately end up in their respective `gulp.src`.
// - `globs.js` - Array of asset-builder JS dependency objects. Example:
//   ```
//   {type: 'js', name: 'main.js', globs: []}
//   ```
// - `globs.css` - Array of asset-builder CSS dependency objects. Example:
//   ```
//   {type: 'css', name: 'main.css', globs: []}
//   ```
// - `globs.fonts` - Array of font path globs.
// - `globs.images` - Array of image path globs.
// - `globs.bower` - Array of all the main Bower files.
var globs = manifest.globs;

// `project` - paths to first-party assets.
// - `project.js` - Array of first-party JS assets.
// - `project.css` - Array of first-party CSS assets.
var project = manifest.getProjectGlobs();

// CLI options
var enabled = {
  // Enable static asset revisioning when `--production`
  rev: argv.production,
  // Disable source maps when `--production`
  maps: !argv.production,
  // Fail styles task on error when `--production`
  failStyleTask: argv.production,
  // Fail due to JSHint warnings only when `--production`
  failJSHint: argv.production,
  // Strip debug statments from javascript when `--production`
  stripJSDebug: argv.production
};

// Path to the compiled assets manifest in the dist directory
var revManifest = path.dist + 'assets.json';

// Error checking; produce an error rather than crashing.
var onError = function(err) {
  console.log(err.toString());
  this.emit('end');
};

// ## Reusable Pipelines
// See https://github.com/OverZealous/lazypipe

// ### CSS processing pipeline
// Example
// ```
// gulp.src(cssFiles)
//   .pipe(cssTasks('main.css')
//   .pipe(gulp.dest(path.dist + 'styles'))
// ```
 var cssTasks = function(filename) {
  return combiner(
      gulpif(enabled.maps, sourcemaps.init()),
      gulpif('*.less', less({
        plugins: [require('less-plugin-glob')]
      })),
      gulpif('*.scss', sass({
        outputStyle: 'nested', // libsass doesn't support expanded yet
        precision: 10,
        includePaths: ['.'],
        errLogToConsole: true
      })),
      concat(filename),
      autoprefixer(),
      gulpif(enabled.compression === true, cssNano({
        safe: true
      })),
      gulpif(enabled.rev, rev()),
      gulpif(enabled.maps, sourcemaps.write('.', {
          sourceRoot: 'assets/styles/'
      }))
    ).on('error', notify.onError());
  };

// ### JS processing pipeline
// Example
// ```
// gulp.src(jsFiles)
//   .pipe(jsTasks('main.js')
//   .pipe(gulp.dest(path.dist + 'scripts'))
// ```
function jsTasks(filename) {
  return combiner(
    gulpif(enabled.maps, sourcemaps.init()),
    concat(filename),
    gulpif(enabled.compression === true, uglify({
      output: {
        'ascii_only': true
      },
      compress: {
        'drop_debugger': enabled.stripJSDebug
      }
    })),
    gulpif(enabled.rev, rev()),
    gulpif(enabled.maps, sourcemaps.write('.', {
        sourceRoot: 'assets/scripts/'
      }))
    ).on('error', notify.onError());
}

// ### Write to rev manifest
// If there are any revved files then write them to the rev manifest.
// See https://github.com/sindresorhus/gulp-rev
var writeToManifest = function(directory) {
  return combiner(
    gulp.dest(path.dist + directory),
    browserSync.stream({
      match: '**/*.{js,css}'
    }),
    rev.manifest(revManifest, {
      base: path.dist,
      merge: true
    }),
    gulp.dest(path.dist)
  ).on('error', notify.onError());
};

// ## Gulp tasks
// Run `gulp -T` for a task summary

// ### Styles
// `gulp styles` - Compiles, combines, and optimizes Bower CSS and project CSS.
// By default this task will only log a warning if a precompiler error is
// raised. If the `--production` flag is set: this task will fail outright.

gulp.task('styles:compilation', function (cb) {
  var merged = merge();
  manifest.forEachDependency('css', function(dep) {
    merged.add(gulp.src(dep.globs, {base: 'styles'})
      .pipe(cssTasks(dep.name)));
  });

  cb();
  return merged
    .pipe(writeToManifest('styles'));
});

// ### Scripts
// `gulp scripts` - Runs JSHint then compiles, combines, and optimizes Bower JS
// and project JS.

gulp.task('scripts:compilation', function(cb) {
  var merged = merge();
  manifest.forEachDependency('js', function(dep) {
    merged.add(
      gulp.src(dep.globs, {base: 'scripts'})
        .pipe(jsTasks(dep.name))
    );
  });
  cb();
  return merged
    .pipe(writeToManifest('scripts'));
});

// ### Fonts
// `gulp fonts` - Grabs all the fonts and outputs them in a flattened directory
// structure. See: https://github.com/armed/gulp-flatten
gulp.task('fonts', function() {
  return gulp.src(globs.fonts)
    .pipe(flatten())
    .pipe(gulp.dest(path.dist + 'fonts'))
    .pipe(browserSync.stream());
});

// ### Images
// `gulp images` - Run lossless compression on all the images.
gulp.task('images', function() {
  return gulp.src(globs.images)
    .pipe(imagemin([
      imagemin.jpegtran({progressive: true}),
      // imagemin.gifsicle({interlaced: true}),
      imagemin.svgo({plugins: [{removeUnknownsAndDefaults: false}, {cleanupIDs: false}]})
    ]))
    .pipe(gulp.dest(path.dist + 'images'))
    .pipe(browserSync.stream());
});

// ### JSHint
// `gulp jshint` - Lints configuration JSON and project JS.
gulp.task('scripts:jshint', function(cb) {
  return gulp.src([
    'bower.json', 'gulpfile.js'
  ].concat(project.js))
    .pipe(jshint())
    .on('error', notify.onError())
    .pipe(jshint.reporter('jshint-stylish'))
    .pipe(gulpif(enabled.failJSHint, jshint.reporter('fail')));
});

gulp.task('scripts', gulp.series('scripts:jshint', 'scripts:compilation'));

gulp.task('sprite', function() {
  var spriteData = gulp.src(path.dist+'images/icon-sprites/*.png')    .pipe(spritesmith({
    retinaSrcFilter: path.dist+'images/icon-sprites/*@2x.png',
    imgPath: '../images/icon-sprites.png',
    imgName: 'icon-sprites.png',
    retinaImgPath: '../images/icon-sprites@2x.png',
    retinaImgName: 'icon-sprites@2x.png',
    cssName: '_icon-sprites.scss',
    padding: 10
  }));
  var imgStream = spriteData.img.pipe(buffer()).pipe(gulp.dest('./assets/images'));
  var cssStream = spriteData.css.pipe(gulp.dest('./assets/styles/common/icon_sprites'));
  return merge(imgStream, cssStream);
});

// ### Clean
// `gulp clean` - Deletes the build folder entirely.
function clean() {
  return del([path.dist]);
}

// ### Watch
// `gulp watch` - Use BrowserSync to proxy your dev server and synchronize code
// changes across devices. Specify the hostname of your dev server at
// `manifest.config.devUrl`. When a modification is made to an asset, run the
// build step for that asset and inject the changes into the page.
// See: http://www.browsersync.io
// function watch () {
//   browserSync.init({
//     files: ['{lib,templates}/**/*.php', '*.php'],
//     proxy: config.devUrl,
//     snippetOptions: {
//       whitelist: ['/wp-admin/admin-ajax.php'],
//       blacklist: ['/wp-admin/**']
//     }
//   });
//   gulp.watch([path.source + 'styles/**/*'], ['styles']);
//   gulp.watch([path.source + 'scripts/**/*'], ['jshint', 'scripts']);
//   gulp.watch([path.source + 'fonts/**/*'], ['fonts']);
//   gulp.watch([path.source + 'images/**/*'], ['images']);
//   gulp.watch(['bower.json', 'assets/manifest.json'], ['build']);
// }

// ### Build
// `gulp build` - Run all the build tasks but don't clean up beforehand.
// Generally you should be running `gulp` instead of `gulp build`.
// function build (callback) {
//   return runSequence('sprite',['fonts', 'images'],'styles', 'scripts', callback);
// }

// ### Wiredep
// `gulp wiredep` - Automatically inject Less and Sass Bower dependencies. See
// https://github.com/taptapship/wiredep
gulp.task('wiredep', function() {
  var wiredep = require('wiredep').stream;
  return gulp.src(project.css)
    .pipe(wiredep())
    .pipe(changed(path.source + 'styles', {
      hasChanged: changed.compareSha1Digest
    }))
    .pipe(gulp.dest(path.source + 'styles'));
});

// ### Gulp
// `gulp` - Run a complete build. To compile for production run `gulp --production`.

gulp.task('styles', gulp.series('wiredep', 'styles:compilation'));
gulp.task('build', gulp.series(clean, gulp.parallel('sprite', 'fonts', 'images', 'styles', 'scripts')));
gulp.task('default', gulp.series('build'));

gulp.task('watch:browser', function() {
  browserSync.init({
    files: ['{lib,templates}/**/*.php', '*.php'],
    proxy: config.devUrl,
    snippetOptions: {
      whitelist: ['/wp-admin/admin-ajax.php'],
      blacklist: ['/wp-admin/**']
    }
  });
});

gulp.task('watch:styles', function () {
  gulp.watch([path.source + 'styles/**/*'], gulp.series('styles'));
});

gulp.task('watch:scripts', function () {
  gulp.watch([path.source + 'scripts/**/*'], gulp.series('scripts'));
});

gulp.task('watch:fonts', function () {
  gulp.watch([path.source + 'fonts/**/*'], gulp.series('fonts'));
});

gulp.task('watch:images', function () {
  gulp.watch([path.source + 'images/**/*'], gulp.series('images'));
});

gulp.task('watch:build', function () {
  gulp.watch(['bower.json', manifestFilePath], gulp.series('build'));
});

gulp.task('watch',
  gulp.series(
      'default', 'watch:browser', gulp.parallel('watch:styles', 'watch:scripts', 'watch:fonts', 'watch:images', 'watch:build')
  )
);
