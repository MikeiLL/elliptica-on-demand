<?php

/**
 * Elliptica_On_Demand
 *
 * @package   Elliptica_On_Demand
 * @author    Mike iLL <mike@mzoo.org>
 * @copyright 2020 mZoo.org
 * @license   GPL 2.0+
 * @link      http://mzoo.org
 */
namespace Elliptica_On_Demand\Internals;

use \Elliptica_On_Demand\Engine;

/**
 * Post Types and Taxonomies
 */
class PostTypes extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();
		add_action( 'init', array( $this, 'load_cpts' ) );

		// Add custom image size for isotope display.
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'on_demand_video', 400, 245, array( 'center', 'top' ) );

		/*
		* Custom Columns
		*/
		// $post_columns = new \CPT_columns( 'elliptica_od_video' );
		// $post_columns->add_column(
		// 	'elliptica_od_video_date',
		// 	array(
		// 		'label'    => __( 'Class Date', MMC_TEXTDOMAIN ),
		// 		'type'     => 'post_meta',
		// 		'meta_key' => '_elliptica_od_video_' . MMC_TEXTDOMAIN . '_date', // phpcs:ignore WordPress.DB
		// 		'orderby'  => 'meta_value',
		// 		'sortable' => true,
		// 		'prefix'   => '<b>',
		// 		'suffix'   => '</b>',
		// 		'title_icon'  => 'dashicons-calendar-alt',
		// 		'def'      => 'Not defined', // Default value in case post meta not found
		// 		'order'    => '-1',
		// 	)
		// );


		/*
		* Custom Bulk Actions
		*/
		$bulk_actions = new \Seravo_Custom_Bulk_Action( array( 'post_type' => 'elliptica_od_video' ) );
		$bulk_actions->register_bulk_action(
			array(
				'menu_text'    => 'Mark meta',
				'admin_notice' => 'Written something on custom bulk meta',
				'callback'     => function( $post_ids ) {
					foreach ( $post_ids as $post_id ) {
						update_post_meta( $post_id, '_elliptica_od_video_' . MMC_TEXTDOMAIN . '_text', 'Random stuff' );
					}

					return true;
				},
			)
		);
		$bulk_actions->init();
		// Add bubble notification for cpt pending
		add_action( 'admin_menu', array( $this, 'pending_cpt_bubble' ), 999 );
		add_filter( 'pre_get_posts', array( $this, 'filter_search' ) );
	}

	/**
	 * Add support for custom CPT on the search box
	 *
	 * @param object $query Wp_Query.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function filter_search( $query ) {
		if ( $query->is_search && !is_admin() ) {
			$post_types = $query->get( 'post_type' );
			if ( $post_types === 'post' ) {
				$post_types = array( $post_types );
				$query->set( 'post_type', array_push( $post_types, array( 'elliptica_od_video' ) ) );
			}
		}

		return $query;
	}

	/**
	 * Load CPT and Taxonomies on WordPress
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_cpts() {
		// Create Custom Post Type https://github.com/johnbillion/extended-cpts/wiki
		register_extended_post_type( 'elliptica_od_video', [

		# Add the post type to the site's main RSS feed:
		'show_in_feed' => true,

		'menu_icon'	=> 'dashicons-desktop',


		# Show all posts on the post type archive:
		'archive' => [
			'nopaging' => true,
		],

		# Add the post type to the 'Recently Published' section of the dashboard:
		'dashboard_activity' => true,

		# Add some custom columns to the admin screen:
		'admin_cols' => [
			'elliptica_od_video_featured_image' => [
				'title'          => 'Class Image',
				'featured_image' => 'thumbnail'
			],
			'elliptica_od_video_date_col' => [
				'title_icon'  => 'dashicons-calendar-alt',
				'meta_key'    => '_elliptica_od_' . MMC_TEXTDOMAIN . '_date',
				'date_format' => 'd/m/Y'
			],
			'elliptica_od_video_music_style' => [
				'taxonomy' => 'music_style'
			],
			'elliptica_od_video_difficulty_level' => [
				'taxonomy' => 'difficulty_level'
			],
			'elliptica_od_video_instructor' => [
				'title'          => 'Instructor',
				'taxonomy' => 'class_instructor'
			],
		],
		'supports'            => ['title', 'thumbnail', 'revisions' ],

		# Add some dropdown filters to the admin screen:
		'admin_filters' => [
			'elliptica_od_video_music_style' => [
				'taxonomy' => 'music_style'
			],
		],

	], [

		# Override the base names used for labels:
		'singular' => 'On Demand Video',
		'plural'   => 'On Demand Videos',
		'slug'     => 'elliptica_od_video',

	] );
	// Create Custom Taxonomy https://github.com/johnbillion/extended-taxos
	register_extended_taxonomy( 'music_style', 'elliptica_od_video', [

		'dashboard_glance' => true,

	] );
	register_extended_taxonomy( 'difficulty_level', 'elliptica_od_video', [

		'dashboard_glance' => true,

	] );
	register_extended_taxonomy( 'class_length', 'elliptica_od_video', [

		'dashboard_glance' => true,

	] );
	register_extended_taxonomy( 'class_instructor', 'elliptica_od_video', [

		'dashboard_glance' => true,

	] );

	}

	/**
     * Bubble Notification for pending cpt<br>
     * NOTE: add in $post_types your cpts<br>
     *
     *        Reference:  http://wordpress.stackexchange.com/questions/89028/put-update-like-notification-bubble-on-multiple-cpts-menus-for-pending-items/95058
     *
     * @since 1.0.0
     *
     * @return void
     */
	public function pending_cpt_bubble() {
		global $menu;

		$post_types = array( 'elliptica_od_video' );
		foreach ( $post_types as $type ) {
			if ( !post_type_exists( $type ) ) {
				continue;
			}

			// Count posts
			$cpt_count = wp_count_posts( $type );

			if ( $cpt_count->pending ) {
				// Locate the key of
				$key = self::recursive_array_search_php( 'edit.php?post_type=' . $type, $menu );

				// Not found, just in case
				if ( !$key ) {
					return;
				}

				// Modify menu item
				$menu[ $key ][ 0 ] .= sprintf( //phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					'<span class="update-plugins count-%1$s"><span class="plugin-count">%1$s</span></span>',
					$cpt_count->pending
				);
			}
		}
	}

	/**
     * Required for the bubble notification<br>
     *
     *  Reference:  http://wordpress.stackexchange.com/questions/89028/put-update-like-notification-bubble-on-multiple-cpts-menus-for-pending-items/95058
     *
     * @param string $needle First parameter.
     * @param array  $haystack Second parameter.
     *
     * @since 1.0.0
     *
     * @return mixed
     */
	private function recursive_array_search_php( $needle, $haystack ) {
		foreach ( $haystack as $key => $value ) {
			$current_key = $key;
			if ( $needle === $value || ( is_array( $value ) && self::recursive_array_search_php( $needle, $value ) !== false ) ) {
				return $current_key;
			}
		}

		return false;
	}

}
