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
        add_shortcode( 'on-demand-videos', array( $this, 'elliptica_on_demand' ) );
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
		$query = new WP_Query(array(
			'post_type' => 'elliptica_od_video',
			'post_status' => 'publish',
			'posts_per_page' => -1,
		));

		// Add Style with script adder
        self::addScript();

		$return = '<div id="elliptica_od_videos">';

		if($query->have_posts()) : while($query->have_posts()) : $query->the_post();
			$return .= '<a href="' . get_the_permalink() . '">';
			$return .= '<div class="all od-video"';
			if (has_post_thumbnail( $post->ID ) ):
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
			  	$return .= 'style="background-image: url(' . $image[0] .')"';
			endif;
			$return .= '>';
			$return .= get_the_title();

			$post_id = get_the_ID();
			$return .=  '</div>';
			$return .= '</a>';
		endwhile; endif;

		return $return;
	}


    public function addScript()
    {
        if (!self::$addedAlready) {
            self::$addedAlready = true;

            wp_register_style( MMC_TEXTDOMAIN . '-od-videos', plugins_url( 'dist/css/' . MMC_TEXTDOMAIN . '.min.css', MMC_PLUGIN_ABSOLUTE ), array(), MMC_VERSION);
            wp_enqueue_style( MMC_TEXTDOMAIN . '-od-videos');

            wp_register_script( MMC_TEXTDOMAIN . '-od-isotope', plugins_url( 'dist/js/isotope.min.js', MMC_PLUGIN_ABSOLUTE ), array( 'jquery' ), MMC_VERSION );
            wp_enqueue_script( MMC_TEXTDOMAIN . '-od-isotope');

            wp_register_script( MMC_TEXTDOMAIN . '-od-videos', plugins_url( 'dist/js/' . MMC_TEXTDOMAIN . '.min.js', MMC_PLUGIN_ABSOLUTE ), array( 'jquery', MMC_TEXTDOMAIN . '-od-isotope' ), MMC_VERSION );
            wp_enqueue_script( MMC_TEXTDOMAIN . '-od-videos');

            $this->localizeScript();
        }
    }

    public function localizeScript()
    {

        $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';

        $params = array(
            'ajaxurl' => admin_url('admin-ajax.php', $protocol),
            'alert' => __( 'Hey! You have clicked the button!', MMC_TEXTDOMAIN ),
       );
        wp_localize_script( MMC_TEXTDOMAIN . '-od-videos', 'mmc_js_vars', $params);
    }

}

