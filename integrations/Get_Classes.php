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

use MZ_Mindbody\Inc\Common\Interfaces as Interfaces;

class Get_Classes extends Interfaces\Retrieve_Classes {

	/**
	 * Return Time Frame for request to MBO API
	 *
	 * @since 1.0.0
	 *
	 * Default time_frame is two dates, start of current week as set in WP, and seven days from "now.
     *
     * @throws \Exception
	 *
	 * @return array of start and end dates as required for MBO API
	 */

    public function time_frame($timestamp = null){

    	$timestamp = isset($timestamp) ? $timestamp : current_time( 'timestamp' );
        $start_time = new \DateTime();
        $end_time = new \DateTime();
        $one_day = new \DateInterval('P1D');
        $four_weeks = new \DateInterval('P4W');
		$four_weeks->invert = 1; //
		$start_time->add($four_weeks);
		$end_time->add($one_day);

        // Set current_day_offset for filtering by sort_classes_by_date_then_time().
        $this->current_day_offset = $current_day_offset;

		// Assign start_date & end_date to instance so can be accessed in grid schedule display
        $this->start_date = $start_time;
        $this->current_week_end = $current_week_end;

		return array('StartDateTime'=> $start_time->format('Y-m-d'), 'EndDateTime'=> $end_time->format('Y-m-d'));
	}



}
