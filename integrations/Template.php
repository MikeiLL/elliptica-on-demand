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
namespace Elliptica_On_Demand\Integrations;

use \Elliptica_On_Demand\Engine;

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
		// add_filter( 'template_include', array( __CLASS__, 'load_content_od_video' ) );
		add_filter( 'single_template', array( __CLASS__, 'load_single_od_video' ) );
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
	public static function load_content_od_video( $original_template ) {
		if ( is_singular( 'elliptica_od_video' ) && in_the_loop() ) {
			return wpbp_get_template_part( MMC_TEXTDOMAIN, 'content', 'ondemand', false );
		}

		return $original_template;
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
	public static function load_single_od_video( $single_template ) {
		global $post;

		if ( 'elliptica_od_video' === $post->post_type ) {
				return wpbp_get_template_part( MMC_TEXTDOMAIN, 'single', 'ondemand', false );
		}

		return $single_template;
	}

}
