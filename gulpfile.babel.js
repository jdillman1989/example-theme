/**
 * Gulpfile.
 *
 * Gulp with WordPress.
 *
 * Implements:
 *      1. Live reloads browser with BrowserSync.
 *      2. CSS: Sass to CSS conversion, error catching, Autoprefixing, Sourcemaps,
 *         CSS minification, and Merge Media Queries.
 *      3. JS: Concatenates & uglifies JS files.
 *      4. Images: Minifies PNG, JPEG, GIF and SVG images.
 *      5. Watches files for changes in CSS or JS.
 *      6. Watches files for changes in PHP.
 *      7. Corrects the line endings.
 *      8. InjectCSS instead of browser page reload.
 *      9. Generates .pot file for i18n and l10n.
 *
 */

/**
 * Load Gulp Configuration.
 */
const config = require( './gulp.config.js' );

/**
 * Load Plugins.
 *
 * Load gulp plugins and passing them semantic names.
 */
const gulp = require( 'gulp' ); // Gulp
const run = require( 'gulp-run-command' ).default; // Used to run linters until I can figure out how to make that part of the build process

// CSS related plugins.
const sass = require( 'gulp-sass' ); // Gulp plugin for Sass compilation.
const cssnano = require( 'cssnano' ); // Minifies CSS files.
const cssnext = require( 'postcss-cssnext' );
const postcss = require( 'gulp-postcss' );
const rtlcss = require( 'gulp-rtlcss' ); // Generates RTL stylesheet.

// JS related plugins.
const webpack = require('webpack-stream'); // Ensures we can import dependencies
const concat = require( 'gulp-concat' ); // Concatenates JS files.
const uglify = require( 'gulp-uglify' ); // Minifies JS files.
const babel = require( 'gulp-babel' ); // Compiles ESNext to browser compatible JS.

// Image related plugins.
const imagemin = require( 'gulp-imagemin' ); // Minify PNG, JPEG, GIF and SVG images with imagemin.

// Utility related plugins.
const rename = require( 'gulp-rename' ); // Renames files E.g. style.css -> style.min.css.
const lineec = require( 'gulp-line-ending-corrector' ); // Consistent Line Endings for non UNIX systems. Gulp Plugin for Line Ending Corrector (A utility that makes sure your files have consistent line endings).
const filter = require( 'gulp-filter' ); // Enables you to work on a subset of the original files by filtering them using a glob.
const sourcemaps = require( 'gulp-sourcemaps' ); // Maps code in a compressed file (E.g. style.css) back to it’s original position in a source file (E.g. structure.scss, which was later combined with other css files to generate style.css).
const notify = require( 'gulp-notify' ); // Sends message notification to you.
const browserSync = require( 'browser-sync' ).create(); // Reloads browser and injects CSS. Time-saving synchronized browser testing.
const wpPot = require( 'gulp-wp-pot' ); // For generating the .pot file.
const sort = require( 'gulp-sort' ); // Recommended to prevent unnecessary changes in pot-file.
const cache = require( 'gulp-cache' ); // Cache files in stream for later use.
const remember = require( 'gulp-remember' ); //  Adds all the files it has ever seen back into the stream.
const plumber = require( 'gulp-plumber' ); // Prevent pipe breaking caused by errors from gulp plugins.
const beep = require( 'beepbeep' );
const gulpif = require( 'gulp-if' );
const argv = require('yargs').argv;

// Variables Used within Build Process
const isProduction = (argv.production !== undefined);
const postCssProd = [ cssnext(), cssnano() ];
const postCssDev = [ cssnext() ];

/**
 * Custom Error Handler.
 *
 * @param Mixed err
 */
const errorHandler = r => {
	notify.onError( '\n\n===> ERROR: <%= error.message %>\n' )( r );
	beep();

	// this.emit('end');
};

/**
 * Task: `browser-sync`.
 *
 * Live Reloads, CSS injections, Localhost tunneling.
 * @link http://www.browsersync.io/docs/options/
 *
 * @param {Mixed} done Done.
 */
const browsersync = done => {
	browserSync.init({
		proxy: config.projectURL,
		open: config.browserAutoOpen,
		injectChanges: config.injectChanges,
		watchEvents: [ 'change', 'add', 'unlink', 'addDir', 'unlinkDir' ]
	});
	done();
};

// Helper function to allow browser reload with Gulp 4.
const reload = done => {
	browserSync.reload();
	done();
};

/**
 * Task: `styles`.
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS.
 *
 * This task does the following:
 *    1. Gets the source scss file
 *    2. Compiles Sass to CSS
 *    3. Writes Sourcemaps for it
 *    4. Autoprefixes it and generates style.css
 *    5. Renames the CSS file with suffix .min.css
 *    6. Minifies the CSS file and generates style.min.css
 *    7. Injects CSS or reloads the browser via browserSync
 */
