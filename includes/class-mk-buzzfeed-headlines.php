<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       chickencross.se
 * @since      1.0.0
 *
 * @package    Mk_Buzzfeed_Headlines
 * @subpackage Mk_Buzzfeed_Headlines/includes
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
 * @package    Mk_Buzzfeed_Headlines
 * @subpackage Mk_Buzzfeed_Headlines/includes
 * @author     Michal Kurowski <michal10203040@gmail.com>
 */
class Mk_Buzzfeed_Headlines {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Mk_Buzzfeed_Headlines_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'MK_BUZZFEED_HEADLINES_VERSION' ) ) {
			$this->version = MK_BUZZFEED_HEADLINES_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'mk-buzzfeed-headlines';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		// run function register_widget that register the widget.
		$this->register_widget();

		// run function register_ajax_actions that register ajax actions.
		$this->register_ajax_actions();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mk_Buzzfeed_Headlines_Loader. Orchestrates the hooks of the plugin.
	 * - Mk_Buzzfeed_Headlines_i18n. Defines internationalization functionality.
	 * - Mk_Buzzfeed_Headlines_Admin. Defines all hooks for the admin area.
	 * - Mk_Buzzfeed_Headlines_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mk-buzzfeed-headlines-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mk-buzzfeed-headlines-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mk-buzzfeed-headlines-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mk-buzzfeed-headlines-public.php';
		
		/**
		 * The class responsible for the widget.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mk-buzzfeed-headlines-widget.php';

		$this->loader = new Mk_Buzzfeed_Headlines_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mk_Buzzfeed_Headlines_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Mk_Buzzfeed_Headlines_i18n();

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

		$plugin_admin = new Mk_Buzzfeed_Headlines_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Mk_Buzzfeed_Headlines_Public( $this->get_plugin_name(), $this->get_version() );

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
	 * Register the widget for the plugin.
	 *
	 * @since    1.0.0
	 */
	public function register_widget() {
		add_action('widgets_init', function(){
			register_widget('Mk_Buzzfeed_headlines_Widget');
		});
	}

	/**
	 * Register the ajax actions for the plugin.
	 *
	 * @since    1.0.0
	 */
	public function register_ajax_actions() {
		// Register ajax action wp_ajax_buzzfeed_headlines__get.
		// If logged in action.
		add_action('wp_ajax_buzzfeed_headlines__get', [
			$this,
			'ajax_buzzfeed_headlines__get',
		]);
		// If logged out action.
		add_action('wp_ajax_nopriv_buzzfeed_headlines__get', [
			$this,
			'ajax_buzzfeed_headlines__get',
		]);
	}

	/**
	 * Respond to ajax action ajax_buzzfeed_headlines__get.
	 *
	 * @since    1.0.0
	 */
	public function ajax_buzzfeed_headlines__get() {
		// Merge the URL with Parameters and the APIKEY.
		$authorized_url = MK_BUZZFEED_HEADLINES__GET_URL . "?sources=buzzfeed&pageSize=3&apiKey=" . MK_BUZZFEED_HEADLINES_APIKEY;
		// Get the remote URL.
		$response = wp_remote_get($authorized_url);
		// Check if the $response was successful or if there was any Error.
		if(is_wp_error($response) || wp_remote_retrieve_response_code($response) != 200) {
			wp_send_json_error([
				// Get the Error Code.
				'error_code' => wp_remote_retrieve_response_code($response),
				// Get the Error Message.
				'error_msg' => wp_remote_retrieve_response_message($response),
			]);
		}
		$body = json_decode(wp_remote_retrieve_body($response));

		// wp_send_json_success($body);

		wp_send_json_success([
			'headlines' => $body->articles,
		]);
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
	 * @return    Mk_Buzzfeed_Headlines_Loader    Orchestrates the hooks of the plugin.
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
