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
namespace Elliptica_On_Demand\Ajax;

use Elliptica_On_Demand\Engine;

/**
 * AJAX in the public
 */
class Ajax extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! apply_filters( 'elliptica_on_demand_mmc_ajax_initialize', true ) ) {
			return;
		}

		add_action(
			'wp_ajax_get_videos_ajax_loop',
			array(
				$this,
				'get_videos_ajax_loop',
			)
		);
		add_action(
			'wp_ajax_nopriv_get_videos_ajax_loop',
			array(
				$this,
				'get_videos_ajax_loop',
			)
		);
	}

	public function get_videos_ajax_loop() {
		if ( ! isset( $_REQUEST['data'] ) || empty( $_REQUEST['data'] ) ) {
			wp_die();
		}

		$args = array();

		$prefix = '_elliptica_od_';

		$args['query']                   = new \WP_Query(
			array(
				'post_type'      => 'elliptica_od_video',
				'post_status'    => 'publish',
				'posts_per_page' => MMC_PAGINATED_SEGMENT_SIZE,
				'post__in'       => $_REQUEST['data'],
				'paged'          => $_REQUEST['paginated_segment_index'],
			)
		);
		$args['prefix']                  = $prefix;
		$args['paginated_segment_index'] = $_REQUEST['paginated_segment_index'];

		eod_get_template( 'videos_loop.php', $args );

		wp_die();
	}

}
