<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://tinajam.wordpress.com/
 * @since             1.0.0
 * @package           Concrt_Ticket
 *
 * @wordpress-plugin
 * Plugin Name:       Concert Ticketing
 * Plugin URI:        https://tinajam.wordpress.com/
 * Description:       A plugin to manage concert ticketing.
 * Version:           1.0.0
 * Author:            tahir iqbal
 * Author URI:        https://tinajam.wordpress.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       concrt-ticket
 * Domain Path:       /languages
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
define( 'CONCRT_TICKET_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-concrt-ticket-activator.php
 */
function activate_concrt_ticket() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-concrt-ticket-activator.php';
	Concrt_Ticket_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-concrt-ticket-deactivator.php
 */
function deactivate_concrt_ticket() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-concrt-ticket-deactivator.php';
	Concrt_Ticket_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_concrt_ticket' );
register_deactivation_hook( __FILE__, 'deactivate_concrt_ticket' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-concrt-ticket.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_concrt_ticket() {

	$plugin = new Concrt_Ticket();
	$plugin->run();

}
run_concrt_ticket();
