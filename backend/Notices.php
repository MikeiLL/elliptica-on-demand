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
namespace MZ_Mindbody_Classes\Backend;

use \MZ_Mindbody_Classes\Engine;
use Yoast_I18n_WordPressOrg_v3;
use \WP_Review_Me as WP_Review_Me;

/**
 * Everything that involves notification on the WordPress dashboard
 */
class Notices extends Engine\Base {

	/**
	 * Initialize the class
	 *
	 * @return void
	 */
	public function initialize() {
		if ( !parent::initialize() ) {
			return;
		}

		wpdesk_wp_notice( __( 'Updated Messages', MMC_TEXTDOMAIN ), 'updated' );
		wpdesk_wp_notice( __( 'This is my dismissible notice', MMC_TEXTDOMAIN ), 'error', true );

		/*
		 * Review plugin notice.
		 */
		new WP_Review_Me(
			array(
				'days_after' => 15,
				'type'       => 'plugin',
				'slug'       => MMC_TEXTDOMAIN,
				'rating'     => 5,
				'message'    => __( 'Review me!', MMC_TEXTDOMAIN ),
				'link_label' => __( 'Click here to review', MMC_TEXTDOMAIN ),
			)
		);
		/*
		 * Alert after few days to suggest to contribute to the localization if it is incomplete
		 * on translate.wordpress.org, the filter enables to remove globally.
		 */
		if ( apply_filters( 'mz_mindbody_classes_alert_localization', true ) ) {
			new Yoast_I18n_WordPressOrg_V3(
			array(
				'textdomain'  => MMC_TEXTDOMAIN,
				'mz_mindbody_classes' => MMC_NAME,
				'hook'        => 'admin_notices',
			),
			true
			);
		}

	}

}

