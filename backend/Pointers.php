<?php

/**
 * MZ_Mindbody_Classes
 *
 * @package   MZ_Mindbody_Classes
 * @author    Mike iLL <mike@mzoo.org>
 * @copyright 2020 mZoo.org
 * @license   GPL 2.0+
 * @link      http://mzoo.org
 */
namespace MZ_Mindbody_Classes\Backend;

use \MZ_Mindbody_Classes\Engine;
use \PointerPlus as PointerPlus;

/**
 * All the WP pointers.
 */
class Pointers extends Engine\Base {

	/**
	 * Initialize the Pointers.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function initialize() {
        parent::initialize();
		new PointerPlus( array( 'prefix' => MMC_TEXTDOMAIN ) );
		add_filter( 'mz_mindbody_classes-pointerplus_list', array( $this, 'custom_initial_pointers' ), 10, 2 );
	}

	/**
	 * Add pointers.
	 * Check on https://github.com/Mte90/pointerplus/blob/master/pointerplus.php for examples
	 *
	 * @param array  $pointers The list of pointers.
	 * @param string $prefix   For your pointers.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed
	 */
	public function custom_initial_pointers( $pointers, $prefix ) {
		return array_merge(
			$pointers,
			array(
				$prefix . '_contextual_help' => array(
					'selector'   => '#show-settings-link',
					'title'      => __( 'Boilerplate Help', MMC_TEXTDOMAIN ),
					'text'       => __( 'A pointer for help tab.<br>Go to Posts, Pages or Users for other pointers.', MMC_TEXTDOMAIN ),
					'edge'       => 'top',
					'align'      => 'left',
					'icon_class' => 'dashicons-welcome-learn-more',
				),
			)
		);
	}

}
