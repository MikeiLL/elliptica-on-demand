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
namespace Intensity_On_Demand\Internals;

use \Intensity_On_Demand\Engine;

/**
 * Shortcodes of this plugin
 *
 */
class Shortcode extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();
        add_shortcode( 'mindbody-classes', array( $this, 'intensity_on_demand' ) );
	}

	/**
	 * Shortcode example
	 *
	 * @param array $atts Parameters.
	 *
	 * @since 1.0.0
	 *
	 * @SuppressWarnings(PHPMD)
	 *
	 * @return string
	 */
	public static function intensity_on_demand( $atts ) {
		shortcode_atts(
			array(
				'foo' => 'something',
				'bar' => 'something else',
			),
            $atts
		);



		echo "</pre>";

		return '<span class="foo">foo = ' . $atts[ 'foo' ] . '</span>' .
			'<span class="bar">bar = ' . $atts[ 'bar' ] . '</span>';
	}

}

