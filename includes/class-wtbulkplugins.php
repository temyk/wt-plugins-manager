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
		add_filter( 'bulk_actions-plugins', [ $this, 'register_bulk_action'] );
		add_filter( 'handle_bulk_actions-plugins', [ $this, 'bulk_action_handler'], 10, 3 );
		add_action( 'admin_notices', [ $this, 'wtbp_bulk_action_admin_notice'] );
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
	/**
	 * Register bulk option
	 *
	 * @return array(string)
	 */
	public function register_bulk_action($bulk_actions)
	{
		$bulk_actions['wtbp_deactivate_and_delete'] = __('Deactivate and delete', 'bulk-plugins');
		return $bulk_actions;
	}

	/**
	 * Handler of bulk option
	 *
	 * @param $redirect_to
	 * @param $doaction
	 * @param $plugins
	 *
	 * @return string
	 */
	public function bulk_action_handler($redirect_to, $doaction, $plugins)
	{
		if( $doaction !== 'wtbp_deactivate_and_delete' )
			return $redirect_to;
		$dd_plugins = array();
		foreach( $plugins as $plugin )
		{
			if ( current_user_can( 'deactivate_plugin', $plugin ) ) {
				//deactivate_plugins( $plugin, true );

				if ( current_user_can( 'delete_plugins' ) ) {
					//delete_plugins( $plugin );

					$dd_plugins[] = get_plugin_data( trailingslashit(WP_PLUGIN_DIR).$plugin, false, true);
				}
			}
		}

		$redirect_to = add_query_arg(
			array(
				'wtbp_bulk_action' => count($dd_plugins) ? count($dd_plugins) : __('You do not have enough permissions to remove or deactivate plugins','bulk-plugins'),
			),
			$redirect_to );

		return $redirect_to;
	}

	/**
	 * Admin notice after bulk action
	 *
	 */
	public function wtbp_bulk_action_admin_notice()
	{
		if( empty( $_GET['wtbp_bulk_action'] ) )
			return;

		$data = htmlspecialchars( strip_tags( $_GET['wtbp_bulk_action']));
		$msg = "<b>".__('Plugins deactivated and delete: ','bulk-plugins')."</b>".$data;
		echo '<div id="message" class="updated"><p>'. $msg .'</p></div>';
	}

#endregion Plugin Functions
}
