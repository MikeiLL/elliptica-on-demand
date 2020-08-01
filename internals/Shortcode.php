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
use \Intensity_On_Demand\Integrations as Integrations;

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
        add_shortcode( 'mindbody-classes', array( $this, 'mindbody_classes' ) );
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
	public static function mindbody_classes( $atts ) {
		shortcode_atts(
			array(
				'foo' => 'something',
				'bar' => 'something else',
			),
            $atts
		);

		$mbo_schedule = new Integrations\Get_Classes;
        // Call the API and if fails, return error message.
        if (false == $mbo_schedule->get_mbo_results(null, false)) echo "<div>" . __("Error returning schedule from MBO for display.", 'mz-mindbody-api') . "</div>";
		echo "<pre>";
		foreach($mbo_schedule->classes as $class){
			if ($class['ClassDescription']['Program']['Name'] == 'Virtual Classes'){
				$class_start = new \DateTime($class['StartDateTime']);
				$class_end = new \DateTime($class['EndDateTime']);
				$class_duration = $class_start->diff($class_end);
				print_r([
					'name' => $class['ClassDescription']['Name'],
					'staff' => $class['Staff']['Name'],
					'start' => $class_start,
					'end' => $class_end,
					'duration' => $class_duration,
				]);
			}

		}

		echo "</pre>";

		return '<span class="foo">foo = ' . $atts[ 'foo' ] . '</span>' .
			'<span class="bar">bar = ' . $atts[ 'bar' ] . '</span>';
	}

}

