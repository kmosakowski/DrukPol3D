<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

/**
 *
 * @link              https://www.gutentor.com/
 * @since             1.0.0
 * @package           Gutentor
 *
 * @wordpress-plugin
 * Plugin Name:       Gutentor: WordPress Page Builder with Unlimited Possibilities to Design
 * Description:       The most advanced yet easy drag & drop block page builder. Create masterpiece, pixel perfect websites using modern WordPress way. Work with any theme, create any design.
 * Version:           1.2.2
 * Author:            Gutentor
 * Author URI:        https://www.gutentor.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gutentor
 * Domain Path:       /languages
 */

/*Define Constants for this plugin*/
define( 'GUTENTOR_VERSION', '1.2.2' );
define( 'GUTENTOR_PLUGIN_NAME', 'gutentor' );
define( 'GUTENTOR_PATH', plugin_dir_path( __FILE__ ) );
define( 'GUTENTOR_URL', plugin_dir_url( __FILE__ ) );
define( 'GUTENTOR_SCRIPT_PREFIX', ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min' );

/*Gutentor Template Library is IMPORTANT*/
define( 'GUTENTOR_RECOMMENDED_TEMPLATE_LIBRARY_SLUG', 'gutentor-template-library' );
define( 'GUTENTOR_RECOMMENDED_TEMPLATE_LIBRARY_PLUGIN', GUTENTOR_RECOMMENDED_TEMPLATE_LIBRARY_SLUG.'/'.GUTENTOR_RECOMMENDED_TEMPLATE_LIBRARY_SLUG.'.php' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gutentor-activator.php
 */
function activate_gutentor() {
	require_once GUTENTOR_PATH . 'includes/activator.php';
	Gutentor_Activator::activate();
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require GUTENTOR_PATH . 'includes/init.php';

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gutentor-deactivator.php
 */
function deactivate_gutentor() {
	require_once GUTENTOR_PATH . 'includes/deactivator.php';
	Gutentor_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_gutentor' );
register_deactivation_hook( __FILE__, 'deactivate_gutentor' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
if( !function_exists( 'run_gutentor')){

	function run_gutentor() {

		return Gutentor::instance();
	}
	run_gutentor()->run();
}