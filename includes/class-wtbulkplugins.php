<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 * @author     Temyk <webtemyk@yandex.ru>
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 */
class WTBulkPlugins {

#region Properties
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

#endregion Properties

#region Basic functions

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WTBP_VERSION' ) ) {
			$this->version = WTBP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = WTBP_PLUGIN_SLUG;

		$this->define_admin();
		$this->define_public();

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin() {

		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 10, 1);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public() {

		add_action('wp_enqueue_scripts', array($this, 'public_enqueue_scripts'));
	}

	/**
	 * Admin styles and scripts
	 *
	 * @since     1.0.0
	 */
	public function admin_enqueue_scripts($screen) {
		wp_enqueue_style( WTBP_PLUGIN_PREFIX.'admin-basic-style', WTBP_PLUGIN_PATH.'/admin/css/wtbp-admin.css', array() );
		wp_enqueue_script(WTBP_PLUGIN_PREFIX.'admin-basic-script', WTBP_PLUGIN_PATH.'/admin/js/wtbp-admin.js', array());

	}

	/**
	 * Public styles and scripts
	 *
	 * @since     1.0.0
	 */
	public function public_enqueue_scripts() {

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

#endregion Basic functions

#region Plugin Functions
//
#endregion Plugin Functions
}
