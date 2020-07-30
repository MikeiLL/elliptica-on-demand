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
namespace MZ_Mindbody_Classes\Engine;

/**
 * Base skeleton of the plugin
 */
class Base {

	/**
	 * @var array The settings of the plugin
	 */
	public $settings = array();

	/**
	 * Initialize the class
	 */
	public function initialize() {
		$this->settings = mmc_get_settings();
		return true;
	}

}
