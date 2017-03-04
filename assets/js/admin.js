jQuery( document ).ready( function( $ ) { "use strict";

	/* Category Image Media Uploader */
	var wordpress_ver = cleonaString.version, 
		upload_button,
		frame;

		$( '.upload_image_button' ).click( function( event ) {

			if ( wordpress_ver >= '3.5' ) {
				event.preventDefault();
				if ( frame ) {
					frame.open();
					return;
				}

				frame = wp.media();

				frame.on( 'select', function() {
					// Grab the selected attachment.
					var attachment = frame.state().get( 'selection' ).first();
					frame.close();

					// if ( $( this ).parent().prev().children().hasClass( 'tax_list' ) ) {
					// 	$( this ).parent().prev().children().val( attachment.attributes.url );
					// 	$( this ).parent().prev().prev().children().attr( 'src', attachment.attributes.url );
					// } else {
						
					// }
					$( '.cleona-image-url' ).val( attachment.attributes.url );
				} );

				frame.open();

			} else {
				tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
				return false;
			}
		} );

		$( '.remove_image_button' ).click( function() {
			$( '.cleona-image-url' ).val( '' );
			// $( this ).parent().siblings( '.title' ).children( 'img' ).attr( 'src', arString.imgPath );
			// $( '.inline-edit-col :input[name=\'taxonomy_image\']' ).val( '' );
			return false;
		} );

		// if ( wordpress_ver < '3.5' ) {
		// 	window.send_to_editor = function( html ) {
		// 		imgurl = $( 'img', html ).attr( 'src' );
				// if ( upload_button.parent().prev().children().hasClass( 'tax_list' ) ) {
				// 	upload_button.parent().prev().children().val( imgurl );
				// 	upload_button.parent().prev().prev().children().attr( 'src', imgurl );
				// } else {
				// }
		// 		$( '#taxonomy_image' ).val( imgurl );
		// 		tb_remove();
		// 	}
		// }

		// $( '.editinline' ).click( function() {
		// 	var tax_id = $( this ).parents( 'tr' ).attr( 'id' ).substr(4),
		// 		thumb  = $( '#tag-' + tax_id + ' .thumb img' ).attr( 'src' );

		// 	if ( thumb != arString.imgPath ) {
		// 		$( '.inline-edit-col :input[name=\"taxonomy_image\"]' ).val( thumb );
		// 	} else {
		// 		$( '.inline-edit-col :input[name=\"taxonomy_image\"]' ).val( '' );
		// 	}

		// 	$( '.inline-edit-col .title img' ).attr( 'src', thumb );

		// } );

} );