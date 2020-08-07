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

		// Build out the FILTER
        $difficulty_levels = get_terms( array(
			'taxonomy' => 'difficulty_level',
			'hide_empty' => true,
		) );


		$return = "";

		$filter_control = '<div class="filters">';

		$level_filter_control = '  <div class="ui-group">';

		$level_filter_control .= '		<div class="button-group" data-filter-group="level">';
		$count = count($difficulty_levels);
		$level_filter_control .= '<button style="float:left;" class="button is-checked" data-filter="*">Any Level</button>';
		$all_terms = [];
		if ( $count > 0 ){
			foreach ( $difficulty_levels as $term ) {
				$termname = strtolower($term->name);
				$termname = str_replace(' ', '-', $termname);
				$level_filter_control .= '<button style="float:left;" class="button" data-filter=".'.$termname.'">' . $term->name . '</button>';
				$all_terms[$count] = $termname;
				$count--;
			}
		$level_filter_control .= '<button style="float:left;" class="button" data-filter=".'.implode('.', $all_terms).'">All Levels Welcome</button>';;
		}
		$level_filter_control .= '		</div> <!-- button-group -->';

		$level_filter_control .= '	</div> <!-- ui-group -->';

		$filter_control .= $level_filter_control;



		// Build out the FILTER
        $instructors = get_terms( array(
			'taxonomy' => 'class_instructor',
			'hide_empty' => true,
		) );



		$instructor_filter_control = '  <div class="ui-group">';

		$instructor_filter_control .= '		<div class="button-group" data-filter-group="instructor">';
		$count = count($instructors);
		$instructor_filter_control .= '<button style="float:left;" class="button is-checked" data-filter="*">Any Instructor</button>';
		if ( $count > 0 ){
			foreach ( $instructors as $term ) {
				$termname = strtolower($term->name);
				$termname = str_replace(' ', '-', $termname);
				$instructor_filter_control .= '<button style="float:left;" class="button" data-filter=".'.$termname.'">' . $term->name . '</button>';

			}
		}
		$instructor_filter_control .= '		</div> <!-- button-group -->';

		$instructor_filter_control .= '	</div> <!-- ui-group -->';

		$filter_control .= $instructor_filter_control;



		// Build out the FILTER
        $music_styles = get_terms( array(
			'taxonomy' => 'music_style',
			'hide_empty' => true,
		) );
		$music_style_filter_control = '  <div class="ui-group">';

		$music_style_filter_control .= '		<div class="button-group" data-filter-group="music">';
		$count = count($music_styles);
		$music_style_filter_control .= '<button style="float:left;" class="button is-checked" data-filter="*">All Styles</button>';
		if ( $count > 0 ){
			foreach ( $music_styles as $term ) {
				$termname = strtolower($term->name);
				$termname = str_replace(' ', '-', $termname);
				$music_style_filter_control .= '<button style="float:left;" class="button" data-filter=".'.$termname.'">' . $term->name . '</button>';

			}
		}
		$music_style_filter_control .= '		</div> <!-- button-group -->';

		$music_style_filter_control .= '	</div> <!-- ui-group -->';

		$filter_control .= $music_style_filter_control;


		// Build out the FILTER
        $class_lengths = get_terms( array(
			'taxonomy' => 'class_length',
			'hide_empty' => true,
		) );
		$class_length_filter_control = '  <div class="ui-group">';

		$class_length_filter_control .= '		<div class="button-group" data-filter-group="length">';
		$count = count($class_lengths);
		$class_length_filter_control .= '<button style="float:left;" class="button is-checked" data-filter="*">Any Length</button>';
		if ( $count > 0 ){
			foreach ( $class_lengths as $term ) {
				$termname = strtolower($term->name);
				$termname = str_replace(' ', '-', $termname);
				$class_length_filter_control .= '<button style="float:left;" class="button" data-filter=".'.$termname.'">' . $term->name . '</button>';

			}
		}
		$class_length_filter_control .= '		</div> <!-- button-group -->';

		$class_length_filter_control .= '	</div> <!-- ui-group -->';

		$filter_control .= $class_length_filter_control;

		$filter_control .= '</div> <!-- // filters -->';

		$return .= $filter_control;

		$prefix   = '_elliptica_od_';

		$query = new WP_Query(array(
			'post_type' => 'elliptica_od_video',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'order'     => 'ASC',
            'meta_key' => $prefix . MMC_TEXTDOMAIN . '_date',
            'orderby'   => 'meta_value', //or 'meta_value_num'
		));

		$return .= '<div id="elliptica_od_videos">';

		$modaal_id_count = 1;

		if($query->have_posts()) : while($query->have_posts()) : $query->the_post();
			$isotope_filter_classes = "all od-video ";

			$post_id   = get_the_ID();

			// Difficulty levels
			$post_terms = wp_get_object_terms( $post_id, ['class_instructor', 'difficulty_level','music_style', 'class_length'] );

			if ( !empty($post_terms) ) {
				foreach ( $post_terms as $post_meta_item ) {
					$termname = strtolower($post_meta_item->name);
					$termname = str_replace(' ', '-', $termname);
					$isotope_filter_classes .= $termname .' ';
				}
			}

			$return .= '<a data-modaal-content-source="#modal-id-' . $modaal_id_count .'" href="#modal-id-' . $modaal_id_count .'" class="info-popup">';
			$return .= '<div class="' . $isotope_filter_classes . '" data-modaal-type="inline" data-modaal-animation="fade" class="modaal" ';
			if (has_post_thumbnail( $post->ID ) ):
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium_large' );
			  	$return .= 'style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7)),url(' . $featured_image[0] .')"';
			else:
				$return .= 'style="background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7))"';
			endif;
			$return .= '>';

			$return .= '	<div class="od-video_info">';

			$class_title = get_the_title();

			$return .= '		<h5>' . $class_title . '</h5>';

			$instructor_and_type = '';

			$class_instructors = get_the_terms( $post_id, 'class_instructor' );
			if ( !empty($class_instructors) ) {
				foreach ( $class_instructors as $class_instructor ) {
					$instructor_and_type .= $class_instructor->slug . ' ';
				}
			}

			$instructor_and_type .= '		<span aria-hidden="true"> · </span>';

			$class_type = get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_class_type' );
			if ( !empty($class_type) ) {
				$instructor_and_type .= $class_type[0] . ' ';
			}

			$date_time = get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_date' );
			if ( !empty($date_time) ) {
				$instructor_and_type .= "<br/>";
				$instructor_and_type .= date_i18n('F j', $date_time[0]) . ' @ ' . date_i18n('g:i a', $date_time[0]);
			}

			$return .= $instructor_and_type;

			$return .= '	</div> <!-- //od-video_info -->';

			$return .=  '</div> <!-- //od-video -->';
			$return .= '</a>';

			$class_desc = get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_desc' );
			if ( !empty($class_desc) ) {
				$description = $class_desc[0] . ' ';
			}

			$video_id = get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_video_id' );
			if ( !empty($video_id) ) {
				$video_link = $video_id[0] . ' ';
			}

			/* Build the Modal Content */
			$modal_content = '<div id="modal-id-' . $modaal_id_count .'" style="display:none;">';

			/* Header */

			$difficulty_levels = [];
			$difficulty_levels_array = get_the_terms( $post_id, 'difficulty_level' );
			if ( !empty($difficulty_levels_array) ) {
				foreach ( $difficulty_levels_array as $k => $difficulty_level ) {
					$difficulty_levels[$k] = $difficulty_level->name . ' ';
				}
			}
			// Build modal class header background declaration
			$modal_header = '<div class="modal-class-details__header" ';
			if (has_post_thumbnail( $post->ID ) ):
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium_large' );
			  	$modal_header .= 'style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7)),url(' . $featured_image[0] .')"';
			else:
				$modal_header .= 'style="background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.7));"';
			endif;
			$modal_header .= '>'; // End modal class image background declaration

			$modal_header .= 	'	<div class="modal-class-details__header_content">';
			$modal_header .= 	'		<div>';
			$modal_header .= 	'			<h5>' . $class_title .' </h5>';
			$modal_header .= 	'			<p>' . $instructor_and_type .' </p>';
			$modal_header .= 	'		</div>';
			$modal_header .= 	'		<div>';
			$modal_header .= 	'			<a class="modal_header_play_button" href="https://video.mindbody.io/studios/526618/videos/' . $video_link .'">Start</a>';
			// <svg viewBox="0 0 28 28" width="16" height="16"><g stroke="none" stroke-width="1" fill-rule="evenodd"><path d="M23.3870324,12.1022967 C25.1944355,13.1466985 25.1944355,14.8547015 23.3870324,15.8977033 L8.04720582,24.7541186 C6.23840269,25.7985204 4.76000013,24.9445189 4.76000013,22.8571153 L4.76000013,5.14288467 C4.76000013,3.05548105 6.23840269,2.20147957 8.04720582,3.24588138 L23.3870324,12.1022967 Z" fill="#ffffff"></path></g></svg>
			$modal_header .= 	'		</div>';
			$modal_header .= 	'	</div>';
			$modal_header .= 	'</div>';
			/* // End Header */


			$modal_content .= $modal_header;

			/* Modal Details Body */
			// (to wrap with padding below header, to avoid negative margin in header)
			$modal_content .= '	<div class="modal-class-details__body">';

			/* Intro */
			$modal_intro = 		'	<div class="modal-class-details__intro">';
			$modal_intro .= 	'		<div class="modal-class-details__intro__level>" ';
			$modal_intro .= 	'			<p><strong>Level</strong>: ' . implode(', ', $difficulty_levels) .' </p>';
			$modal_intro .= 	'		</div>';
			$modal_intro .= 	'		<div class="modal-class-details__intro__desc>" ';
			$modal_intro .= 	'			<p>' . $description .'</p>';
			$modal_intro .= 	'		</div>';
			$modal_intro .= 	'	</div>';

			$modal_content .= $modal_intro;

			/* // Intro */

			$class_plans = get_post_meta( $post_id, $prefix . MMC_TEXTDOMAIN . '_classplan' );
			$class_plans_only = $class_plans;
			/* Playlist */
			if ( !empty($class_plans) ) {
				$modal_content .= '	<div class="modal-class-details__playlist_section">';
				$modal_content .= '		<h2>Playlist</h2>';
				$modal_content .= '		<div class="modal-class-details__listwrap mcd__playlist_hideContent">';
				$modal_content .= '			<ol>';
				foreach ( $class_plans as $class_plan ) {
					foreach ( $class_plan as $class_segment ) {
						$modal_content .= '				<li class="modal-class-details__playlist_item"><img class="modal-class-details__playlist_img" src="' . $class_segment['song_artwork'] . '"/>';
						$modal_content .= '					<div class="modal-class-details__song_details">';
						$modal_content .= '						<strong>' . $class_segment['song_title'] . '</strong>';
						$modal_content .= '						<span>' . $class_segment['song_artists'] . '</span>';
						$modal_content .= '					</div>';
						$modal_content .= '			</li>';
					}
				}
				$modal_content .= '			</ol>';
				$modal_content .= '		</div>';

				$modal_content .= '		<div class="mcd_playlist__show-more">';
				$modal_content .= '			<a href="#">Show more</a>';
				$modal_content .= '		</div>';
				$modal_content .= '	</div>';

			/* Class Plan */
				$modal_content .= '	<div class="modal-class-details__classplan_section">';
				$modal_content .= '		<h2>Class Plan</h2>';
				$modal_content .= '		<div class="modal-class-details__listwrap">';
				$modal_content .= '			<ol>';

				$minimized_class_plan = minimize_and_sum_class_plans($class_plans);
				foreach ( $minimized_class_plan as $class_segment ) {
					$modal_content .= '				<li class="modal-class-details__classplan_item">';
					$modal_content .= '					<div class="modal-class-details__segment_type">';
					$modal_content .= '						' . $class_segment['segment_type'];
					$modal_content .= '					</div>';
					$modal_content .= '					<div class="modal-class-details__segment_duration">';
					$modal_content .= '						' . $class_segment['segment_duration'] . ' min';
					$modal_content .= '					</div>';
					$modal_content .= '				</li>';
				}
				$modal_content .= '			</ol>';
				$modal_content .= '		</div>';
				$modal_content .= '	</div>';
			}


			/* End Modal Details Body */
			$modal_content .= '	</div>';

			/* End Modal Content */
			$modal_content .= '</div>';

			$return .= $modal_content;

			$modaal_id_count++;

		endwhile; endif;

		// Add Style with script adder
        self::addScript();

		return $return;
	}


    public function addScript()
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

