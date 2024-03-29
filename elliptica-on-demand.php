<?php

/**
 *
 * @package   Elliptica_On_Demand
 * @author    Mike iLL <mike@mzoo.org>
 * @copyright 2020 mZoo.org
 * @license   GPL 2.0+
 * @link      http://mzoo.org
 *
 * Plugin Name:     Elliptica On Demand
 * Plugin URI:      https://mzoo.org
 * Description:     Archive and display video classes for Elliptica Studios.
 * Version:         1.0.6
 * Author:          Mike iLL
 * Author URI:      http://mzoo.org
 * Text Domain:     elliptica-on-demand
 * License:         GPL 2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:     /languages
 * Requires PHP:    7.2
 * WordPress-Plugin-Boilerplate-Powered: v3.2.0
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'We\'re sorry, but you can not directly access this file.' );
}

define( 'MMC_VERSION', '1.0.6' );
define( 'MMC_TEXTDOMAIN', 'elliptica-on-demand' );
define( 'MMC_NAME', 'Elliptica On Demand' );
define( 'MMC_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
define( 'BEDROCK_SITE_ROOT', '/srv/www/ellipticastudios.com/current/' );
define( 'MMC_PLUGIN_ABSOLUTE', __FILE__ );
define( 'MMC_MIN_PHP_VERSION', 7.2 );
define( 'MMC_MIN_WP_VERSION', 5.3 );
define( 'MMC_PAGINATED_SEGMENT_SIZE', 21 );

add_action(
	'init',
	function () {
			load_plugin_textdomain( MMC_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
);


if ( version_compare( PHP_VERSION, MMC_MIN_PHP_VERSION, '<=' ) ) {
	add_action(
		'admin_init',
		function() {
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
	);

	add_action(
		'admin_notices',
		function() {
			echo wp_kses_post(
				sprintf(
					'<div class="notice notice-error"><p>%s</p></div>',
					__( MMC_NAME . 'requires PHP ' . MMC_MIN_PHP_VERSION . ' or newer.', MMC_TEXTDOMAIN )
				)
			);
		}
	);

	// Return early to prevent loading the plugin.
	return;
}

$elliptica_on_demand_libraries = include 'vendor/autoload.php';

require_once MMC_PLUGIN_ROOT . 'functions/functions.php';
require_once MMC_PLUGIN_ROOT . 'functions/debug.php';

$requirements = new \Micropackage\Requirements\Requirements(
	MMC_NAME,
	array(
		'php'            => MMC_MIN_PHP_VERSION,
		'php_extensions' => array( 'mbstring' ),
		'wp'             => MMC_MIN_WP_VERSION,
			// 'plugins'            => array(
			// array( 'file' => 'mz-mindbody-api/mz-mindbody.php', 'name' => 'MZ Mindbody API', 'version' => '1.5' )
			// ),
	)
);
if ( ! $requirements->satisfied() ) {
	$requirements->print_notice();
	return;
}

if ( ! wp_installing() ) {
	add_action(
		'plugins_loaded',
		function () use ( $elliptica_on_demand_libraries ) {
			new \Elliptica_On_Demand\Engine\Initialize( $elliptica_on_demand_libraries );
		}
	);
}
