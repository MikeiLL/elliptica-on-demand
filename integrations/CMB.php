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
		add_action( 'cmb2_init', array( $this, 'cmb_elliptica_od_metaboxes' ) );
	}

	/**
	 * Your metabox on Demo CPT
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function cmb_elliptica_od_metaboxes() {
		// Start with an underscore to hide fields from custom fields list
		$prefix   = '_elliptica_od_';
		$cmb_elliptica_od_mb = new_cmb2_box(
            array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'On Demand Class Custom Fields', MMC_TEXTDOMAIN ),
			'object_types' => array( 'elliptica_od_video' ),
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true, // Show field names on the left
		)
            );
		$cmb2Grid = new Cmb2Grid( $cmb_elliptica_od_mb ); //phpcs:ignore WordPress.NamingConventions
		$row      = $cmb2Grid->addRow(); //phpcs:ignore WordPress.NamingConventions
		$datetime = $cmb_elliptica_od_mb->add_field(
            array(
			'name' => __( 'Date and Time of Class', MMC_TEXTDOMAIN ),
			'desc' => __( 'Searchable', MMC_TEXTDOMAIN ),
			'id'   => $prefix . MMC_TEXTDOMAIN . '_date',
			'type' => 'text_datetime_timestamp',
				)
            );

        $class_length = $cmb_elliptica_od_mb->add_field(
            array(
			'name' => __( 'Class Length', MMC_TEXTDOMAIN ),
			'desc' => __( 'Searchable', MMC_TEXTDOMAIN ),
			'id'   => $prefix . MMC_TEXTDOMAIN . '_length',
			'type' => 'text',
				)
            );

        $instructor = $cmb_elliptica_od_mb->add_field(
            array(
			'name' => __( 'Instructor', MMC_TEXTDOMAIN ),
			'desc' => __( 'Searchable', MMC_TEXTDOMAIN ),
			'id'   => $prefix . MMC_TEXTDOMAIN . '_instructor',
			'type' => 'text',
				)
            );

		$row->addColumns( array( $datetime, $class_length ) );
		$row = $cmb2Grid->addRow(); //phpcs:ignore WordPress.NamingConventions
		$row->addColumns( array( $instructor ) );
	}

}
