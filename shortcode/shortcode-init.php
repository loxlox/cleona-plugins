<?php
if ( !defined( 'ABSPATH' ) ) die( '-1' );


/**
 * Build VC mapper for custom shortcode
 *
 * Table of Content
 * 
 * 1. Widget About Me
 * 2. Widget Ads
 * 3. Widget Banner
 * 4. Widget Post
 * 5. Widget Product
 * 6. Widget Testimonial
 */

if ( class_exists( 'Vc_Manager' ) ) {
	/**
	 * 1. Widget About Me
	 */
	vc_map( array(
		'name'			=> esc_html__( 'Cleona About Me', 'cleona-plugins' ),
		'base'			=> 'cleona_sc_about_me',
		'category'		=> 'Cleona',
		'icon'			=> 'icon-wpb-wp',
		'description'	=> esc_html__( 'Create Short About', 'cleona-plugins' ),
		'js_view'		=> 'cleonaAboutMeView',
		'params'		=> array(
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Widget title', 'cleona-plugins' ),
				'param_name'	=> 'title',
				'value'			=> '',
				'description'	=> esc_html__( 'What text use as a widget title. Leave blank to use default widget title.', 'cleona-plugins' ),
				'admin_label'	=> true
			),
			array(
				'type'			=> 'attach_image',
				'heading'		=> esc_html__( 'Image icon', 'cleona-plugins' ),
				'admin_label'	=> true,
				'param_name'	=> 'image'
			),
			array(
				'type'			=> 'textarea_html',
				'heading'		=> esc_html__( 'Description', 'cleona-plugins' ),
				'admin_label'	=> true,
				'param_name'	=> 'description'
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Read more', 'cleona-plugins' ),
				'admin_label'	=> true,
				'description'	=> esc_html__( 'Paste URL here.', 'cleona-plugins' ),
				'param_name'	=> 'read_more'
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Element ID', 'cleona-plugins' ),
				'param_name'	=> 'el_id',
				'value'			=> '',
				'description'	=> wp_kses( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="http://www.w3schools.com/tags/att_global_id.asp">w3c specification</a>).', 'cleona-plugins' ), array( 'a' => array( 'href' => array() ) ) ),
				'admin_label'	=> true
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Extra class name', 'cleona-plugins' ),
				'param_name'	=> 'el_class',
				'value'			=> '',
				'description'	=> esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'cleona-plugins' ),
				'admin_label'	=> true
			),
		)
	) );

	/**
	 * 2. Widget Ads
	 */
	vc_map( array(
		'name'			=> esc_html__( 'Cleona Advertise', 'cleona-plugins' ),
		'base'			=> 'cleona_sc_ads',
		'category'		=> 'Cleona',
		'icon'			=> 'icon-wpb-wp',
		'description'	=> esc_html__( 'Create Advertise', 'cleona-plugins' ),
		'js_view'		=> 'cleonaAdsView',
		'params'		=> array(
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Widget title', 'cleona-plugins' ),
				'param_name'	=> 'title',
				'value'			=> '',
				'description'	=> esc_html__( 'What text use as a widget title. Leave blank to use default widget title.', 'cleona-plugins' ),
				'admin_label'	=> true
			),
			array(
				'type'			=> 'attach_image',
				'heading'		=> esc_html__( 'Image', 'cleona-plugins' ),
				'admin_label'	=> true,
				'param_name'	=> 'image'
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Image alt', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> esc_html__( 'Advertisement', 'cleona-plugins' ),
				'description'	=> esc_html__( 'Image Alt Attribute.', 'cleona-plugins' ),
				'param_name'	=> 'alt'
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Link URL', 'cleona-plugins' ),
				'admin_label'	=> true,
				'description'	=> esc_html__( 'Paste URL here.', 'cleona-plugins' ),
				'param_name'	=> 'href'
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Element ID', 'cleona-plugins' ),
				'param_name'	=> 'el_id',
				'value'			=> '',
				'description'	=> wp_kses( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="http://www.w3schools.com/tags/att_global_id.asp">w3c specification</a>).', 'cleona-plugins' ), array( 'a' => array( 'href' => array() ) ) ),
				'admin_label'	=> true
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Extra class name', 'cleona-plugins' ),
				'param_name'	=> 'el_class',
				'value'			=> '',
				'description'	=> esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'cleona-plugins' ),
				'admin_label'	=> true
			),
		)
	) );

	/**
	 * 3. Widget Banner
	 */
	$cat_banner	= array();
	$terms		= get_terms( 'banner_category' );
	if ( is_array( $terms ) && ( count( $terms ) > 0 ) ) {
		$cat_banner[] = esc_html__( 'Select Category', 'cleona-plugins' );
		foreach ( $terms as $k => $v ) {
			$cat_banner[ $v->name ] = $v->slug;
		}
	}
	vc_map( array(
		'name'			=> esc_html__( 'Cleona Banner Image', 'cleona-plugins' ),
		'base'			=> 'cleona_sc_banner_image',
		'category'		=> 'Cleona',
		'icon'			=> 'icon-wpb-wp',
		'description'	=> esc_html__( 'Create Banner Image', 'cleona-plugins' ),
		'js_view'		=> 'cleonaBannerImageView',
		'params'		=> array(
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Widget title', 'cleona-plugins' ),
				'param_name'	=> 'title',
				'value'			=> '',
				'description'	=> esc_html__( 'What text use as a widget title. Leave blank to use default widget title.', 'cleona-plugins' ),
				'admin_label'	=> true
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Category', 'cleona-plugins' ),
				'admin_label'	=> true,
				'description'	=> esc_html__( 'Choose category to show.', 'cleona-plugins' ),
				'param_name'	=> 'type',
				'value'			=> $cat_banner
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Item shown', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> '3',
				'param_name'	=> 'shown'
			),
			array(
				'type'			=> 'checkbox',
				'heading'		=> esc_html__( 'Show as slider', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> array( esc_html__( 'Yes', 'cleona-plugins' ) => 'on' ),
				'param_name'	=> 'slide'
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Element ID', 'cleona-plugins' ),
				'param_name'	=> 'el_id',
				'value'			=> '',
				'description'	=> wp_kses( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="http://www.w3schools.com/tags/att_global_id.asp">w3c specification</a>).', 'cleona-plugins' ), array( 'a' => array( 'href' => array() ) ) ),
				'admin_label'	=> true
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Extra class name', 'cleona-plugins' ),
				'param_name'	=> 'el_class',
				'value'			=> '',
				'description'	=> esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'cleona-plugins' ),
				'admin_label'	=> true
			),
		)
	) );

	/**
	 * 4. Widget Post
	 */
	$cat_post	= array();
	$terms		= get_terms( 'category' );
	if ( is_array( $terms ) && ( count( $terms ) > 0 ) ) {
		$cat_post[] = esc_html__( 'Select Category', 'cleona-plugins' );
		foreach ( $terms as $k => $v ) {
			$cat_post[ $v->name ] = $v->slug;
		}
	}
	vc_map( array(
		'name'			=> esc_html__( 'Cleona Custom Post', 'cleona-plugins' ),
		'base'			=> 'cleona_sc_post',
		'category'		=> 'Cleona',
		'icon'			=> 'icon-wpb-wp',
		'description'	=> esc_html__( 'Show post with image', 'cleona-plugins' ),
		'js_view'		=> 'cleonaPostImageView',
		'params'		=> array(
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Widget title', 'cleona-plugins' ),
				'param_name'	=> 'title',
				'value'			=> '',
				'description'	=> esc_html__( 'What text use as a widget title. Leave blank to use default widget title.', 'cleona-plugins' ),
				'admin_label'	=> true
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Category', 'cleona-plugins' ),
				'admin_label'	=> true,
				'description'	=> esc_html__( 'Choose category to show.', 'cleona-plugins' ),
				'param_name'	=> 'type',
				'value'			=> $cat_post
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Item shown', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> '3',
				'param_name'	=> 'shown'
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Order post by', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> array(
					esc_html__( 'Select Order',	'cleona-plugins' )	=> '',
					esc_html__( 'Comment',		'cleona-plugins' )	=> 'comment_count',
					esc_html__( 'Date',			'cleona-plugins' )	=> 'date',
					esc_html__( 'Random',		'cleona-plugins' )	=> 'rand'
				),
				'param_name'	=> 'orderby'
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Sort post by', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> array(
					esc_html__( 'Select Order',	'cleona-plugins' )	=> '',
					esc_html__( 'DESC',			'cleona-plugins' )	=> 'desc',
					esc_html__( 'ASC',			'cleona-plugins' )	=> 'asc'
				),
				'param_name'	=> 'sortby'
			),
			array(
				'type'			=> 'checkbox',
				'heading'		=> esc_html__( 'Show as big post', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> array(
					esc_html__( 'Yes', 'cleona-plugins' ) => TRUE
				),
				'param_name'	=> 'big_size'
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Element ID', 'cleona-plugins' ),
				'param_name'	=> 'el_id',
				'value'			=> '',
				'description'	=> wp_kses( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="http://www.w3schools.com/tags/att_global_id.asp">w3c specification</a>).', 'cleona-plugins' ), array( 'a' => array( 'href' => array() ) ) ),
				'admin_label'	=> true
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Extra class name', 'cleona-plugins' ),
				'param_name'	=> 'el_class',
				'value'			=> '',
				'description'	=> esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'cleona-plugins' ),
				'admin_label'	=> true
			),
		)
	) );

	/**
	 * 5. Widget Product
	 */
	vc_map( array(
		'name'			=> esc_html__( 'Cleona Custom Product', 'cleona-plugins' ),
		'base'			=> 'cleona_sc_product',
		'category'		=> 'Cleona',
		'icon'			=> 'icon-wpb-wp',
		'description'	=> esc_html__( 'Show product with image', 'cleona-plugins' ),
		'js_view'		=> 'cleonaPostImageView',
		'params'		=> array(
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Widget title', 'cleona-plugins' ),
				'param_name'	=> 'title',
				'value'			=> '',
				'description'	=> esc_html__( 'What text use as a widget title. Leave blank to use default widget title.', 'cleona-plugins' ),
				'admin_label'	=> true
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Item shown', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> '6',
				'param_name'	=> 'shown'
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Item coloumns', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> '6',
				'description'	=> esc_html__( 'Max coloumns is 6 rows.', 'cleona-plugins' ),
				'param_name'	=> 'coloumn'
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Display by', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> array(
					esc_html__( 'All products',			'cleona-plugins' )	=> '',
					esc_html__( 'Featured products',	'cleona-plugins' )	=> 'featured',
					esc_html__( 'On-sale products',		'cleona-plugins' )	=> 'onsale'	
				),
				'param_name'	=> 'display'
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Order post by', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> array(
					esc_html__( 'Select Order',	'cleona-plugins' )	=> '',
					esc_html__( 'Price',		'cleona-plugins' )	=> 'price',
					esc_html__( 'Sales',		'cleona-plugins' )	=> 'sales',
					esc_html__( 'Date',			'cleona-plugins' )	=> 'date',
					esc_html__( 'Random',		'cleona-plugins' )	=> 'rand'
				),
				'param_name'	=> 'orderby'
			),
			array(
				'type'			=> 'dropdown',
				'heading'		=> esc_html__( 'Sort post by', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> array(
					esc_html__( 'Select Order',	'cleona-plugins' )	=> '',
					esc_html__( 'DESC',			'cleona-plugins' )	=> 'desc',
					esc_html__( 'ASC',			'cleona-plugins' )	=> 'asc'
				),
				'param_name'	=> 'order'
			),
			array(
				'type'			=> 'checkbox',
				'heading'		=> esc_html__( 'Hide free product', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> array( esc_html__( 'Yes', 'cleona-plugins' ) => false ),
				'param_name'	=> 'hide_free'
			),
			array(
				'type'			=> 'checkbox',
				'heading'		=> esc_html__( 'Show hidden item(s)', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> array( esc_html__( 'Yes', 'cleona-plugins' ) => false ),
				'param_name'	=> 'hidden'
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Element ID', 'cleona-plugins' ),
				'param_name'	=> 'el_id',
				'value'			=> '',
				'description'	=> wp_kses( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="http://www.w3schools.com/tags/att_global_id.asp">w3c specification</a>).', 'cleona-plugins' ), array( 'a' => array( 'href' => array() ) ) ),
				'admin_label'	=> true
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Extra class name', 'cleona-plugins' ),
				'param_name'	=> 'el_class',
				'value'			=> '',
				'description'	=> esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'cleona-plugins' ),
				'admin_label'	=> true
			),
		)
	) );

	/**
	 * 6. Widget Testimonial
	 */
	vc_map( array(
		'name'			=> esc_html__( 'Cleona Custom Product', 'cleona-plugins' ),
		'base'			=> 'cleona_sc_product',
		'category'		=> 'Cleona',
		'icon'			=> 'icon-wpb-wp',
		'description'	=> esc_html__( 'Show product with image', 'cleona-plugins' ),
		'js_view'		=> 'cleonaPostImageView',
		'params'		=> array(
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Widget title', 'cleona-plugins' ),
				'param_name'	=> 'title',
				'value'			=> '',
				'description'	=> esc_html__( 'What text use as a widget title. Leave blank to use default widget title.', 'cleona-plugins' ),
				'admin_label'	=> true
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Item shown', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> '6',
				'param_name'	=> 'shown'
			),
			array(
				'type'			=> 'checkbox',
				'heading'		=> esc_html__( 'Show as slider', 'cleona-plugins' ),
				'admin_label'	=> true,
				'value'			=> array( esc_html__( 'Yes', 'cleona-plugins' ) => true ),
				'param_name'	=> 'slide'
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Element ID', 'cleona-plugins' ),
				'param_name'	=> 'el_id',
				'value'			=> '',
				'description'	=> wp_kses( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="http://www.w3schools.com/tags/att_global_id.asp">w3c specification</a>).', 'cleona-plugins' ), array( 'a' => array( 'href' => array() ) ) ),
				'admin_label'	=> true
			),
			array(
				'type'			=> 'textfield',
				'heading'		=> esc_html__( 'Extra class name', 'cleona-plugins' ),
				'param_name'	=> 'el_class',
				'value'			=> '',
				'description'	=> esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'cleona-plugins' ),
				'admin_label'	=> true
			),
		)
	) );
}