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
namespace MZ_Mindbody_Classes\Integrations;

use \MZ_Mindbody_Classes\Engine;
use \Cmb2Grid\Grid\Cmb2Grid as Cmb2Grid;

/**
 * All the CMB related code.
 */
class CMB extends Engine\Base {

	/**
	 * Initialize class.
	 *
	 * @since 1.0.0
	 */
	public function initialize() {
        parent::initialize();
		require_once MMC_PLUGIN_ROOT . 'vendor/cmb2/init.php';
		require_once MMC_PLUGIN_ROOT . 'vendor/cmb2-grid/Cmb2GridPluginLoad.php';
		add_action( 'cmb2_init', array( $this, 'cmb_demo_metaboxes' ) );
	}

	/**
	 * Your metabox on Demo CPT
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function cmb_demo_metaboxes() {
		// Start with an underscore to hide fields from custom fields list
		$prefix   = '_demo_';
		$cmb_demo = new_cmb2_box(
            array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Demo Metabox', MMC_TEXTDOMAIN ),
			'object_types' => array( 'demo' ),
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true, // Show field names on the left
		)
            );
		$cmb2Grid = new Cmb2Grid( $cmb_demo ); //phpcs:ignore WordPress.NamingConventions
		$row      = $cmb2Grid->addRow(); //phpcs:ignore WordPress.NamingConventions
		$field1 = $cmb_demo->add_field(
            array(
			'name' => __( 'Text', MMC_TEXTDOMAIN ),
			'desc' => __( 'field description (optional)', MMC_TEXTDOMAIN ),
			'id'   => $prefix . MMC_TEXTDOMAIN . '_text',
			'type' => 'text',
				)
            );
		$field2 = $cmb_demo->add_field(
            array(
			'name' => __( 'Text 2', MMC_TEXTDOMAIN ),
			'desc' => __( 'field description (optional)', MMC_TEXTDOMAIN ),
			'id'   => $prefix . MMC_TEXTDOMAIN . '_text2',
			'type' => 'text',
				)
            );

		$field3 = $cmb_demo->add_field(
            array(
			'name' => __( 'Text Small', MMC_TEXTDOMAIN ),
			'desc' => __( 'field description (optional)', MMC_TEXTDOMAIN ),
			'id'   => $prefix . MMC_TEXTDOMAIN . '_textsmall',
			'type' => 'text_small',
				)
            );
		$field4 = $cmb_demo->add_field(
            array(
			'name' => __( 'Text Small 2', MMC_TEXTDOMAIN ),
			'desc' => __( 'field description (optional)', MMC_TEXTDOMAIN ),
			'id'   => $prefix . MMC_TEXTDOMAIN . '_textsmall2',
			'type' => 'text_small',
		)
            );
		$row->addColumns( array( $field1, $field2 ) );
		$row = $cmb2Grid->addRow(); //phpcs:ignore WordPress.NamingConventions
		$row->addColumns( array( $field3, $field4 ) );
	}

}
