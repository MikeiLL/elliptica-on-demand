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
 * Plugin URI:      @TODO
 * Description:     @TODO
 * Version:         1.0.0
 * Author:          Mike iLL
 * Author URI:      http://mzoo.org
 * Text Domain:     intensity-on-demand
 * License:         GPL 2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:     /languages
 * Requires PHP:    7.2
 * WordPress-Plugin-Boilerplate-Powered: v3.2.0
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
	die( 'We\'re sorry, but you can not directly access this file.' );
}

define( 'MMC_VERSION', '1.0.0' );
define( 'MMC_TEXTDOMAIN', 'intensity-on-demand' );
define( 'MMC_NAME', 'Elliptica On Demand' );
define( 'MMC_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
define( 'MMC_PLUGIN_ABSOLUTE', __FILE__ );
define( 'MMC_MIN_PHP_VERSION', 7.2 );
define( 'MMC_MIN_WP_VERSION',  5.3 );

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

$intensity_on_demand_libraries = require_once MMC_PLUGIN_ROOT . 'vendor/autoload.php';

require_once MMC_PLUGIN_ROOT . 'functions/functions.php';
require_once MMC_PLUGIN_ROOT . 'functions/debug.php';

// Add your new plugin on the wiki: https://github.com/WPBP/WordPress-Plugin-Boilerplate-Powered/wiki/Plugin-made-with-this-Boilerplate

$requirements = new \Micropackage\Requirements\Requirements(
			MMC_NAME,
			array(
			'php'            => MMC_MIN_PHP_VERSION,
			'php_extensions' => array( 'mbstring' ),
			'wp'             => MMC_MIN_WP_VERSION,
			// 'plugins'            => array(
			// 	array( 'file' => 'mz-mindbody-api/mz-mindbody.php', 'name' => 'MZ Mindbody API', 'version' => '1.5' )
			// ),
		)
    );
if ( ! $requirements->satisfied() ) {
	$requirements->print_notice();
	return;
}


/**
 * Create a helper function for easy SDK access.
 *
 * @global type $mmc_fs
 * @return object
 */
function mmc_fs() {
	global $mmc_fs;

	if ( !isset( $mmc_fs ) ) {
		require_once MMC_PLUGIN_ROOT . 'vendor/freemius/wordpress-sdk/start.php';
		$mmc_fs = fs_dynamic_init(
			array(
				'id'             => '',
				'slug'           => 'intensity-on-demand',
				'public_key'     => '',
				'is_live'        => false,
				'is_premium'     => true,
				'has_addons'     => false,
				'has_paid_plans' => true,
				'menu'           => array(
					'slug' => 'intensity-on-demand',
				),
			)
		);


		if ( $mmc_fs->is_premium() ) {
			$mmc_fs->add_filter(
                'support_forum_url',
                function( $wp_org_support_forum_url ) {
					return $wp_org_support_forum_url . 'http://your url';
				}
            );
		}
	}

	return $mmc_fs;
}

// mmc_fs();

// Documentation to integrate GitHub, GitLab or BitBucket https://github.com/YahnisElsts/plugin-update-checker/blob/master/README.md
$my_update_checker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/git@github.com:MikeiLL/intensity-on-demand',
	__FILE__,
	'intensity-on-demand'
);

if ( ! wp_installing() ) {
	add_action(
        'plugins_loaded',
        function () use ( $intensity_on_demand_libraries ) {
			new \Elliptica_On_Demand\Engine\Initialize( $intensity_on_demand_libraries );
		}
    );
}
