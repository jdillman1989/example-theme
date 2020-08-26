<?php
/**
 *	Ensure We are loading all Timber dependencies
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber has not been activated within the theme. Run `composer install` within theme folder to load Timber dependencies.</p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Define constants for general use.
 */
if (!defined('TPL_PATH')) define('TPL_PATH', get_template_directory());
if (!defined('TPL_URL')) define('TPL_URL', get_template_directory_uri());

/**
 *	Clean up WordPress autoloaded scripts and styles.
 */
require_once 'library/cleanup.php';

/**
 *	Method for rendering complied assets with hash to ensure
 *	users download latest versions
 */
require_once 'library/render-compiled.php';

/**
 *	Modify theme support for the WordPress build/
 */
require_once 'library/theme-support.php';

/**
 * Add theme utilities
 */
require_once 'library/theme-utils.php';

/**
 * Add theme shortcodes
 */
require_once 'library/theme-shortcodes.php';

/**
 * Enqueue Scripts and Styles
 */
require_once 'library/enqueue-scripts.php';

/**
 *	Custom Post Types
 */
require_once 'library/post-types.php';

/**
 *	Custom Taxonomies
 */
require_once 'library/taxonomies.php';

/**
 *  Advanced Custom Fields Related
 */
require_once 'library/advanced-custom-fields.php';

/**
 * Contact Form 7 Customizations
 */
require_once 'library/cf7-customization.php';

/**
 *	Add elements to the Timber Context
 */
require_once 'library/context.php';

/**
 *	Declare and build out content types and ACF fields
 */
require_once 'model/model-init.php';
