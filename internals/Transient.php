<?php

/**
 * Plugin name
 *
 * @package   Plugin_name
 * @author    Mike iLL <mike@mzoo.org>
 * @copyright 2020 mZoo.org
 * @license   GPL 2.0+
 * @link      http://mzoo.org
 */
namespace Elliptica_On_Demand\Internals;

use \Elliptica_On_Demand\Engine;

/**
 * Transient used by the plugin
 * @SuppressWarnings(PHPMD)
 */
class Transient extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();
	}

	/**
	 * This method contain an example of caching a transient with an external request.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function transient_caching_example() {
		$key = 'placeholder_json_transient';

		// Use wp-cache-remember package to retrive or save in transient
		return remember_transient(
            $key,
            function () use ( $key ) {
				// If there's no cached version we ask
				$response = wp_remote_get( 'https://jsonplaceholder.typicode.com/todos/' );
				if ( is_wp_error( $response ) ) {
					// In case API is down we return the last successful count
					return;
				}

				// If everything's okay, parse the body and json_decode it
				return json_decode( wp_remote_retrieve_body( $response ) );
			},
            DAY_IN_SECONDS
            );
	}

	/**
	 * Print the transient content
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function print_transient_output() {
		$transient = $this->transient_caching_example();
		echo '<div class="siteapi-bridge-container">';
		foreach ( $transient as &$value ) {
			echo '<div class="siteapi-bridge-single">';
			// $transient is an object so use -> to call children
			echo '</div>';
		}

		echo '</div>';
	}

}

