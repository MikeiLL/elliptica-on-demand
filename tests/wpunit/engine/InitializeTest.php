<?php

namespace Elliptica_On_Demand\Tests\WPUnit;

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
		$classes[] = 'Elliptica_On_Demand\Internals\PostTypes';
		$classes[] = 'Elliptica_On_Demand\Internals\Shortcode';
		$classes[] = 'Elliptica_On_Demand\Internals\Transient';
		$classes[] = 'Elliptica_On_Demand\Internals\InitRest';
		$classes[] = 'Elliptica_On_Demand\Integrations\CMB';
		$classes[] = 'Elliptica_On_Demand\Integrations\Cron';
		$classes[] = 'Elliptica_On_Demand\Integrations\FakePage';
		$classes[] = 'Elliptica_On_Demand\Integrations\Template';
		$classes[] = 'Elliptica_On_Demand\Integrations\Widgets';
 		$classes[] = 'Elliptica_On_Demand\Ajax\Ajax';
 		$classes[] = 'Elliptica_On_Demand\Ajax\Ajax_Admin';
		$classes[] = 'Elliptica_On_Demand\Frontend\Enqueue';
		$classes[] = 'Elliptica_On_Demand\Frontend\extras\Body_Class';

		$this->assertEquals( $classes, $sut->classes );
	}

}
