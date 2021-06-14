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
 *
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
        $difficulty_levels = get_terms( array(
			'taxonomy' => 'difficulty_level',
			'hide_empty' => true,
		) );


        $temp_args['difficulty_levels'] = $difficulty_levels;        

		// Build out the FILTER
        $instructors = get_terms( array(
			'taxonomy' => 'class_instructor',
			'hide_empty' => true,
		) );

        $temp_args['instructors'] = $instructors; 

		// Build out the FILTER
        $music_styles = get_terms( array(
			'taxonomy' => 'music_style',
			'hide_empty' => true,
		) );
        
        $temp_args['music_styles'] = $music_styles; 

		// Build out the FILTER
        $class_lengths = get_terms( array(
			'taxonomy' => 'class_length',
			'hide_empty' => true,
		) );
        
        $temp_args['class_lengths'] = $class_lengths;

		
		//$return .= $filter_control;

		$prefix   = '_elliptica_od_';

		$temp_args['query'] = new WP_Query(array(
			'post_type' => 'elliptica_od_video',
			'post_status' => 'publish',
			'posts_per_page' => 20,
			'order'     => 'DESC',
            'meta_key' => $prefix . MMC_TEXTDOMAIN . '_date',
            'orderby'   => 'meta_value', //or 'meta_value_num'
		));
        $temp_args['prefix'] = $prefix;
		
        eod_get_template('html-shortcode.php', $temp_args);
        // Add Style with script adder
        self::addScript();

	}


    public static function addScript()
    {
        if (!self::$addedAlready) {
            self::$addedAlready = true;

            wp_register_style( MMC_TEXTDOMAIN . '-od-modaal', plugins_url( 'dist/css/modaal.min.css', MMC_PLUGIN_ABSOLUTE ), array(), MMC_VERSION);
            wp_enqueue_style( MMC_TEXTDOMAIN . '-od-modaal');

            wp_register_style( MMC_TEXTDOMAIN . '-od-videos', plugins_url( 'dist/css/' . MMC_TEXTDOMAIN . '.min.css', MMC_PLUGIN_ABSOLUTE ), array(), MMC_VERSION);
            wp_enqueue_style( MMC_TEXTDOMAIN . '-od-videos');

            wp_register_script( MMC_TEXTDOMAIN . '-od-isotope', plugins_url( 'dist/js/isotope.min.js', MMC_PLUGIN_ABSOLUTE ), array( 'jquery' ), MMC_VERSION );
            wp_enqueue_script( MMC_TEXTDOMAIN . '-od-isotope');

            wp_register_script( MMC_TEXTDOMAIN . '-od-videos', plugins_url( 'dist/js/' . MMC_TEXTDOMAIN . '.min.js', MMC_PLUGIN_ABSOLUTE ), array( 'jquery', MMC_TEXTDOMAIN . '-od-isotope' ), MMC_VERSION );
            wp_enqueue_script( MMC_TEXTDOMAIN . '-od-videos');

            self::localizeScript();
        }
    }

    public static function localizeScript()
    {

        $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';

        $params = array(
            'ajaxurl' => admin_url('admin-ajax.php', $protocol),
            'alert' => __( 'Hey! You have clicked the button!', MMC_TEXTDOMAIN ),
       );
        wp_localize_script( MMC_TEXTDOMAIN . '-od-videos', 'mmc_js_vars', $params);
    }

}

