<?php
if ( !defined( 'ABSPATH' ) ) die( '-1' );

function cleona_widget_banner_image( $atts, $content = null ) {
	$title = $type = $shown = $slide = $output = '';
	extract( shortcode_atts(
		array(
			'title'		=> '',
			'type'		=> '',
			'shown'		=> '3',
			'slide'		=> '',
			'el_class'	=> '',
			'el_id'		=> ''
		),
		$atts
	) );

	$args	= array();
	$widget	= 'cleona_banner';

	$wrapper_attributes = array();
	if ( ! empty( $el_id ) ) {
		$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
	}
	$output = '<div ' . implode( ' ', $wrapper_attributes ) . ' class="vc_cleona_banner wpb_content_element ' . esc_attr( $el_class ) . '">';

	global $wp_widget_factory;
	// to avoid unwanted warnings let's check before using widget
	if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $widget ] ) ) {
		ob_start();
		the_widget( $widget, $atts, $args );
		$output .= ob_get_clean();

		$output .= '</div>';

		return $output;
	}
}
add_shortcode( 'cleona_sc_banner_image', 'cleona_widget_banner_image' );