gulp.task( 'styles', () => {
	let stream = gulp
		.src( config.styleSRC, { allowEmpty: true })
		.pipe( plumber() )
		.pipe( sourcemaps.init() )
		.pipe(
			sass({
				errLogToConsole: config.errLogToConsole,
				outputStyle: config.outputStyle,
				precision: config.precision
			})
		)
		.on( 'error', sass.logError )
		.pipe( gulpif( isProduction, postcss( postCssProd ), postcss( postCssDev ) ) )
		.pipe( sourcemaps.write({ includeContent: false }) )
		.pipe( sourcemaps.init({ loadMaps: true }) )
		.pipe( sourcemaps.write( './' ) )
		.pipe( lineec() ) // Consistent Line Endings for non UNIX systems.
		.pipe( gulp.dest( config.styleDestination ) )
		.pipe( filter( '**/*.css' ) ) // Filtering stream to only css files.
		.pipe( gulpif( !isProduction, browserSync.stream() ) ) // Reloads style.css if that is enqueued.
		.pipe( notify({ message: '\n\n===> Styles Compiled\n', onLast: true }) );

		stream.on('end', run('npm run stylelint'));

		return stream;
	});

/**
 * Task: `customJS`.
 *
 * Concatenate and uglify custom JS scripts.
 *
 * This task does the following:
 *     1. Gets the source folder for JS custom files
 *     2. Concatenates all the files and generates custom.js
 *     3. Renames the JS file with suffix .min.js
 *     4. Uglifes/Minifies the JS file and generates custom.min.js
 */
gulp.task( 'customJS', () => {
	let stream = gulp
		.src( config.jsCustomSRC, { allowEmpty: true }) // Only run on changed files.
		.pipe( plumber( errorHandler ) )
		.pipe( webpack({ mode: isProduction ? 'production' : 'development' }))
		.pipe(
			babel({
				presets: [
					[
						'@babel/preset-env', // Preset to compile your modern JS to ES5.
						{
							targets: { browsers: config.BROWSERS_LIST } // Target browser list to support.
						}
					]
				],
				compact: isProduction
			})
		)
		.pipe( concat( config.jsCustomFile + '.js' ) )
		.pipe( gulpif( isProduction, uglify() ) )
		.pipe( lineec() ) // Consistent Line Endings for non UNIX systems.
		.pipe( gulp.dest( config.jsCustomDestination ) )
		.pipe( notify({ message: '\n\n===> JavaScript Compiled\n', onLast: true }) );

	stream.on('end', run('npm run eslint'));

	return stream;
});

/**
 * Task: `images`.
 *
 * Minifies PNG, JPEG, GIF and SVG images.
 *
 * This task does the following:
 *     1. Gets the source of images raw folder
 *     2. Minifies PNG, JPEG, GIF and SVG images
 *     3. Generates and saves the optimized images
 *
 * This task will run only once, if you want to run it
 * again, do it with the command `gulp images`.
 *
 * Read the following to change these options.
 * @link https://github.com/sindresorhus/gulp-imagemin
 */
gulp.task( 'images', () => {
	return gulp
		.src( config.imgSRC )
		.pipe(
			cache(
				imagemin([
					imagemin.gifsicle({ interlaced: true }),
					imagemin.mozjpeg({ progressive: true }),
					imagemin.optipng({ optimizationLevel: 3 }), // 0-7 low-high.
					imagemin.svgo({
						plugins: [ { removeViewBox: true }, { cleanupIDs: false } ]
					})
				])
			)
		)
		.pipe( gulp.dest( config.imgDST ) )
		.pipe( notify({ message: '\n\n===> Images Optimized\n', onLast: true }) );
});

/**
 * Task: `clear-images-cache`.
 *
 * Deletes the images cache. By running the next "images" task,
 * each image will be regenerated.
 */
gulp.task( 'clearCache', function( done ) {
	return cache.clearAll( done );
});

/**
 * WP POT Translation File Generator.
 *
 * This task does the following:
 * 1. Gets the source of all the PHP files
 * 2. Sort files in stream by path or any custom sort comparator
 * 3. Applies wpPot with the variable set at the top of this file
 * 4. Generate a .pot file of i18n that can be used for l10n to build .mo file
 */
gulp.task( 'translate', () => {
	return gulp
		.src( config.watchPhp )
		.pipe( sort() )
		.pipe(
			wpPot({
				domain: config.textDomain,
				package: config.packageName,
				bugReport: config.bugReport,
				lastTranslator: config.lastTranslator,
				team: config.team
			})
		)
		.pipe( gulp.dest( config.translationDestination + '/' + config.translationFile ) )
		.pipe( notify({ message: '\n\n===> Translations Compiled\n', onLast: true }) );
});

/**
 * Watch Tasks.
 *
 * Watches for file changes and runs specific tasks.
 */
gulp.task(
	'default',
	gulp.parallel( 'styles', 'customJS', 'images', browsersync, () => {
		gulp.watch( config.watchPhp, reload ); // Reload on PHP file changes.
		gulp.watch( config.watchTwig, reload ); // Reload on Twig file changes.
		gulp.watch( config.watchStyles, gulp.parallel( 'styles' ) ); // Reload on SCSS file changes.
		gulp.watch( config.watchJsCustom, gulp.series( 'customJS', reload ) ); // Reload on customJS file changes.
		gulp.watch( config.imgSRC, gulp.series( 'images', reload ) ); // Reload on customJS file changes.
	})
);

/**
 * Build for Production.
 *
 * Watches for file changes and runs specific tasks.
 */
gulp.task('production', gulp.parallel( 'styles', 'customJS', 'images'));
