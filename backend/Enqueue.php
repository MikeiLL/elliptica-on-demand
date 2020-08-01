<?php

/**
 * Intensity_On_Demand
 *
 * @package   Intensity_On_Demand
 * @author    Mike iLL <mike@mzoo.org>
 * @copyright 2020 mZoo.org
 * @license   GPL 2.0+
 * @link      http://mzoo.org
 */
namespace Intensity_On_Demand\Backend;

use \Intensity_On_Demand\Engine;

/**
 * This class contain the Enqueue stuff for the backend
 */
class Enqueue extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( !parent::initialize() ) {
            return;
		}

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}


	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {
		$admin_page = get_current_screen();
		if ( !is_null( $admin_page ) && $admin_page->id === 'toplevel_page_intensity-on-demand' ) {
			wp_enqueue_style( MMC_TEXTDOMAIN . '-settings-styles', plugins_url( 'assets/css/settings.css', MMC_PLUGIN_ABSOLUTE ), array( 'dashicons' ), MMC_VERSION );
		}

		wp_enqueue_style( MMC_TEXTDOMAIN . '-admin-styles', plugins_url( 'assets/css/admin.css', MMC_PLUGIN_ABSOLUTE ), array( 'dashicons' ), MMC_VERSION );
	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {
		$admin_page = get_current_screen();
        if ( !is_null( $admin_page ) && $admin_page->id === 'toplevel_page_intensity-on-demand' ) {
            wp_enqueue_script( MMC_TEXTDOMAIN . '-settings-script', plugins_url( 'assets/js/settings.js', MMC_PLUGIN_ABSOLUTE ), array( 'jquery', 'jquery-ui-tabs' ), MMC_VERSION, false );
        }

		wp_enqueue_script( MMC_TEXTDOMAIN . '-admin-script', plugins_url( 'assets/js/admin.js', MMC_PLUGIN_ABSOLUTE ), array( 'jquery' ), MMC_VERSION, false );
	}

}
