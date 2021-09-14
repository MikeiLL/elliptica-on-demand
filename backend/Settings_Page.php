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
namespace Elliptica_On_Demand\Backend;

use \Elliptica_On_Demand\Engine;

/**
 * Create the settings page in the backend
 */
class Settings_Page extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! parent::initialize() ) {
			return;
		}

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . MMC_TEXTDOMAIN . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_plugin_admin_menu() {
		/*
		 * Add a settings page for this plugin to the Settings menu
		 *
		 * @TODO:
		 *
		 * - Change 'manage_options' to the capability you see fit
		 *   For reference: http://codex.wordpress.org/Roles_and_Capabilities

		 add_options_page( __( 'Page Title', MMC_TEXTDOMAIN ), MMC_NAME, 'manage_options', MMC_TEXTDOMAIN, array( $this, 'display_plugin_admin_page' ) );
		 *
		 */
		/*
		 * Add a settings page for this plugin to the main menu
		 *
		 */
		// add_menu_page( __( 'Elliptica On Demand Settings', MMC_TEXTDOMAIN ), MMC_NAME, 'manage_options', MMC_TEXTDOMAIN, array( $this, 'display_plugin_admin_page' ), 'dashicons-hammer', 90 );
		/*
		 Retrieve settings in front end:
		 *  $eod_options = cmb2_get_option( MMC_TEXTDOMAIN . '-settings', 'videos_per_segment', 'default one' );
		 *  $opts = get_option( MMC_TEXTDOMAIN . '-settings', 'default too' );
		 */

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_plugin_admin_page() {
		include_once MMC_PLUGIN_ROOT . 'backend/views/admin.php';
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since 1.0.0
	 *
	 * @param array $links Array of links.
	 *
	 * @return array
	 */
	public function add_action_links( $links ) {
		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . MMC_TEXTDOMAIN ) . '">' . __( 'Settings', MMC_TEXTDOMAIN ) . '</a>',
				'donate'   => '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=mike@mzoo.org&item_name=Donation">' . __( 'Donate', MMC_TEXTDOMAIN ) . '</a>',
			),
			$links
		);
	}

}
