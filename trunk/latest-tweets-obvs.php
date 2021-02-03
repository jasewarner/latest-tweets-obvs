<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://jase.io/
 * @since             1.0.0
 * @package           Latest_Tweets_Obvs
 *
 * @wordpress-plugin
 * Plugin Name:       Latest Tweets Obvs
 * Plugin URI:        https://jase.io/archive/development/latest-tweets-obvs/
 * Description:       Latest Tweets Obvs is a simple plugin that displays, well, latest tweets (obvs) via the Twitter API.
 * Version:           1.0.7
 * Author:            Jase Warner
 * Author URI:        https://jase.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       latest-tweets-obvs
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Pull in plugin basename.
if ( ! defined( 'LATEST_TWEETS_OBVS_BASENAME' ) ) {
	define( 'LATEST_TWEETS_OBVS_BASENAME', plugin_basename( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-latest-tweets-obvs-activator.php
 */
function activate_latest_tweets_obvs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-latest-tweets-obvs-activator.php';
	Latest_Tweets_Obvs_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-latest-tweets-obvs-deactivator.php
 */
function deactivate_latest_tweets_obvs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-latest-tweets-obvs-deactivator.php';
	Latest_Tweets_Obvs_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_latest_tweets_obvs' );
register_deactivation_hook( __FILE__, 'deactivate_latest_tweets_obvs' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-latest-tweets-obvs.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_latest_tweets_obvs() {

	$plugin = new Latest_Tweets_Obvs();
	$plugin->run();

}
run_latest_tweets_obvs();
