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
namespace Elliptica_On_Demand\Rest;

use \Elliptica_On_Demand\Engine;

/**
 * Example class for REST
 */
class OnDemand extends Engine\Base {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();
		add_action( 'rest_api_init', array( $this, 'add_custom_stuff' ) );
	}

	/**
	 * Examples
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_custom_stuff() {
		$this->add_custom_field();
		$this->add_custom_route();
		$this->add_eod_get_route();
		$this->add_simple_route();
	}

	/**
	 * Examples
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_custom_field() {
		register_rest_field(
			'demo',
			MMC_TEXTDOMAIN . '_text',
			array(
				'get_callback'    => array( $this, 'get_text_field' ),
				'update_callback' => array( $this, 'update_text_field' ),
				'schema'          => array(
					'description' => __( 'Text field demo of Post type', MMC_TEXTDOMAIN ),
					'type'        => 'string',
				),
			)
		);
	}

	/**
	 * Examples
	 *
	 * @since 1.0.0
	 *
	 * Make an instance of this class somewhere, then
	 * call this method and test on the command line with
	 * `curl http://example.com/wp-json/wp/v2/calc?first=1&second=2`
	 *
	 * @return void
	 */
	public function add_custom_route() {
		// Only an example with 2 parameters
		register_rest_route(
			'wp/v2',
			'/calc',
			array(
				'methods'  => \WP_REST_Server::READABLE,
				'callback' => array( $this, 'sum' ),
				'args'     => array(
					'first'  => array(
						'default'           => 10,
						'sanitize_callback' => 'absint',
					),
					'second' => array(
						'default'           => 1,
						'sanitize_callback' => 'absint',
					),
				),
			)
		);
	}

	/**
	 * Simple Route Example
	 *
	 * Make an instance of this class somewhere, then
	 * call this method and test on the command line with
	 * `curl http://example.com/wp-json/eod/v1/simple`
	 */
	public function add_simple_route() {
		// An example with 0 parameters.
		register_rest_route(
			'eod/v1',
			'/simple',
			array(
				'methods'  => 'GET',
				'callback' => array( $this, 'simple_route_example' ),
			)
		);
	}
		/**
		 * Simple Route Example
		 *
		 * @since 1.0.0
		 *
		 * @param array $data Values.
		 *
		 * @return array
		 */
	public function simple_route_example() {
		return array( 'result' => 'Salaam. I can hear you.' );
	}

	/**
	 * Simple Route Example
	 *
	 * Make an instance of this class somewhere, then
	 * call this method and test on the command line with
	 * `curl http://example.com/wp-json/eod/v1/simple`
	 */
	public function add_eod_get_route() {
		// An example with 0 parameters.
		register_rest_route(
			'eod/v1',
			'/posts',
			array(
				'methods'  => 'GET',
				'callback' => array( $this, 'return_on_demand_posts' ),
			)
		);
	}

	/**
	 * Return On Demand Posts
	 *
	 * @since 1.0.0
	 *
	 * @param WP_REST_Request $request Values.
	 *
	 * Request example:
	 * /wp-json/eod/v1/posts?difficulty_level=75&class_instructor=2&music_style=4&class_length=6
	 *
	 * @return array
	 */
	public function return_on_demand_posts( \WP_REST_Request $request ) {
		
			// Set default arguments
			$args = array(
				'orderby'        => 'title',
				'post_type'      => 'elliptica_od_video',
				'post_status'    => 'publish',
				'posts_per_page' => 20,
			);

			$request_result = array();

			$parameters = $request->get_params();

			// Overwrite args from parameters if present
			if ( is_array( $parameters ) && isset( $parameters ) ) {
				$args['tax_query'] = $this->_build_query_from_params( $parameters );
				$args['paged'] = 1;

				if(isset($parameters['paged']) && !empty($parameters['paged'])){
					$args['paged'] = $parameters['paged'];
				}

			}

			$query = new \WP_Query( $args );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
						$query->the_post();

						array_push( $request_result, get_the_ID() );
				}
			}

			wp_reset_query();

			if ( ! empty( $request_result ) && isset( $request_result ) ) {
					return array(
						'code'   => 200,
						'result' => $request_result,
					);
			}

			return array(
				'code'   => 204,
				'result' => 'No post to show',
			);
	}

	/**
	 * Build Query from Parameters
	 *
	 * Receive request parameters and query database, returning status and result.
	 *
	 * @since 1.0.4
	 * @param $parameters array or http request parameters.
	 * @access private
	 * @return array $tax_query of tax term arguments for query.
	 */
	private function _build_query_from_params( $parameters ) {
			extract( $parameters );

			$tax_query = array(
				'relation' => 'AND',
			);

			$filter_fields = array(
				'class_instructor' => isset( $parameters['class_instructor'] ) ? $parameters['class_instructor'] : '',
				'difficulty_level' => isset( $parameters['difficulty_level'] ) ? $parameters['difficulty_level'] : '',
				'music_style'      => isset( $parameters['music_style'] ) ? $parameters['music_style'] : '',
				'class_length'     => isset( $parameters['class_length'] ) ? $parameters['class_length'] : '',
				//'paged'			   => isset( $parameters['paged'] ) ? $parameters['paged'] : 1,
			);

			foreach ( $filter_fields as $tax => $id ) {
				if ( ! empty( $id ) ) {
					$tax_query[] = $this->_build_tax_term_query( $tax, $id );
				}
			}

			return $tax_query;
	}

			/**
			 * Build Tax Term Query from Key and Value
			 *
			 * Selects posts that are in this taxonomy
			 *
			 * @since 1.0.4
			 * @param string $tax taxonomy name
			 * @param int    $term_id the id of the item saught
			 */
	private function _build_tax_term_query( $tax, $term_id ) {
		return array(
			'taxonomy' => $tax,
			'field'    => 'term_id',
			'terms'    => $term_id,
		);
	}

}
