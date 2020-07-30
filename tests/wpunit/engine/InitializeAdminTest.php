<?php

namespace MZ_Mindbody_Classes\Tests\WPUnit;

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
		$classes[] = 'MZ_Mindbody_Classes\Backend\ActDeact';
		$classes[] = 'MZ_Mindbody_Classes\Backend\Enqueue';
		$classes[] = 'MZ_Mindbody_Classes\Backend\ImpExp';
		$classes[] = 'MZ_Mindbody_Classes\Backend\Notices';
		$classes[] = 'MZ_Mindbody_Classes\Backend\Pointers';
		$classes[] = 'MZ_Mindbody_Classes\Backend\Settings_Page';

		$this->assertTrue( is_admin() );
		$this->assertEquals( $classes, $sut->classes );
	}

}
