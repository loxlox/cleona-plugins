<?php

function cleona_widget_about_me( $atts, $content = null ) {
	extract( shortcode_atts(
		array(
			'top'    => '20',
			'bottom' => '20',
			'type'   => 'solid',
			'color'  => '#eeeeee',
			'align'  => 'left',
			'width'  => '',
			'height' => ''
		), $atts )
	);

}
add_shortcode( 'cleona_sc_about_me', 'cleona_widget_about_me' );