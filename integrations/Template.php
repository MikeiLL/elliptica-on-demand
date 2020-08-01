<?php

/**
 * Intensity_On_Demand
 *
 * @package   Intensity_On_Demand
 * @author    Mike iLL <mike@mzoo.org>
 * @copyright 2020 mZoo.org
 * @license   GPL 2.0+
 * @link      http://mzoo.org
 */
namespace Intensity_On_Demand\Integrations;

use \Intensity_On_Demand\Engine;

/**
 * Load custom template files
 */
class Template extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
        parent::initialize();

		// Override the template hierarchy for load /templates/content-demo.php
		add_filter( 'template_include', array( __CLASS__, 'load_content_demo' ) );
	}

	/**
	 * Example for override the template system on the frontend
	 *
	 * @param string $original_template The original templace HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function load_content_demo( $original_template ) {
		if ( is_singular( 'demo' ) && in_the_loop() ) {
			return wpbp_get_template_part( MMC_TEXTDOMAIN, 'content', 'demo', false );
		}

		return $original_template;
	}

}
