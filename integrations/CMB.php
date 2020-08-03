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
			'data-validation' => 'required',
			'type' => 'text_datetime_timestamp',
				)
            );


		$datetime = $cmb_elliptica_od_mb->add_field(
            array(
			'name' => __( 'ID of Video', MMC_TEXTDOMAIN ),
			'desc' => __( 'What you see at end of http address', MMC_TEXTDOMAIN ),
			'id'   => $prefix . MMC_TEXTDOMAIN . '_video_id',
			'data-validation' => 'required',
			'type' => 'text',
				)
            );

        $class_plan = $cmb_elliptica_od_mb->add_field( array(
			'id'          => $prefix . MMC_TEXTDOMAIN . '_classplan',
			'type'        => 'group',
			'description' => __( 'Generates reusable form entries', 'cmb2' ),
			'repeatable'  => true, // use false if you want non-repeatable group
			'options'     => array(
				'group_title'       => __( 'Segment {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
				'add_button'        => __( 'Add Another Segment', 'cmb2' ),
				'remove_button'     => __( 'Remove Segment', 'cmb2' ),
				'sortable'          => true,
				// 'closed'         => true, // true to have the groups closed by default
				'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
			),
		) );

		// Id's for group's fields only need to be unique for the group. Prefix is not needed.
		$cmb_elliptica_od_mb->add_group_field( $class_plan, array(
			'name' => 'Song Title',
			'id'   => 'song_title',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_elliptica_od_mb->add_group_field( $class_plan, array(
			'name' => 'Song Artists',
			'description' => 'Name(s)',
			'id'   => 'song_artists',
			'type' => 'text',
		) );

		$cmb_elliptica_od_mb->add_group_field( $class_plan, array(
			'name' => 'Song Artwork',
			'description' => 'Starts http:// or https://',
			'id'   => 'song_artwork',
			'type' => 'text',
		) );

		$cmb_elliptica_od_mb->add_group_field( $class_plan, array(
			'name' => 'Segment Type',
			'description' => 'What role does this segment play in the workout',
			'id'   => 'segment_type',
			'type' => 'text',
		) );

		$cmb_elliptica_od_mb->add_group_field( $class_plan, array(
			'name' => 'Segment Duration',
			'id'   => 'segment_duration',
			'type' => 'text',
			'description' => 'Just number, app adds "minutes".',
		) );


		$row->addColumns( array( $datetime ) );
		$row = $cmb2Grid->addRow(); //phpcs:ignore WordPress.NamingConventions
		$row->addColumns( array( $class_plan ) );
	}

}
