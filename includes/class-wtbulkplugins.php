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
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
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

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10, 1 );

		add_filter( 'bulk_actions-plugins', array( $this, 'register_bulk_action' ) );
		add_filter( 'handle_bulk_actions-plugins', array( $this, 'bulk_action_handler' ), 10, 3 );

		add_action( 'admin_notices', array( $this, 'bulk_action_admin_notice' ) );
		add_action( 'admin_menu', array($this, 'register_menu') );

		add_filter( 'plugin_action_links', array( $this, 'add_action_links' ), 10, 4 );

		add_action( 'current_screen', array($this, 'plugin_screen_hook') );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public() {

		add_action( 'wp_enqueue_scripts', array( $this, 'public_enqueue_scripts' ) );
	}

	/**
	 * Admin styles and scripts
	 *
	 * @since     1.0.0
	 */
	public function admin_enqueue_scripts( $screen ) {
		if('plugins.php' === $screen) {
			wp_enqueue_style( WTBP_PLUGIN_PREFIX . 'admin-basic-style', WTBP_PLUGIN_URL . '/admin/css/wtbp-admin.css', array() );
			wp_enqueue_script( WTBP_PLUGIN_PREFIX . 'admin-basic-script', WTBP_PLUGIN_URL . '/admin/js/wtbp-admin.js', array() );
			wp_localize_script(
				WTBP_PLUGIN_PREFIX . 'admin-basic-script',
				'wtbp_confirm_text', __( 'Are you sure you want to deactivate and remove the plugin?', 'bulk-plugins' )
			);
		}

	}

	/**
	 * Public styles and scripts
	 *
	 * @since     1.0.0
	 */
	public function public_enqueue_scripts() {

	}

	/**
	 * Register menu
	 *
	 * @since     1.0.0
	 */
	public function register_menu() {
		add_options_page(
			'Bulk Plugin Manager settings',
			'Bulk Plugin Manager',
			'manage_options',
			'wtbp-settings',
			array($this, 'show_settings') );
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

#endregion Basic functions

#region Plugin Functions
	/**
	 * Settings page
	 *
	 */
	public function show_settings() {
		if(isset($_POST['wtbp_work_format']))
		{
			update_option( WTBP_PLUGIN_PREFIX.'work_format', (int) $_POST['wtbp_work_format']);
			echo '<div id="message" class="updated"><p>' . __( 'Settings updated', 'bulk-plugins' ) . '</p></div>';
		}
		require_once WTBP_PLUGIN_PATH."admin/settings.php";
	}

	/**
	 * Register bulk option
	 *
	 * @return array(string)
	 */
	public function register_bulk_action( $bulk_actions ) {
		$bulk_actions['wtbp_deactivate_and_delete'] = __( 'Deactivate and delete', 'bulk-plugins' );

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
	public function bulk_action_handler( $redirect_to, $doaction, $plugins ) {
		if ( $doaction !== 'wtbp_deactivate_and_delete' ) {
			return $redirect_to;
		}
		$dd_plugins = 0;
		foreach ( $plugins as $plugin ) {
			if($this->deactivate_and_delete($plugin)) $dd_plugins++;
		}

		$redirect_to = add_query_arg(
			array(
				'wtbp_bulk_action' => $dd_plugins ? $dd_plugins : __( 'You do not have enough permissions to remove or deactivate plugins', 'bulk-plugins' ),
			),
			$redirect_to );

		return $redirect_to;
	}

	/**
	 * Admin notice after bulk action
	 *
	 */
	public function bulk_action_admin_notice() {
		if ( empty( $_GET['wtbp_bulk_action'] ) ) {
			return;
		}

		$data = htmlspecialchars( strip_tags( $_GET['wtbp_bulk_action'] ) );
		$msg  = "<b>" . __( 'Plugins deactivated and delete: ', 'bulk-plugins' ) . "</b>" . $data;
		echo '<div id="message" class="updated"><p>' . $msg . '</p></div>';
	}

	/**
	 * Admin notice after bulk action
	 *
	 */
	public function add_action_links( $actions, $plugin_file, $plugin_data, $context ) {
		if ( is_plugin_active( $plugin_file ) ) {
			$actions[] = '<a href="' . add_query_arg(array( 'action' => 'deactivate_and_delete', 'plugin' => urlencode( $plugin_file ) )) .'" id="wtbp-delete-confirm">' . __( 'Deactivate and delete', 'bulk-plugins' ) . '</a>';
		}

		return $actions;
	}

	/**
	 * Deactivate and delete plugin
	 *
	 * @param string $plugin
	 * @return bool
	 */
	public function deactivate_and_delete( $plugin ) {
		if ( current_user_can( 'deactivate_plugin', $plugin ) ) {
			deactivate_plugins( $plugin, true );

			if ( current_user_can( 'delete_plugins' ) ) {
				// TODO: раскомментировать!
				//delete_plugins( $plugin );

				return true;
			}
		}

		return false;
	}

	/**
	 * Hook action on plugins.php screen
	 *
	 */
	public function plugin_screen_hook( $screen ) {
		if('plugins' == $screen->id)
		{
			if(isset($_GET['action']) && isset($_GET['plugin']) && $_GET['action'] === 'deactivate_and_delete')
			{
				$this->deactivate_and_delete(urldecode( $_GET['plugin']));

				$_SERVER['REQUEST_URI'] = remove_query_arg( array( 'action', 'plugin' ), $_SERVER['REQUEST_URI'] );
				wp_redirect( add_query_arg( array("deleted" => "true"), $_SERVER['REQUEST_URI'] ) );
				$_SERVER['REQUEST_URI'] = remove_query_arg( array( 'deleted' ), $_SERVER['REQUEST_URI'] );
			}
		}
	}

#endregion Plugin Functions
}
