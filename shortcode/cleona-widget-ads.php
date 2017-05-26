<?php
if ( !defined( 'ABSPATH' ) ) die( '-1' );

function cleona_widget_ads( $atts, $content = null ) {
	$title = $image = $href = $alt = $output = '';
	extract( shortcode_atts(
		array(
			'title'		=> '',
			'image'		=> '',
			'href'		=> '',
			'alt'		=> '',
			'el_class'	=> '',
			'el_id'		=> ''
		),
		$atts
	) );

	$args			= array();
	$type			= 'cleona_advertise';
	$image_url		= wp_get_attachment_image_src( $atts['image'], 'full' );
	$atts['image']	= $image_url[0];

	$wrapper_attributes = array();
	if ( ! empty( $el_id ) ) {
		$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
	}
	$output = '<div ' . implode( ' ', $wrapper_attributes ) . ' class="vc_cleona_ads wpb_content_element ' . esc_attr( $el_class ) . '">';

	global $wp_widget_factory;
	// to avoid unwanted warnings let's check before using widget
	if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
		ob_start();
		the_widget( $type, $atts, $args );
		$output .= ob_get_clean();

		$output .= '</div>';

		return $output;
	}
}
add_shortcode( 'cleona_sc_ads', 'cleona_widget_ads' );