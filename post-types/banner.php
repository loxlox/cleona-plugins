<?php
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Register a banner post type.
 *
 * @link	http://codex.wordpress.org/Function_Reference/register_post_type
 * @package cleona plugins
 */
function cleona_banner_post_type() {
	$labels = array(
		'name'					=> esc_html__( 'Banners',						'cleona-plugins' ),
		'singular_name'			=> esc_html__( 'Banner',						'cleona-plugins' ),
		'menu_name'				=> esc_html__( 'Banners',						'cleona-plugins' ),
		'name_admin_bar'		=> esc_html__( 'Banner',						'cleona-plugins' ),
		'add_new'				=> esc_html__( 'Add New',						'cleona-plugins' ),
		'add_new_item'			=> esc_html__( 'Add New Banner',				'cleona-plugins' ),
		'new_item'				=> esc_html__( 'New Banner',					'cleona-plugins' ),
		'edit_item'				=> esc_html__( 'Edit Banner',					'cleona-plugins' ),
		'view_item'				=> esc_html__( 'View Banner',					'cleona-plugins' ),
		'all_items'				=> esc_html__( 'All Banners',					'cleona-plugins' ),
		'search_items'			=> esc_html__( 'Search Banners',				'cleona-plugins' ),
		'parent_item_colon'		=> esc_html__( 'Parent Banners',				'cleona-plugins' ),
		'not_found'				=> esc_html__( 'No banners found.',				'cleona-plugins' ),
		'not_found_in_trash'	=> esc_html__( 'No banners found in trash.',	'cleona-plugins' )
	);

	$args = array(
		'labels'				=> $labels,
		'description'			=> esc_html__( 'Display banner image.',			'cleona-plugins' ),
		'public'				=> true,
		'publicly_queryable'	=> false,
		'exclude_from_search'	=> true,
		'show_ui'				=> true,
		'show_in_menu'			=> true,
		'menu_position'			=> 30,
		'menu_icon'				=> 'dashicons-format-image',
		'query_var'				=> true,
		'rewrite'				=> array( 'slug' => 'banner' ),
		'capability_type'		=> 'post',
		'has_archive'			=> false,
		'hierarchical'			=> false,
		'menu_position'			=> null,
		'supports'				=> array( 'title' )
	);

	register_post_type( 'banner', $args );
}
add_action( 'init', 'cleona_banner_post_type', 999 );

/**
 * Register a banner category taxonomy.
 *
 * @link	https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @package cleona plugins
 */
function create_banner_cateogry_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'				=> esc_html__( 'Categories',		'cleona-plugins' ),
		'singular_name'		=> esc_html__( 'Category',			'cleona-plugins' ),
		'search_items'		=> esc_html__( 'Search Categories',	'cleona-plugins' ),
		'all_items'			=> esc_html__( 'All Categories',	'cleona-plugins' ),
		'parent_item'		=> esc_html__( 'Parent Category',	'cleona-plugins' ),
		'parent_item_colon'	=> esc_html__( 'Parent Category',	'cleona-plugins' ),
		'edit_item'			=> esc_html__( 'Edit Category',		'cleona-plugins' ),
		'update_item'		=> esc_html__( 'Update Category',	'cleona-plugins' ),
		'add_new_item'		=> esc_html__( 'Add New Category',	'cleona-plugins' ),
		'new_item_name'		=> esc_html__( 'New Category Name',	'cleona-plugins' ),
		'menu_name'			=> esc_html__( 'Category',			'cleona-plugins' ),
	);

	$args = array(
		'hierarchical'		=> true,
		'labels'			=> $labels,
		'show_ui'			=> true,
		'show_admin_column'	=> true,
		'query_var'			=> true,
		'rewrite'			=> array( 'slug' => 'banner_category' ),
	);

	register_taxonomy( 'banner_category', array( 'banner' ), $args );
}
add_action( 'init', 'create_banner_cateogry_taxonomies', 0 );

/**
 * Create metabox options for banner image.
 *
 * @package	cleona
 */
function cleona_metabox_banner_image( $metabox ) {
	$metabox[] = array(
		'id'			=> 'cleona_banner_details',
		'title'			=> esc_html__( 'Details', 'cleona-plugins' ),
		'post_types'	=> array( 'banner' ),
		'context'		=> 'normal',
		'priority'		=> 'high',
		'fields'		=> array(
			array(
				'name'				=> esc_html__( 'Subtitle', 'cleona-plugins' ),
				'id'				=> 'cleona_banner_subtitle',
				'type'				=> 'text'
			),
			array(
				'name'				=> esc_html__( 'Image', 'cleona-plugins' ),
				'id'				=> 'cleona_banner_image',
				'type'				=> 'file_advanced',
				'max_file_uploads'	=> 1,
				'mime_type'			=> 'image'
			),
			array(
				'name'				=> esc_html__( 'Content', 'cleona-plugins' ),
				'id'				=> 'cleona_banner_content',
				'type'				=> 'textarea',
				'rows'				=> 6
			),
			array(
				'name'				=> esc_html__( 'URL Text', 'cleona-plugins' ),
				'id'				=> 'cleona_banner_url_text',
				'type'				=> 'text'
			),
			array(
				'name'				=> esc_html__( 'URL', 'cleona-plugins' ),
				'id'				=> 'cleona_banner_url',
				'type'				=> 'text'
			),
			array(
				'name'				=> esc_html__( 'Button Text Color', 'cleona-plugins' ),
				'id'				=> 'cleona_banner_button_txt_color',
				'type'				=> 'color'
			),
			array(
				'name'				=> esc_html__( 'Button Text Hover Color', 'cleona-plugins' ),
				'id'				=> 'cleona_banner_button_txt_hover_color',
				'type'				=> 'color'
			),
			array(
				'name'				=> esc_html__( 'Button Background Color', 'cleona-plugins' ),
				'id'				=> 'cleona_banner_button_bg_color',
				'type'				=> 'color'
			),
			array(
				'name'				=> esc_html__( 'Button Background Hover Color', 'cleona-plugins' ),
				'id'				=> 'cleona_banner_button_bg_hover_color',
				'type'				=> 'color'
			),
		)
	);

	return $metabox;
}
add_filter( 'rwmb_meta_boxes', 'cleona_metabox_banner_image' );