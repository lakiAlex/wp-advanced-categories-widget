<?php

/**
 *
 * @link              https://github.com/lakiAlex/
 * @since             1.0.0
 * @package           Wpacw
 *
 * @wordpress-plugin
 * Plugin Name:       WP Advanced Categories Widget
 * Plugin URI:        https://github.com/lakiAlex/wp-advanced-categories-widget
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Lazar Momcilovic
 * Author URI:        https://github.com/lakiAlex/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpacw
 * Domain Path:       /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WPACW_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpacw-activator.php
 */
function activate_wpacw() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/class-wpacw-activator.php';
	Wpacw_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpacw-deactivator.php
 */
function deactivate_wpacw() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/class-wpacw-deactivator.php';
	Wpacw_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpacw' );
register_deactivation_hook( __FILE__, 'deactivate_wpacw' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'inc/class-wpacw.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpacw() {

	$plugin = new Wpacw();
	$plugin->run();

}
run_wpacw();
