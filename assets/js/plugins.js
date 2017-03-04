jQuery( document ).ready( function( $ ) {
	'use script';

	/**
	 *	Table of Content
	 *	1. Rating
	 *	2. Testimonial
	 *	3. Homepage
	 *	
	 *	Fire up function script
	 */

	/**
	 * 1. Rating
	 */
	function cleona_plugins_rating() {
		$( '#customer_rate' ).barrating( {
			theme: 'fontawesome-stars'
		} );
	}

	/**
	 * 2. Testimonial
	 */
	function cleona_testimonial_slider() {
		$( '.testimonial-rating' ).each( function() {
			$( this ).barrating( {
				theme: 'fontawesome-stars',
				readonly: true
			} );
		} );
		var swiper = new Swiper( '.cleona-testimonial-slider', {
			centeredSlides: true,
			autoheight: true,
			autoplay: 2500,
			autoplayDisableOnInteraction: false
		} );
	}

	/**
	 * 3. Homepage
	 */
	function cleona_homepage_banner_slider() {
		var swiper = new Swiper( '.cleona-banner-slider', {
			nextButton: '.swiper-button-next',
			prevButton: '.swiper-button-prev',
			slidesPerView: 1,
			spaceBetween: 0
		} );
	}
	
	/**
	 * Fire up function script
	 */
	function cleona_plugin_fire_script() {
		cleona_plugins_rating();
		cleona_testimonial_slider();
		cleona_homepage_banner_slider();
	}
	cleona_plugin_fire_script();
} );