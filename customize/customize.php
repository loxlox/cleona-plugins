<?php
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Register customize option.
 *
 * @package cleona plugins
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( !function_exists( 'cleona_plugins_customize_register' ) ) {
	function cleona_plugins_customize_register( $customize ) {
		/* Google's: Analytics */
		$customize->add_setting( 'cleona_google_analytic', array(
			'sanitize_callback'	=> 'wp_kses_post'
		) );
		$customize->add_control( new WP_Customize_Control( $customize, 'cleona_google_analytic', array(
			'label'				=> esc_html__( 'Google Analytics', 'cleona' ),
			'section'			=> 'cleona_google_setting',
			'settings'			=> 'cleona_google_analytic',
			'description'		=> sprintf( wp_kses( __( 'Get Embed Code <a href="%s" target="_blank">here</a>.', 'cleona' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://analytics.google.com' ) ),
			'type'				=> 'textarea'
		) ) );
	}
	add_action( 'customize_register', 'cleona_plugins_customize_register' );
}

/**
 * Add google analytics to footer.
 */
if ( !function_exists( 'cleona_plugins_google_analytic' ) ) {
	function cleona_plugins_google_analytic() {
		echo sprintf(
			wp_kses( '<script id="cleona-analytic" type="text/javascript">%s</script>', array(
				'script' => array(
					'id'	=> array(),
					'type'	=> array()
				)
			) ),
			get_theme_mod( 'cleona_google_analytic' )
		);
	}
	add_action( 'wp_enqueue_scripts', 'cleona_plugins_google_analytic', 999 );
}