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
namespace Intensity_On_Demand\Ajax;

use \Intensity_On_Demand\Engine;

/**
 * AJAX as logged user
 */
class Ajax_Admin extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( !apply_filters( 'intensity_on_demand_mmc_ajax_admin_initialize', true ) ) {
			return;
		}

		// For logged user
		add_action( 'wp_ajax_your_admin_method', array( $this, 'your_admin_method' ) );
	}

	/**
	 * The method to run on ajax
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function your_admin_method() {
		$return = array(
			'message' => 'Saved',
			'ID'      => 2,
		);

		wp_send_json_success( $return );
		// wp_send_json_error( $return );
	}

}

