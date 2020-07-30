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
namespace MZ_Mindbody_Classes\Integrations;

use \MZ_Mindbody_Classes\Engine;
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

