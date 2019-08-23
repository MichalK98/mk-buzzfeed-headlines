<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       chickencross.se
 * @since      1.0.0
 *
 * @package    Mk_Buzzfeed_Headlines
 * @subpackage Mk_Buzzfeed_Headlines/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mk_Buzzfeed_Headlines
 * @subpackage Mk_Buzzfeed_Headlines/includes
 * @author     Michal Kurowski <michal10203040@gmail.com>
 */
class Mk_Buzzfeed_Headlines_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mk-buzzfeed-headlines',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
