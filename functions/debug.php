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


$mmc_debug = new WPBP_Debug( __( 'Elliptica On Demand', MMC_TEXTDOMAIN ) );

/**
 * Log text inside the debugging plugins.
 *
 * @param string $text The text.
 *
 * @return void
 */
function mmc_log( $text ) {
	global $mmc_debug;
	$mmc_debug->log( $text );
	$mmc_debug->qm_log( __( 'Error inside the log panel of Query Monitor', 'your-textdomain' ), 'error' );
	// $mmc_debug->qm_timer( 'profile_that_callback', function () { echo 'I need to be profiled!'; } );
}
