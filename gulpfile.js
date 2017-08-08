var gulp = require('gulp'),
    gulpConcat = require('gulp-concat')

var conf = {
    fileName_jsAssets: 'vendor.js',
    fileName_cssAssets: 'vendor.css',
    tasks: [
        'assets'
    ],
    assets: {
        partner: {
            js: [
                'node_modules/vue/dist/vue.js',
                'node_modules/ladda/dist/spin.min.js',
                'node_modules/ladda/dist/ladda.min.js'
            ],
            css: [
                'node_modules/ladda/dist/ladda.min.css'
            ]
        }
    }
}

gulp.task('assets', function () {
    for (var section in conf.assets) if (conf.assets.hasOwnProperty(section))
        for (var group in conf.assets[section]) if (conf.assets[section].hasOwnProperty(group))
            gulp.src(conf.assets[section][group])
                .pipe(gulpConcat(conf['fileName_' + group + 'Assets']))
                .pipe(gulp.dest('www/' + section))
});

gulp.task('default', conf.tasks);