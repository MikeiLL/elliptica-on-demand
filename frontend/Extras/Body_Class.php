<?php
/**
 * Plugin_name
 *
 * @package   Plugin_name
 * @author    Mike iLL <mike@mzoo.org>
 * @copyright 2020 mZoo.org
 * @license   GPL 2.0+
 * @link      http://mzoo.org
 */
namespace Elliptica_On_Demand\Frontend\Extras;

use \Elliptica_On_Demand\Engine;
use \Elliptica_On_Demand\Rest;
/**
 * Add custom css class to <body>
 */
class Body_Class extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();
		add_filter( 'body_class', array( __CLASS__, 'add_mmc_class' ), 10, 3 );
		add_action( 'rest_api_init', array( __CLASS__, 'add_restful_endpoint' ), 10, 3);
	}

	/**
	 * Add class in the body on the frontend
	 *
	 * @param array $classes The array with all the classes of the page.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function add_mmc_class( $classes ) {
		$classes[] = MMC_TEXTDOMAIN;
		return $classes;
	}

	/**
	 * Add class in the body on the frontend
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function add_restful_endpoint( ) {
		$restEx = new Rest\Example;
		$restEx->add_simple_route();
	}

}
