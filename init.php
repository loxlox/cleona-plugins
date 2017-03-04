<?php
/**
 * Plugin Name:	Cleona Extentions
 * Description:	Package core for cleona theme template.
 * Version:		1.0.0
 * Author:		ARThemewipes
 * Author URI:	http://themeforest.net/user/arthemewipes
 * Copyright: 	(c) 2017 ARTheme.
 * Text Domain:	cleona-plugins
 * License: 	GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


/**
 * Call template files.
 */
require_once plugin_dir_path( __FILE__ ) . '/templates/templates.php';

/**
 * Call custom post type Files.
 */
require_once plugin_dir_path( __FILE__ ) . '/post-types/banner.php';
require_once plugin_dir_path( __FILE__ ) . '/post-types/testimonial.php';

/**
 * Call widget files.
 */
require_once plugin_dir_path( __FILE__ ) . '/widgets/about-me.php';
require_once plugin_dir_path( __FILE__ ) . '/widgets/custom-post.php';
require_once plugin_dir_path( __FILE__ ) . '/widgets/ads.php';
require_once plugin_dir_path( __FILE__ ) . '/widgets/banner.php';
require_once plugin_dir_path( __FILE__ ) . '/widgets/testimonial.php';

/**
 * Enqueue plugin script file.
 * 
 * @package cleona
 */
if ( !function_exists( 'cleona_plugins_enqueue_script' ) ) {
	function cleona_plugins_enqueue_script() {
		/* Stylesheet */
		wp_enqueue_style( 'cleona-plugins', plugin_dir_url( __FILE__ ) . 'assets/css/cleona-plugins.min.css', NULL, '1.0.0', 'all' );

		/* Javascript */
		wp_enqueue_script( 'cleona-libraries-plugins', plugin_dir_url( __FILE__ ) . 'assets/js/libraries.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'cleona-custom-plugins', plugin_dir_url( __FILE__ ) . 'assets/js/plugins.min.js', array( 'jquery' ), '1.0.0', true );
	}
	add_action( 'wp_enqueue_scripts', 'cleona_plugins_enqueue_script', 1000 );
}

/**
 * Enqueue plugin script file in admin area.
 * 
 * @package cleona
 */
if ( !function_exists( 'cleona_plugins_admin_area_script' ) ) {
	function cleona_plugins_admin_area_script() {
		global $pagenow;

		if ( in_array( $pagenow, array( 'widgets.php' ) ) ) {
			if ( get_bloginfo( 'version' ) >= 3.5 ) {
				wp_enqueue_media();
			} else {
				wp_enqueue_style( 'thickbox' );
				wp_enqueue_script( 'thickbox' );
			}
			wp_enqueue_script( 'cleona-plugin-admin', plugin_dir_url( __FILE__ ) . 'assets/js/admin.min.js', array( 'jquery' ), '1.0.0', true );
			wp_localize_script( 'cleona-plugin-admin', 'cleonaString', apply_filters( 'ar-localize', array(
				'version' => get_bloginfo( 'version' )
			) ) );
		}
	}
	add_action( 'admin_enqueue_scripts', 'cleona_plugins_admin_area_script' );
}

/**
 * Create function to add pending status
 */
function cleona_add_pending_count_filter() {
	add_filter( 'attribute_escape', 'cleona_remove_esc_attr_and_count', 20, 2 );
}
add_action( 'auth_redirect', 'cleona_add_pending_count_filter' );

function cleona_esc_attr_restore() {
	remove_filter( 'attribute_escape', 'cleona_remove_esc_attr_and_count', 20, 2 );
}
add_action( 'admin_menu', 'cleona_esc_attr_restore' );

function cleona_remove_esc_attr_and_count( $safe_text = '', $text = '' ) {
	if ( substr_count( $text, '%%PENDING%%' ) ) {
		$text		= trim( str_replace( '%%PENDING%%', '', $text ) );
		remove_filter( 'attribute_escape', 'cleona_remove_esc_attr_and_count', 20, 2 );
		$safe_text	= esc_attr( $text );
		$count		= (int)wp_count_posts( 'testimonial', 'readable' )->pending;
		if ( $count > 0 ) {
			$text = esc_attr( $text ) . ' <span class="awaiting-mod count-' . $count . '"><span class="pending-count">' . $count . '</span></span>';
			return $text;
		} 
	}
	return $safe_text;
}