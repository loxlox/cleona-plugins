<?php
/**
 * Plugin Name:	Cleona Extentions
 * Description:	Package core for cleona theme template.
 * Version:		1.0.2
 * Author:		ARThemewipes
 * Author URI:	http://themeforest.net/user/arthemewipes
 * Copyright: 	(c) 2017 ARTheme.
 * Text Domain:	cleona-plugins
 * License: 	GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( !class_exists( 'Cleona_Plugins' ) ) {
	class Cleona_Plugins {

		/**
		 * Cleona Plugins Construct.
		 */
		function Cleona_Plugins()  {
			add_action( 'wp_enqueue_scripts', array( &$this, 'cleona_plugins_enqueue_script_front' ), 1000 );
			add_action( 'admin_enqueue_scripts', array( &$this, 'cleona_plugins_enqueue_script_admin' ) );
			add_action( 'auth_redirect', array( &$this, 'cleona_add_pending_count_filter' ) );
			add_action( 'admin_menu', array( &$this, 'cleona_esc_attr_restore' ) );
			add_action( 'init', array( &$this, 'call_require_files' ) );
		}

		/**
		 * Enqueue plugin front-end script file.
		 *
		 * @package Cleona Extentions
		 */
		function cleona_plugins_enqueue_script_front() {
			/* Stylesheet */
			wp_enqueue_style( 'cleona-plugins', plugin_dir_url( __FILE__ ) . 'assets/css/cleona-plugins.min.css', NULL, '1.0.0', 'all' );

			/* Javascript */
			wp_enqueue_script( 'cleona-libraries-plugins', plugin_dir_url( __FILE__ ) . 'assets/js/libraries.js', array( 'jquery' ), '1.0.0', true );
			wp_enqueue_script( 'cleona-custom-plugins', plugin_dir_url( __FILE__ ) . 'assets/js/plugins.min.js', array( 'jquery' ), '1.0.0', true );
		}

		/**
		 * Enqueue plugin back-end script file.
		 *
		 * @package cleona
		 */
		function cleona_plugins_enqueue_script_admin() {
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

		/**
		 * Call plugin files.
		 *
		 * @package Cleona Extentions
		 */
		function call_require_files() {
			/**
			 * Call shortcode files.
			 */
			require_once plugin_dir_path( __FILE__ ) . '/shortcode/shortcode-init.php';
			require_once plugin_dir_path( __FILE__ ) . '/shortcode/cleona-widget-about-me.php';
			require_once plugin_dir_path( __FILE__ ) . '/shortcode/cleona-widget-ads.php';
			require_once plugin_dir_path( __FILE__ ) . '/shortcode/cleona-widget-banner.php';
			require_once plugin_dir_path( __FILE__ ) . '/shortcode/cleona-widget-post.php';
			require_once plugin_dir_path( __FILE__ ) . '/shortcode/cleona-widget-product.php';
			require_once plugin_dir_path( __FILE__ ) . '/shortcode/cleona-widget-testimonial.php';
		}

		/**
		 * Create function to add pending status
		 * 
		 * @package Cleona Extentions
		 */
		function cleona_add_pending_count_filter() {
			add_filter( 'attribute_escape', array( &$this, 'cleona_remove_esc_attr_and_count' ), 20, 2 );
		}
		function cleona_esc_attr_restore() {
			remove_filter( 'attribute_escape', array( &$this, 'cleona_remove_esc_attr_and_count' ), 20, 2 );
		}
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
	}
}
$Cleona_Plugins = new Cleona_Plugins();

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
 * Call customize files.
 */
require_once plugin_dir_path( __FILE__ ) . '/customize/customize.php';

/**
 * Call widget files.
 */
require_once plugin_dir_path( __FILE__ ) . '/widgets/about-me.php';
require_once plugin_dir_path( __FILE__ ) . '/widgets/custom-post.php';
require_once plugin_dir_path( __FILE__ ) . '/widgets/ads.php';
require_once plugin_dir_path( __FILE__ ) . '/widgets/banner.php';
require_once plugin_dir_path( __FILE__ ) . '/widgets/testimonial.php';
require_once plugin_dir_path( __FILE__ ) . '/widgets/custom-product.php';