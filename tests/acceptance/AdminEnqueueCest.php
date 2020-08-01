<?php
/**
 * AdminEnqueueCest
 *
 * @SuppressWarnings(PHPMD)
 */
class AdminEnqueueCest {

	function _before(AcceptanceTester $I) {
		// will be executed at the beginning of each test
		$I->loginAsAdmin();
		$I->am('administrator');
	}

	function enqueue_admin_scripts(AcceptanceTester $I) {
		$I->wantTo('access to the plugin settings page and check the scripts enqueue');
		$I->amOnPage('/wp-admin/admin.php?page=elliptica-on-demand');
		$I->seeInPageSource('elliptica-on-demand-settings-script');
		$I->seeInPageSource('elliptica-on-demand-admin-script');
	}

	function enqueue_admin_styles(AcceptanceTester $I) {
		$I->wantTo('access to the plugin settings page and check the style enqueue');
		$I->amOnPage('/wp-admin/admin.php?page=elliptica-on-demand');
		$I->seeInPageSource('elliptica-on-demand-settings-styles-css');
		$I->seeInPageSource('elliptica-on-demand-admin-styles-css');
	}

}
