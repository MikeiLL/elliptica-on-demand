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
		//$this->add_simple_route();
		$this->add_eod_get_route();
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
				'callback' => array( $this, 'simple_route_example' )
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
	public function add_eod_get_route() {
        // An example with 0 parameters.
        register_rest_route(
            'eod/v1',
            '/posts',
            array(
				'methods'  => 'GET',
				'callback' => array( $this, 'return_on_demand_posts' )
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
	 * Request could look like
	 * eod/v1/posts?meta_query[relation]=OR&meta_query[0][key]=class_length&meta_query[0][value]=30&meta_query[0][compare]==
     *
     * @return array
     */
    public function return_on_demand_posts( \WP_REST_Request $request ) {
        //global $wpdb;
		$parameters = $request->get_params();
		$data = array();
		// Do the actual query and return the data
		if ( is_array( $parameters ) && isset( $parameters ) ){
		    extract( $parameters );
		    
		    $class_instructor = isset($class_instructor) ? $class_instructor : '';
		    $difficulty_level = isset($difficulty_level) ? $difficulty_level : '';
		    $music_style = isset($music_style) ? $music_style : '';
		    $class_length = isset($class_length) ? $class_length : '';
		    
		    $args = array (
		        'orderby'               => 'title',
		        'post_type'		=> 'elliptica_od_video', // or 'post', 'page'
		        'posts_per_page'   => -1,
 		        'tax_query' => array(
		            'relation' => 'OR'      
		        )
		    );
		    
		    if(!empty($class_instructor)){
		        $args['tax_query'][] = array( // selects posts that are in this taxonomy
		            'taxonomy' => 'class_instructor',
		            'field'    => 'term_id',
		            'terms'    => $class_instructor,
		        );
		    }
		    
		    if(!empty($difficulty_level)){
		        $args['tax_query'][] = array( // selects posts that are in this taxonomy
		            'taxonomy' => 'difficulty_level',
		            'field'    => 'term_id',
		            'terms'    => $difficulty_level,
		        );
		    }
		    
		    if(!empty($music_style)){
		        $args['tax_query'][] = array( // selects posts that are in this taxonomy
		            'taxonomy' => 'music_style',
		            'field'    => 'term_id',
		            'terms'    => $music_style,
		        );
		    }
		    
		    if(!empty($class_length)){
		        $args['tax_query'][] = array( // selects posts that are in this taxonomy
		            'taxonomy' => 'class_length',
		            'field'    => 'term_id',
		            'terms'    => $class_length,
		        );
		    }
		    
		    $query = new \WP_Query($args);
		    if ( $query->have_posts() ) {
		        
		        while ( $query->have_posts() ) {
		            $line_data = array();
		            $query->the_post();
		            
		            $line_data['id'] = get_the_ID() ;
		            //$data['title'] = get_the_title();
		            //$data['image'] = has_post_thumbnail( get_the_ID() ) ? wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'on_demand_video' ) : '';
		            
		            if(has_post_thumbnail( get_the_ID() )){
		                $f_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'on_demand_video' );
		                $line_data['image'] = $f_image[0];
		            }else{
		                $line_data['image'] = '';
		            }
		            
		            
		            array_push($data, $line_data);
		        }
		    }
		    wp_reset_query();
		    if(!empty($data) && isset($data)){
		        return array('code' => 200, 'result' => $data);
		    }else{
			     return array('code' => 204, 'result' => 'No post to show');
		    }
		}else{

		    $query = new \WP_Query( array (
		        'orderby'               => 'title',
		        'post_type'		=> 'elliptica_od_video', // or 'post', 'page'
		        'posts_per_page'        => -1,
		        //'fields' => 'ids'
		    ));
		    
		    if ( $query->have_posts() ) {
		        
		        while ( $query->have_posts() ) {
		            $line_data = array();
		            $query->the_post();
		            
		            $line_data['id'] = get_the_ID() ;
		            //$data['title'] = get_the_title();
		            //$data['image'] = has_post_thumbnail( get_the_ID() ) ? wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'on_demand_video' ) : '';
		            
		            if(has_post_thumbnail( get_the_ID() )){
		                $f_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'on_demand_video' );
		                $line_data['image'] = $f_image[0];
		            }else{
		                $line_data['image'] = '';
		            }
		            array_push($data, $line_data);
		        }
		    }
		    wp_reset_query();
		    return array('code' => 200, 'result' => $data);
		}
    }

    /**
     * Examples
     *
     * @since 1.0.0
     *
     * @param array $post_obj Post ID.
     *
     * @return string
     */
    public function get_text_field( $post_obj ) {
        $post_id = $post_obj['id'];
        return get_post_meta( $post_id, MMC_TEXTDOMAIN . '_text', true );
    }

    /**
     * Examples
     *
     * @since 1.0.0
     *
     * @param string $value Value.
     * @param object $post  Post object.
     * @param string $key   Key.
     *
     * @return boolean|\WP_Error
     */
    public function update_text_field( $value, $post, $key ) {
        $post_id = update_post_meta( $post->ID, $key, $value );

        if ( false === $post_id ) {
            return new \WP_Error(
                'rest_post_views_failed',
                __( 'Failed to update post views.', MMC_TEXTDOMAIN ),
                array( 'status' => 500 )
            );
        }

        return true;
    }

    /**
     * Examples
     *
     * @since 1.0.0
     *
     * @param array $data Values.
     *
     * @return array
     */
    public function sum( $data ) {
        return array( 'result' => $data[ 'first' ] + $data[ 'second' ] );
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
    public function simple_route_example( ) {
        return array( 'result' => 'Salaam. I can hear you.' );
    }

}
