<?php

namespace MZ_Mindbody_Classes\Tests\WPUnit;

class InitializeTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @var string
	 */
	protected $root_dir;

	public function setUp() {
		parent::setUp();

		// your set up methods here
		$this->root_dir = dirname( dirname( dirname( __FILE__ ) ) );

        wp_set_current_user(0);
        wp_logout();
        wp_safe_redirect(wp_login_url());
	}

	public function tearDown() {
		parent::tearDown();
	}

	private function make_instance() {
		return new \Plugin_name\Engine\Initialize();
	}

	/**
	 * @test
	 * it should be instantiatable
	 */
	public function it_should_be_instantiatable() {
		$sut = $this->make_instance();
		$this->assertInstanceOf( '\\Plugin_name\\Engine\\Initialize', $sut );
	}

	/**
	 * @test
	 * it should be front
	 */
	public function it_should_be_front() {
		$sut = $this->make_instance();

		$classes   = array();
		$classes[] = 'MZ_Mindbody_Classes\Internals\PostTypes';
		$classes[] = 'MZ_Mindbody_Classes\Internals\Shortcode';
		$classes[] = 'MZ_Mindbody_Classes\Internals\Transient';
		$classes[] = 'MZ_Mindbody_Classes\Integrations\CMB';
		$classes[] = 'MZ_Mindbody_Classes\Integrations\Cron';
		$classes[] = 'MZ_Mindbody_Classes\Integrations\FakePage';
		$classes[] = 'MZ_Mindbody_Classes\Integrations\Template';
		$classes[] = 'MZ_Mindbody_Classes\Integrations\Widgets';
 		$classes[] = 'MZ_Mindbody_Classes\Ajax\Ajax';
 		$classes[] = 'MZ_Mindbody_Classes\Ajax\Ajax_Admin';
		$classes[] = 'MZ_Mindbody_Classes\Frontend\Enqueue';
		$classes[] = 'MZ_Mindbody_Classes\Frontend\extras\Body_Class';

		$this->assertEquals( $classes, $sut->classes );
	}

}
