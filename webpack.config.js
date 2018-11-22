//
//  Webpack configuration.
//
//  @requires composer-package:symfony/flex
//  @requires composer-recipe:encore
//
//  @requires module:babel-preset-env
//  @requires module:babel-preset-es2015
//
var Encore = require('@symfony/webpack-encore');

Encore
// directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */

    // .addEntry('js/app', './assets/js/app.js') // значения которые можно было использовать по умолчанию
    .addEntry('js/app', [
            './node_modules/jquery/dist/jquery.slim.min.js',
            './node_modules/popper.js/dist/popper.min.js',
            './node_modules/bootstrap/dist/js/bootstrap.min.js',
            './node_modules/holderjs/holder.min.js',
            './assets/js/app.js',
        ]
    )
    .addStyleEntry('css/app', [
            './node_modules/bootstrap/dist/css/bootstrap.min.css',
            './assets/css/app.css',
        ]
    )
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')
    // .addStyleEntry('css/app', './assets/css/app.scss') // значения которые можно было использовать по умолчанию

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

// enables Sass/SCSS support
//.enableSassLoader()

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()

// .configureBabel((config) => {
//     config.plugins.push(
//         // Enable using dynamic imports, using modular per-import chunks
//         ['syntax-dynamic-import'],
//     );
// })

// Presets
// .configureBabel((config) => {
//     config.presets.push(
//         // Enable transpiling down to browser compatibility
//         ['preset-env', { targets: { browsers: ['last 2 versions', 'safari >= 7'] } }],
//         // // Enable transpiling ES2015 to ES5 for uglifying non-ignored modules
//         // ['es2015'],
//     );
// })

// .configureBabel(function(babelConfig) {
//     // add additional presets
//     // babelConfig.presets.push('@babel/preset-flow');
//
//     babelConfig.presets.push('@babel/preset-env');
//
//     // no plugins are added by default, but you can add some
//     // babelConfig.plugins.push('styled-jsx/babel');
// }, {
//     // node_modules is not processed through Babel by default
//     // but you can whitelist specific modules to process
//     // include_node_modules: ['foundation-sites']
//
//     // or completely control the exclude
//     // exclude: /bower_components/
// })
;

// export the final configuration
let config = Encore.getWebpackConfig();
// config.resolve.alias = {
//     'local': path.resolve(__dirname, './resources/src')
// };
module.exports = config;

// module.exports = Encore.getWebpackConfig();
