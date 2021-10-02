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
use \WP_Error as WP_Error;

/**
 * Provide Import and Export of the settings of the plugin
 *
 * @SuppressWarnings(PHPMD)
 */
class ImpExp extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		if ( ! parent::initialize() ) {
			return;
		}

		// Add the export settings method
		add_action( 'admin_init', array( $this, 'settings_export' ) );
		// Add the import settings method
		add_action( 'admin_init', array( $this, 'settings_import' ) );
	}

	/**
	 * Process a settings export from config
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function settings_export() {
		if ( empty( $_POST['mmc_action'] ) || 'export_settings' !== sanitize_text_field( wp_unslash( $_POST['mmc_action'] ) ) ) { //phpcs:ignore WordPress.Security.NonceVerification
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mmc_export_nonce'] ) ), 'mmc_export_nonce' ) ) { //phpcs:ignore WordPress.Security.ValidatedSanitizedInput
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$settings    = array();
		$settings[0] = get_option( MMC_TEXTDOMAIN . '-settings' );
		$settings[1] = get_option( MMC_TEXTDOMAIN . '-settings-second' );

		ignore_user_abort( true );

		nocache_headers();
		header( 'Content-Type: application/json; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=elliptica_on_demand-settings-export-' . gmdate( 'm-d-Y' ) . '.json' );
		header( 'Expires: 0' );

		echo wp_json_encode( $settings, JSON_PRETTY_PRINT );

		exit;
	}

	/**
	 * Process a settings import from a json file
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function settings_import() {
		if ( empty( $_POST['mmc_action'] ) || 'import_settings' !== sanitize_text_field( wp_unslash( $_POST['mmc_action'] ) ) ) { //phpcs:ignore WordPress.Security.NonceVerification
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mmc_import_nonce'] ) ), 'mmc_import_nonce' ) ) { //phpcs:ignore WordPress.Security.ValidatedSanitizedInput
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$extension = end( explode( '.', $_FILES['mmc_import_file']['name'] ) ); //phpcs:ignore WordPress.Security.ValidatedSanitizedInput

		if ( $extension !== 'json' ) {
			wp_die( esc_html__( 'Please upload a valid .json file', MMC_TEXTDOMAIN ) );
		}

		$import_file = $_FILES['mmc_import_file']['tmp_name']; //phpcs:ignore WordPress.Security.ValidatedSanitizedInput

		if ( empty( $import_file ) ) {
			wp_die( esc_html__( 'Please upload a file to import', MMC_TEXTDOMAIN ) );
		}

		// Retrieve the settings from the file and convert the json object to an array.
		$settings_file = file_get_contents( $import_file );// phpcs:ignore
		if ( ! $settings_file ) {
			$settings = json_decode( (string) $settings_file );

			update_option( MMC_TEXTDOMAIN . '-settings', get_object_vars( $settings[0] ) );
			update_option( MMC_TEXTDOMAIN . '-settings-second', get_object_vars( $settings[1] ) );

			wp_safe_redirect( admin_url( 'options-general.php?page=' . MMC_TEXTDOMAIN ) );
			exit;
		}

		new WP_Error(
			'elliptica_on_demand_import_settings_failed',
			__( 'Failed to import the settings.', MMC_TEXTDOMAIN )
		);

	}

}
