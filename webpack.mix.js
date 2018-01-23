let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.webpackConfig({
	resolve: {
		alias: {
			"markjs": "mark.js/dist/jquery.mark.js"
		}
	}
});

mix.js('resources/assets/js/bko.js', 'public/js')
	.sass('resources/assets/sass/bko.scss', 'public/css')
	.options({
		processCssUrls: false,
	});

mix.js('resources/assets/js/app.js', 'public/js')
	.sass('resources/assets/sass/app.scss', 'public/css')
	.options({
		processCssUrls: false,
	});

if (mix.inProduction()) {
	mix.version();
}

// mix.browserSync({
// 	proxy: 'http://dreal.local'
// });

mix.disableNotifications();