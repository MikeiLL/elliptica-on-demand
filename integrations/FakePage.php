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
namespace Elliptica_On_Demand\Integrations;

use \Elliptica_On_Demand\Engine;
use \Fake_Page as Fake_Page;

/**
 * Fake Pages inside WordPress
 */
class FakePage extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
        parent::initialize();
        new Fake_Page(
            array(
            'slug'         => 'fake_slug',
            'post_title'   => 'Fake Page Title',
            'post_content' => 'This is the fake page content',
            )
        );
    }

}

