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
namespace Elliptica_On_Demand\Cli;

use \Elliptica_On_Demand\Engine;
use \WP_CLI as WP_CLI;

if ( defined( 'WP_CLI' ) && WP_CLI ) {

	/**
     * WP CLI command example
     */
    class Example extends Engine\Base {

    	private $wp_cli;

		/**
         * Initialize the class.
         *
         * @return void
         */
        public function initialize() {
            if ( !apply_filters( 'intensity_on_demand_mmc_enqueue_admin_initialize', true ) ) {
                return;
            }

            parent::initialize();
		}

        /**
         * Initialize the commands
         *
         * @since 1.0.0
         *
         * @return void
         */
        public function __construct() {
        	$this->wp_cli = new WP_CLI;
            $this->wp_cli->add_command( 'mmc_commandname', array( $this, 'command_example' ) );
        }

        /**
         * Example command
		 * API reference: https://wp-cli.org/docs/internal-api/
         *
         * @since 1.0.0
         *
		 * @param array $args The attributes.
		 *
		 * @return void
		 */
		public function command_example( $args ) {
			// Message prefixed with "Success: ".
			$this->wp_cli->success( $args[0] );
			// Message prefixed with "Warning: ".
			$this->wp_cli->warning( $args[0] );
			// Message prefixed with "Debug: ". when '--debug' is used
			$this->wp_cli->debug( $args[0] );
			// Message prefixed with "Error: ".
			$this->wp_cli->error( $args[0] );
			// Message with no prefix
			$this->wp_cli->log( $args[0] );
			// Colorize a string for output
			$this->wp_cli->colorize( $args[0] );
			// Halt script execution with a specific return code
			$this->wp_cli->halt( $args[0] );
		}

	}

}
