<?php
if ( !defined( 'ABSPATH' ) ) die( '-1' );

function cleona_widget_post( $atts, $content = null ) {
	$title = $type = $shown = $orderby = $sortby = $output = '';
	extract( shortcode_atts(
		array(
			'title'		=> '',
			'type'		=> '',
			'shown'		=> '3',
			'orderby'	=> '',
			'sortby'	=> '',
			'big_size'	=> '',
			'el_class'	=> '',
			'el_id'		=> ''
		),
		$atts
	) );

	$args	= array();
	$widget	= 'cleona_custom_post';

	$wrapper_attributes = array();
	if ( ! empty( $el_id ) ) {
		$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
	}
	$output = '<div ' . implode( ' ', $wrapper_attributes ) . ' class="vc_cleona_post wpb_content_element ' . esc_attr( $el_class ) . '">';

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
add_shortcode( 'cleona_sc_post', 'cleona_widget_post' );