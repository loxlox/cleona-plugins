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

		if ( $( window ).width() > 480 ) {
			var currentTallest	= 0,
				currentRowStart	= 0,
				currentDiv		= 0,
				rowDivs			= new Array(),
				$el,
				topPosition		= 0;

			$( '.cleona-content .cleona-widget-post .type-post, .cleona-content .cleona-widget-post .type-product' ).each( function() {
				$el			= $( this );
				topPosition = $el.position().top;
				if ( currentRowStart != topPosition ) {
					// we just came to a new row.  Set all the heights on the completed row
					for ( currentDiv = 0 ; currentDiv < rowDivs.length; currentDiv++ ) {
						rowDivs[currentDiv].css( 'height', currentTallest + 'px' );
					}
					// set the variables for the new row
					rowDivs.length 	= 0; // empty the array
					currentRowStart = topPosition;
					currentTallest 	= $el.height();
					rowDivs.push( $el );
				} else {
					// another div on the current row.  Add it to the list and check if it's taller
					rowDivs.push( $el );
					currentTallest = ( currentTallest < $el.height() ) ? ( $el.height() ) : ( currentTallest );
				}
				// do the last row
				for ( currentDiv = 0; currentDiv < rowDivs.length; currentDiv++ ) {
					rowDivs[currentDiv].css( 'height', currentTallest + 'px' );
				}
			} );
		}
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