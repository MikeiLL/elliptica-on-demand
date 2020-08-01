<?php

namespace Intensity_On_Demand\Tests\WPUnit;

class InitializeAdminTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @var string
	 */
	protected $root_dir;

	public function setUp() {
		parent::setUp();

		// your set up methods here
		$this->root_dir = dirname( dirname( dirname( __FILE__ ) ) );

        // $user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		// $user = wp_set_current_user( $user_id );
		set_current_screen( 'edit.php' );
	}

	public function tearDown() {
		parent::tearDown();
	}

	private function make_instance() {
		return new \Plugin_name\Engine\Initialize();
	}

	/**
	 * @test
	 * it should be admin
	 */
	public function it_should_be_admin() {
		$sut = $this->make_instance();

		$classes   = array();
		$classes[] = 'Intensity_On_Demand\Internals\PostTypes';
		$classes[] = 'Intensity_On_Demand\Internals\Shortcode';
		$classes[] = 'Intensity_On_Demand\Internals\Transient';
		$classes[] = 'Intensity_On_Demand\Integrations\CMB';
		$classes[] = 'Intensity_On_Demand\Integrations\Cron';
		$classes[] = 'Intensity_On_Demand\Integrations\FakePage';
		$classes[] = 'Intensity_On_Demand\Integrations\Template';
		$classes[] = 'Intensity_On_Demand\Integrations\Widgets';
 		$classes[] = 'Intensity_On_Demand\Ajax\Ajax';
 		$classes[] = 'Intensity_On_Demand\Ajax\Ajax_Admin';
		$classes[] = 'Intensity_On_Demand\Backend\ActDeact';
		$classes[] = 'Intensity_On_Demand\Backend\Enqueue';
		$classes[] = 'Intensity_On_Demand\Backend\ImpExp';
		$classes[] = 'Intensity_On_Demand\Backend\Notices';
		$classes[] = 'Intensity_On_Demand\Backend\Pointers';
		$classes[] = 'Intensity_On_Demand\Backend\Settings_Page';

		$this->assertTrue( is_admin() );
		$this->assertEquals( $classes, $sut->classes );
	}

}
