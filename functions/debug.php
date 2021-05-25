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

/**
 * Helper function to write strings or arrays to a file.
 *
 * @since 1.0.0
 *
 * @param mixed  $message string|array|object the content to be written to file.
 * @param string $file_path optional path to write file to.
 */
function mmc_log_text( $message, $file_path = '' ) {
	$file_path = '/srv/www/ellipticastudios.com/shared/eod_arbitrary.log';
	$header    = gmdate( 'l dS \o\f F Y h:i:s A', strtotime( 'now' ) ) . "\t ";

	// Just keep up to seven days worth of data.
	if ( file_exists( $file_path ) ) {
		if ( time() - filemtime( $file_path ) >= 60 * 60 * 24 * 7 ) { // 7 days.
			unlink( $file_path );
		}
	}

	if ( is_array( $message ) || is_object( $message ) ) {
		$message = print_r( $message, true );
	}
	$message .= "\n";
	file_put_contents(
		$file_path,
		$header . $message,
		FILE_APPEND | LOCK_EX
	);
}

