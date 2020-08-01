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
namespace Elliptica_On_Demand\Ajax;

use Elliptica_On_Demand\Engine;

/**
 * AJAX in the public
 */
class Ajax extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( !apply_filters( 'elliptica_on_demand_mmc_ajax_initialize', true ) ) {
			return;
		}

		// For not logged user
		add_action( 'wp_ajax_nopriv_your_method', array( $this, 'your_method' ) );
	}

	/**
	 * The method to run on ajax
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function your_method() {
		$return = array(
			'message' => 'Saved',
			'ID'      => 1,
		);

		wp_send_json_success( $return );
		// wp_send_json_error( $return );
	}

}

