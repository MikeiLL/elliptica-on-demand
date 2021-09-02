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
namespace Elliptica_On_Demand\Internals;

use \Elliptica_On_Demand\Rest;

/**
 * Activate and deactive method of the plugin and relates.
 */
class InitRest extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! parent::initialize() ) {
			return;
		}

		// Initilize rest api
		add_action( 'rest_api_init', array( __CLASS__, 'add_restful_endpoint' ), 10, 3 );
	}



	/**
	 * Initialize custom restful endpoints.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function add_restful_endpoint() {
		$on_demand_rest = new Rest\OnDemand;
		$on_demand_rest->add_simple_route();
	}

}
