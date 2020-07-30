<?php
/**
 * AdminSettingsPageCest
 *
 * @SuppressWarnings(PHPMD)
 */
class AdminSettingsPageCest {
    function _before(AcceptanceTester $I) {
        // will be executed at the beginning of each test
		$I->loginAsAdmin();
		$I->am('administrator');
    }

    function add_plugin_admin_menu(AcceptanceTester $I) {
		$I->wantTo('access to the plugin settings page as admin');
        $I->amOnPage('/wp-admin/admin.php?page=mz-mindbody-classes');
        $I->see('Plugin Name Settings', 'h2');
    }

    function add_action_link(AcceptanceTester $I) {
		$I->wantTo('check plugin list page if include mine');
        $I->amOnPluginsPage();
        $I->see('MZ Mindbody Classes', 'tr.active[data-plugin="mz-mindbody-classes/mz-mindbody-classes.php"] td strong');
    }

}



