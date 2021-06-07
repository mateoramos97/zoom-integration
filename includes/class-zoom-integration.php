<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https:workinglive.us
 * @since      1.0.0
 *
 * @package    Zoom_Integration
 * @subpackage Zoom_Integration/includes
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
 * @package    Zoom_Integration
 * @subpackage Zoom_Integration/includes
 * @author     Mateo Ramos-Freddy Buele <mateo@workinglive.us>
 */
class Zoom_Integration {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Zoom_Integration_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

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
		if ( defined( 'ZOOM_INTEGRATION_VERSION' ) ) {
			$this->version = ZOOM_INTEGRATION_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'zoom-integration';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Zoom_Integration_Loader. Orchestrates the hooks of the plugin.
	 * - Zoom_Integration_i18n. Defines internationalization functionality.
	 * - Zoom_Integration_Admin. Defines all hooks for the admin area.
	 * - Zoom_Integration_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-zoom-integration-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-zoom-integration-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-zoom-integration-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-zoom-integration-public.php';

		$this->loader = new Zoom_Integration_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Zoom_Integration_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Zoom_Integration_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Zoom_Integration_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		//Add endpoint hook
		
		$this->loader->add_filter( 'woocommerce_account_menu_items',$plugin_admin,'misha_log_history_link', 40 );
		$this->loader->add_action( 'init',$plugin_admin, 'misha_add_endpoint' );
		$this->loader->add_action( 'woocommerce_account_zoom-meetings_endpoint',$plugin_admin, 'misha_my_account_endpoint_content' );
		//Add endpoint hook
		
		$this->loader->add_filter( 'woocommerce_account_menu_items',$plugin_admin,'zoom_settings_link2', 40 );
		$this->loader->add_action( 'init',$plugin_admin, 'zoom_settings_add_endpoint' );
		$this->loader->add_action( 'woocommerce_account_zoom-settings_endpoint',$plugin_admin, 'zoom_settings_my_account_endpoint_content' );
		//Add endpoint hook
		
		$this->loader->add_filter( 'woocommerce_account_menu_items',$plugin_admin,'zoom_recordings_link2', 40 );
		$this->loader->add_action( 'init',$plugin_admin, 'zoom_recordings_add_endpoint' );
		$this->loader->add_action( 'woocommerce_account_zoom-recordings_endpoint',$plugin_admin, 'zoom_recordings_my_account_endpoint_content' );

		//Add endpoint
		$this->loader->add_filter( 'woocommerce_account_menu_items',$plugin_admin,'ai_reports_link', 40 );
		$this->loader->add_action( 'init',$plugin_admin, 'ai_reports_add_endpoint' );
		$this->loader->add_action( 'woocommerce_account_ai-reports_endpoint',$plugin_admin, 'ai_reports_my_account_endpoint_content' );
		
		//LLAMA AL ARCHIVO CSS PERSONALIZADO
		$this->loader->add_action('wp_enqueue_scripts',$plugin_admin,'enqueue_styles');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Zoom_Integration_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
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
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Zoom_Integration_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
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

}
