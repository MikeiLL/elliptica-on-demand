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
namespace MZ_Mindbody_Classes\Internals;

use \MZ_Mindbody_Classes\Engine;

/**
 * Shortcodes of this plugin
 */
class Shortcode extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();
        add_shortcode( 'mindbody-classes', array( $this, 'mindbody_classes' ) );
	}

	/**
	 * Shortcode example
	 *
	 * @param array $atts Parameters.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function mindbody_classes( $atts ) {
		shortcode_atts(
			array(
				'foo' => 'something',
				'bar' => 'something else',
			),
            $atts
		);

		return '<span class="foo">foo = ' . $atts[ 'foo' ] . '</span>' .
			'<span class="bar">bar = ' . $atts[ 'bar' ] . '</span>';
	}

}

