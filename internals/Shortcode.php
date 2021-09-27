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
namespace Elliptica_On_Demand\Internals;

use \Elliptica_On_Demand\Engine;
use \WP_Query as WP_Query;

/**
 * Shortcodes of this plugin
 */
class Shortcode extends Engine\Base {

	/**
	 * If shortcode script has been enqueued.
	 *
	 * @since    2.4.7
	 * @access   public
	 *
	 * @used in handleShortcode, addScript
	 * @var      boolean $addedAlready True if shorcdoe scripts have been enqueued.
	 */
	static $addedAlready = false;

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();
		// Just in case, but I believe the plural of video is video
		add_shortcode( 'on-demand-videos', array( $this, 'elliptica_on_demand' ) );

		// Like this:
		add_shortcode( 'on-demand-video', array( $this, 'elliptica_on_demand' ) );

	}

	/**
	 * Shortcode example
	 *
	 * @param array $atts Parameters.
	 *
	 * @since 1.0.0
	 *
	 * @SuppressWarnings(PHPMD)
	 *
	 * @return string
	 */
	public static function elliptica_on_demand( $atts ) {
		shortcode_atts(
			array(
				'blank' => 'something',
			),
			$atts
		);

		// Build out the FILTER
		$post_terms = get_terms(
			array(
				'taxonomy'   => array(
					'difficulty_level',
					'class_instructor',
					'music_style',
					'class_length',
				),
				'hide_empty' => true,
			)
		);

		$difficulty_levels              = array_filter(
			$post_terms,
			function( $term ) {
				return 'difficulty_level' === $term->taxonomy;
			}
		);
		$template_args['difficulty_levels'] = $difficulty_levels;

		$class_instructors        = array_filter(
			$post_terms,
			function( $term ) {
				return 'class_instructor' === $term->taxonomy;
			}
		);
		$template_args['instructors'] = $class_instructors;

		$music_styles              = array_filter(
			$post_terms,
			function( $term ) {
				return 'music_style' === $term->taxonomy;
			}
		);
		$template_args['music_styles'] = $music_styles;

		$class_lengths              = array_filter(
			$post_terms,
			function( $term ) {
				return 'class_length' === $term->taxonomy;
			}
		);
		$template_args['class_lengths'] = $class_lengths;

		// $return .= $filter_control;

		$prefix = '_elliptica_od_';

		$template_args['query']  = new WP_Query(
			array(
				'post_type'      => 'elliptica_od_video',
				'post_status'    => 'publish',
				'posts_per_page' => MMC_PAGINATED_SEGMENT_SIZE,
				'order'          => 'DESC',
				'meta_key'       => $prefix . MMC_TEXTDOMAIN . '_date',
				'orderby'        => 'meta_value', // or 'meta_value_num'
			)
		);
		$template_args['prefix'] = $prefix;

		eod_get_template( 'html-shortcode.php', $template_args );
		eod_get_template( 'od-video-template.php', array() );
		// Add Style with script adder
		self::addScript();

	}


	public static function addScript() {
		if ( ! self::$addedAlready ) {
			self::$addedAlready = true;

			wp_register_style( MMC_TEXTDOMAIN . '-od-modaal', plugins_url( 'dist/css/modaal.min.css', MMC_PLUGIN_ABSOLUTE ), array(), MMC_VERSION );
			wp_enqueue_style( MMC_TEXTDOMAIN . '-od-modaal' );

			wp_register_style( MMC_TEXTDOMAIN . '-od-videos', plugins_url( 'dist/css/' . MMC_TEXTDOMAIN . '.min.css', MMC_PLUGIN_ABSOLUTE ), array(), MMC_VERSION );
			wp_enqueue_style( MMC_TEXTDOMAIN . '-od-videos' );

			wp_register_script( MMC_TEXTDOMAIN . '-od-isotope', plugins_url( 'dist/js/isotope.min.js', MMC_PLUGIN_ABSOLUTE ), array( 'jquery' ), MMC_VERSION );
			// wp_enqueue_script( MMC_TEXTDOMAIN . '-od-isotope' );

			wp_register_script( MMC_TEXTDOMAIN . '-od-video-elem', plugins_url( 'dist/js/od-video-elem.js', MMC_PLUGIN_ABSOLUTE ), array( 'jquery' ), MMC_VERSION );
			wp_enqueue_script( MMC_TEXTDOMAIN . '-od-video-elem' );

			wp_register_script(
				MMC_TEXTDOMAIN . '-od-videos',
				plugins_url(
					'dist/js/' . MMC_TEXTDOMAIN . '.min.js',
					MMC_PLUGIN_ABSOLUTE
				),
				array(
					'jquery',
					MMC_TEXTDOMAIN . '-od-isotope',
					MMC_TEXTDOMAIN . '-od-video-elem',
				),
				MMC_VERSION
			);
			wp_enqueue_script( MMC_TEXTDOMAIN . '-od-videos' );

			self::localizeScript();
		}
	}

	public static function localizeScript() {
		$protocol = isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';

		$params = array(
			'ajax_url'               => admin_url( 'admin-ajax.php', $protocol ),
			'alert'                  => __( 'Hey! You have clicked the button!', MMC_TEXTDOMAIN ),
			'paginated_segment_size' => MMC_PAGINATED_SEGMENT_SIZE,
			'no_results_message'     => __( 'No video classes to show', 'elliptica-on-demand' ),
		);
		wp_localize_script( MMC_TEXTDOMAIN . '-od-videos', 'mmc_js_vars', $params );

	}

}
