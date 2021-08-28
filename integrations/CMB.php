<?php

/**
 * Elliptica_On_Demand
 *
 * @package   Elliptica_On_Demand
 * @author    Mike iLL <mike@mzoo.org>
 * @copyright 2020 mZoo.org
 * @license   GPL 2.0+
 * @link      http://mzoo.org
 *
 */
namespace Elliptica_On_Demand\Integrations;

use \Elliptica_On_Demand\Engine;
use \Cmb2Grid\Grid\Cmb2Grid as Cmb2Grid;

/**
 * All the CMB related code.
 */
class CMB extends Engine\Base {

	/**
	 * Custom metabox object
	 */
	private $cmb_elliptica_od_mb;

	/**
	 * Metabox prefix.
	 */
	private $prefix;

	/**
	 * Custom metabox grid object.
	 */
	private $cmb2Grid;

	/**
	 * Class plan.
	 */
	private $class_plan;

	/**
	 * Initialize class.
	 *
	 * @since 1.0.0
	 */
	public function initialize() {
		parent::initialize();
		require_once WP_PLUGIN_DIR . '/cmb2/init.php';
		require_once WP_PLUGIN_DIR . '/cmb2-grid/Cmb2GridPluginLoad.php';

		// Start prefix with underscore to hide fields from custom fields list
		$this->prefix	= '_elliptica_od_';

		add_action( 'cmb2_init', array( $this, 'cmb_elliptica_od_metaboxes' ) );
	}

	/**
	 * Elliptica On Demand Metaboxes
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function cmb_elliptica_od_metaboxes() {

		$this->cmb_elliptica_od_mb = new_cmb2_box(
			array(
				'id'           => $this->prefix . 'metabox',
				'title'        => __( 'On Demand Class Custom Fields', MMC_TEXTDOMAIN ),
				'object_types' => array( 'elliptica_od_video' ),
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true, // Show field names on the left
			)
		);

		$this->cmb2Grid = new Cmb2Grid( $this->cmb_elliptica_od_mb ); //phpcs:ignore WordPress.NamingConventions

		$datetime = $this->cmb_elliptica_od_mb->add_field(
			array(
				'name'            => __( 'Date and Time of Class', MMC_TEXTDOMAIN ),
				'desc'            => __( 'Searchable', MMC_TEXTDOMAIN ),
				'id'              => $this->prefix . MMC_TEXTDOMAIN . '_date',
				'data-validation' => 'required',
				'type'            => 'text_datetime_timestamp',
			)
		);

		$id_of_video = $this->cmb_elliptica_od_mb->add_field(
			array(
				'name'            => __( 'ID of Video', MMC_TEXTDOMAIN ),
				'desc'            => __( 'What you see at end of http address', MMC_TEXTDOMAIN ),
				'id'              => $this->prefix . MMC_TEXTDOMAIN . '_video_id',
				'data-validation' => 'required',
				'type'            => 'text',
			)
		);

		$short_description = $this->cmb_elliptica_od_mb->add_field(
			array(
				'name'            => __( 'Short Description', MMC_TEXTDOMAIN ),
				'desc'            => __( 'No longer than a sentence, please.', MMC_TEXTDOMAIN ),
				'id'              => $this->prefix . MMC_TEXTDOMAIN . '_desc',
				'data-validation' => 'required',
				'type'            => 'text',
			)
		);

		$class_type = $this->cmb_elliptica_od_mb->add_field(
			array(
				'name'            => __( 'Class Type', MMC_TEXTDOMAIN ),
				'desc'            => __( 'Gym Class, etc...', MMC_TEXTDOMAIN ),
				'id'              => $this->prefix . MMC_TEXTDOMAIN . '_class_type',
				'data-validation' => 'required',
				'type'            => 'text',
			)
		);

		$this->class_plan = $this->cmb_elliptica_od_mb->add_field(
			array(
				'id'          => $this->prefix . MMC_TEXTDOMAIN . '_classplan',
				'type'        => 'group',
				'description' => __( 'Generates reusable form entries', 'cmb2' ),
				'repeatable'  => true, // use false if you want non-repeatable group
				'options'     => array(
					'group_title'    => __( 'Segment {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
					'add_button'     => __( 'Add Another Segment', 'cmb2' ),
					'remove_button'  => __( 'Remove Segment', 'cmb2' ),
					'sortable'       => true,
					// 'closed'         => true, // true to have the groups closed by default
					'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
				),
			)
		);

		$this->add_group_fields();

		$row = $this->cmb2Grid->addRow(); //phpcs:ignore WordPress.NamingConventions
		$row->addColumns( array( $datetime, $id_of_video ) );
		$row = $this->cmb2Grid->addRow(); //phpcs:ignore WordPress.NamingConventions
		$row->addColumns( array( $short_description, $class_type ) );
		$row = $this->cmb2Grid->addRow(); //phpcs:ignore WordPress.NamingConventions
		$row->addColumns( array( $this->class_plan ) );
	}

	/**
	 * Add Group Fields
	 * @since 1.0.6
	 */
	private function add_group_fields(){

		$class_plan = $this->class_plan;

		// Id's for group's fields only need to be unique for the group. Prefix is not needed.
		$this->cmb_elliptica_od_mb->add_group_field(
			$class_plan,
			array(
				'name' => 'Song Title',
				'id'   => 'song_title',
				'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
			)
		);

		$this->cmb_elliptica_od_mb->add_group_field(
			$class_plan,
			array(
				'name'        => 'Song Artists',
				'description' => 'Name(s)',
				'id'          => 'song_artists',
				'type'        => 'text',
			)
		);

		$this->cmb_elliptica_od_mb->add_group_field(
			$class_plan,
			array(
				'name'        => 'Song Artwork',
				'description' => 'Starts http:// or https://',
				'id'          => 'song_artwork',
				'type'        => 'text',
			)
		);

		$this->cmb_elliptica_od_mb->add_group_field(
			$class_plan,
			array(
				'name'        => 'Segment Type',
				'description' => 'What role does this segment play in the workout',
				'id'          => 'segment_type',
				'type'        => 'text',
			)
		);

		$this->cmb_elliptica_od_mb->add_group_field(
			$class_plan,
			array(
				'name'        => 'Segment Duration',
				'id'          => 'segment_duration',
				'type'        => 'text',
				'description' => 'Just number, app adds "minutes".',
			)
		);
	}

}
