<?php
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Register a testimonial post type.
 *
 * @link	http://codex.wordpress.org/Function_Reference/register_post_type
 * @package cleona plugins
 */
function cleona_testimonial_post_type() {
	$labels = array(
		'name'					=> esc_html__( 'Testimonials',						'cleona-plugins' ),
		'singular_name'			=> esc_html__( 'Testimonial',						'cleona-plugins' ),
		'menu_name'				=> esc_html__( 'Testimonials%%PENDING%%',			'cleona-plugins' ),
		'name_admin_bar'		=> esc_html__( 'Testimonial',						'cleona-plugins' ),
		'add_new'				=> esc_html__( 'Add New',							'cleona-plugins' ),
		'add_new_item'			=> esc_html__( 'Add New Testimonial',				'cleona-plugins' ),
		'new_item'				=> esc_html__( 'New Testimonial',					'cleona-plugins' ),
		'edit_item'				=> esc_html__( 'Edit Testimonial',					'cleona-plugins' ),
		'view_item'				=> esc_html__( 'View Testimonial',					'cleona-plugins' ),
		'all_items'				=> esc_html__( 'All Testimonials',					'cleona-plugins' ),
		'search_items'			=> esc_html__( 'Search Testimonials',				'cleona-plugins' ),
		'parent_item_colon'		=> esc_html__( 'Parent Testimonials',				'cleona-plugins' ),
		'not_found'				=> esc_html__( 'No testimonials found.',			'cleona-plugins' ),
		'not_found_in_trash'	=> esc_html__( 'No testimonials found in Trash.',	'cleona-plugins' )
	);

	$args = array(
		'labels'				=> $labels,
		'description'			=> esc_html__( 'Display buyer testimonials.',		'cleona-plugins' ),
		'public'				=> true,
		'publicly_queryable'	=> false,
		'exclude_from_search'	=> true,
		'show_ui'				=> true,
		'show_in_menu'			=> true,
		'menu_position'			=> 30,
		'menu_icon'				=> 'dashicons-format-chat',
		'query_var'				=> true,
		'rewrite'				=> array( 'slug' => 'testimonial' ),
		'capability_type'		=> 'post',
		'has_archive'			=> false,
		'hierarchical'			=> false,
		'menu_position'			=> null,
		'supports'				=> array( 'title' )
	);

	register_post_type( 'testimonial', $args );
}
add_action( 'init', 'cleona_testimonial_post_type', 999 );


/**
 * Create metabox options for testimonial.
 *
 * @package	cleona
 */
function cleona_metabox_testimonial( $metabox ) {
	$metabox[] = array(
		'id'			=> 'cleona_testimonial_details',
		'title'			=> esc_html__( 'Details', 'cleona-plugins' ),
		'post_types'	=> array( 'testimonial' ),
		'context'		=> 'normal',
		'priority'		=> 'high',
		'fields'		=> array(
			array(
				'name'			=> esc_html__( 'Headline', 'cleona-plugins' ),
				'id'			=> 'cleona_testimonial_headline',
				'type'			=> 'text',
				'attributes'	=> array(
					'readonly'	=> true,
				)
			),
			array(
				'name'			=> esc_html__( 'Content', 'cleona-plugins' ),
				'id'			=> 'cleona_testimonial_content',
				'type'			=> 'textarea',
				'rows'			=> 8,
				'attributes'	=> array(
					'readonly'	=> true,
				)
			),
			array(
				'name'			=> esc_html__( 'Rating', 'cleona-plugins' ),
				'id'			=> 'cleona_testimonial_rating',
				'type'			=> 'text',
				'size'			=> 5,
				'attributes'	=> array(
					'readonly'	=> true,
				)
			),
		)
	);

	return $metabox;
}
add_filter( 'rwmb_meta_boxes', 'cleona_metabox_testimonial' );

/**
 * Create function save via frontend.
 */
function cleona_plugin_insert_testimonial() {
	$name		= isset( $_POST['customer_name'] ) ? $_POST['customer_name'] : '';
	$headline	= isset( $_POST['customer_headline'] ) ? $_POST['customer_headline'] : '';
	$content	= isset( $_POST['customer_message'] ) ? $_POST['customer_message'] : '';
	$rate		= isset( $_POST['customer_rate'] ) ? $_POST['customer_rate'] : '';

	if ( isset( $_POST['submitted'] ) && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' ) ) {
		$post_information = array(
			'post_title'	=> wp_strip_all_tags( $name ),
			'post_type'		=> 'testimonial',
			'post_status'	=> 'pending'
		);
		$testimonial_id = wp_insert_post( $post_information );

		if ( $testimonial_id ) {
			// Headline Metabox
			update_post_meta( $testimonial_id, 'cleona_testimonial_headline', wp_strip_all_tags( $headline ) );
			// Content Metabox
			update_post_meta( $testimonial_id, 'cleona_testimonial_content', wp_strip_all_tags( $content ) );
			// Rating Metabox
			update_post_meta( $testimonial_id, 'cleona_testimonial_rating', wp_strip_all_tags( $rate ) );

			wp_redirect( add_query_arg( 'success', 1, get_permalink( get_the_id() ) ) );
			exit;
		}
	}
}