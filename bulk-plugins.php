<?php
/**
 * Plugin Name:       Bulk Plugin Manager
 * Plugin URI:        temyk.ru
 * Description:       This plugin allows you to bulk deactivate and immediately remove other plugins
 * Version:           1.0.0
 * Author:            Webtemyk
 * Author URI:        temyk.ru
 * License:           GPL-2.0+
 * Text Domain:       bulk-plugins
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
define( 'WTBP_VERSION', '1.0.0' );
define( 'WTBP_PLUGIN_FILE', __FILE__ );
define( 'WTBP_ABSPATH', dirname( __FILE__ ) );
define( 'WTBP_PLUGIN_BASENAME', plugin_basename( __FILE__ ));
define( 'WTBP_PLUGIN_SLUG', dirname(plugin_basename( __FILE__ )));

define( 'WTBP_PLUGIN_URL', plugins_url( null, __FILE__ ) );
define( 'WTBP_PLUGIN_PATH', plugin_dir_path( __FILE__ ));

define( 'WTBP_PLUGIN_PREFIX', 'WTBP_');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-activator.php
 */
function WTBP_activate() {
	require_once WTBP_PLUGIN_PATH.'includes/class-activator.php';
	WTBP_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-deactivator.php
 */
function WTBP_deactivate() {
	require_once WTBP_PLUGIN_PATH.'includes/class-deactivator.php';
	WTBP_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'WTBP_activate' );
register_deactivation_hook( __FILE__, 'WTBP_deactivate' );

load_plugin_textdomain(
	'bulk-plugins',
	false,
	dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
);

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require WTBP_PLUGIN_PATH.'includes/class-wtbulkplugins.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

global $WTBP_Plugin;
$WTBP_Plugin = new WTBulkPlugins();
