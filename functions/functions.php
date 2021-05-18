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

/**
 * Get the settings of the plugin in a filterable way
 *
 * @since 1.0.0
 *
 * @return array
 */
function mmc_get_settings() {
	return apply_filters( 'mmc_get_settings', get_option( MMC_TEXTDOMAIN . '-settings' ) );
}

/**
 * Minimize and Sum Class Plans
 *
 * @param array @class_plans from Custom Field, which contain some fields we don't need,
 * as well as unknown time format. We also want to sum times for concurrent, matching
 * Segment Types:
 *
 * warmup: 4, torture: 5, torture: 9
 *
 * becomes: warmup: 4, torture: 14
 *
 * return array @minimized_class_plan
 */
function minimize_and_sum_class_plans($class_plans = []) {

	if (empty($class_plans)) return false;

	if (is_array($class_plans[0]) && !empty($class_plans[0])) {

		$segments_only = array_map( function ($array){
			$allowed  = ['segment_duration', 'segment_type'];
			$segment_info = array_filter($array,
				function ($key) use ($allowed) {
					return in_array($key, $allowed);
				},
				ARRAY_FILTER_USE_KEY
			);

			array_walk($segment_info, function(&$item, $key){
				if ($key === 'segment_duration') {
					$seconds = '00';
					$minutes = $item;
					if (strpos($item, ":")) {
						$seconds = substr($item, strpos($item, ":") + 1);
						$minutes = substr($item, 0, strpos($item, ":"));
					}
					$rounded = date('i', round(strtotime('00:' . $minutes . ':' . $seconds)/60)*60);
					$item = intval($rounded);
				}
			});

			return $segment_info;

		}, $class_plans[0] );

		// Now let's concatenate the subsequent occurences of matching keys
		$minimized_class_plan = [];
		foreach ($segments_only as $key => $val) {
			if ( !empty($prev_seg_type) && $prev_seg_type == $val['segment_type']) {
				// Remove the previous one, and add new one with summed duration.
				array_pop($minimized_class_plan);
				$minimized_class_plan[] = [
					'segment_type' => $val['segment_type'],
					'segment_duration' => $val['segment_duration'] + $prev_seg_duration
				];
				$prev_seg_type = $val['segment_type'];
				$prev_seg_duration = $val['segment_duration'];
				continue;
			}
			$minimized_class_plan[] = [
				'segment_type' => $val['segment_type'],
				'segment_duration' => $val['segment_duration']
			];
			$prev_seg_type = $val['segment_type'];
			$prev_seg_duration = $val['segment_duration'];
		}

		return $minimized_class_plan;

	}
}
/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/elliptica/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/plugin-dir/templates/$template_name.
 *
 * @since 1.0.0
 *
 * @param 	string 	$template_name			Template to load.
 * @param 	string 	$string $template_path	Path to templates.
 * @param 	string	$default_path			Default path to template files.
 * @return 	string 							Path to the template file.
 */
function eod_locate_template( $template_name, $template_path = '', $default_path = '' ) {
    // Set variable to search in woocommerce-plugin-templates folder of theme.
    if ( ! $template_path ) :
    $template_path = 'elliptica/';
    endif;
    // Set default plugin templates path.
    if ( ! $default_path ) :
    $default_path = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/'; // Path to the template folder
    endif;
    // Search template file in theme folder.
    $template = locate_template( array(
        $template_path . $template_name,
        $template_name
    ) );
    // Get plugins template file.
    if ( ! $template ) :
    $template = $default_path . $template_name;
    endif;
    return apply_filters( 'eod_locate_template', $template, $template_name, $template_path, $default_path );
}
/**
 * Get template.
 *
 * Search for the template and include the file.
 *
 * @since 1.0.0
 *
 * @see eod_locate_template()
 *
 * @param string 	$template_name			Template to load.
 * @param array 	$args					Args passed for the template file.
 * @param string 	$string $template_path	Path to templates.
 * @param string	$default_path			Default path to template files.
 */
function eod_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
    if ( is_array( $args ) && isset( $args ) ) :
    extract( $args );
    endif;
    $template_file = eod_locate_template( $template_name, $tempate_path, $default_path );
    if ( ! file_exists( $template_file ) ) :
    _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
    return;
    endif;
    include $template_file;
}



