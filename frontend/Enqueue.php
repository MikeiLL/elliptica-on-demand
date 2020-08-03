<?php
/**
 * Elliptica_On_Demand
 *
 * @package   Elliptica_On_Demand
 * @author    Mike iLL <mike@mzoo.org>
 * @copyright 2020 mZoo.org
 * @license   GPL 2.0+
 * @link      http://mzoo.org
 */
namespace Elliptica_On_Demand\Frontend;

use Elliptica_On_Demand\Engine;

/**
 * Enqueue stuff on the frontend
 */
class Enqueue extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		// Load public-facing style sheet and JavaScript.
		//add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ) );
		//add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		//add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_js_vars' ) );
	}


	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function enqueue_styles() {
		wp_enqueue_style( MMC_TEXTDOMAIN . '-plugin-styles', plugins_url( 'assets/css/public.css', MMC_PLUGIN_ABSOLUTE ), array(), MMC_VERSION );
	}


	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function enqueue_scripts() {
		wp_enqueue_script( MMC_TEXTDOMAIN . '-plugin-script', plugins_url( 'assets/js/public.js', MMC_PLUGIN_ABSOLUTE ), array( 'jquery' ), MMC_VERSION );
	}


	/**
	 * Print the PHP var in the HTML of the frontend for access by JavaScript.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function enqueue_js_vars() {
		wp_localize_script(
             MMC_TEXTDOMAIN . '-plugin-script',
            'mmc_js_vars',
            array(
				'alert' => __( 'Hey! You have clicked the button!', MMC_TEXTDOMAIN ),
			)
		);
	}

}
