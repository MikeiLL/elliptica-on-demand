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

