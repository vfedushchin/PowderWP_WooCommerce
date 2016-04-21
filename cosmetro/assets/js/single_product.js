/* global jssor_options */

jQuery(function ($) {

	var $easyzoom = $( '.single_product_wrapper .images .easyzoom' ).easyZoom(),
		easyZoomApi = $easyzoom.data('easyZoom'),
		items = [],
		index,
		thumb = $( '.single_product_wrapper .images .thumbnails .thumbnail' ),
		enlarge = $( '.single_product_wrapper .images .enlarge' ),
		zoom_enabled = true;

	thumb.eq(0).addClass( 'selected' );
	thumb.each( function() {
		items.push( {
			src: $( this ).data( 'href' )
		} );
		$( this ).on( 'click', function() {
			thumb.removeClass( 'selected' );
			$this = $( this );
			$this.addClass( 'selected' );
			easyZoomApi.teardown();
			zoom_enabled = false;
			$( '.woocommerce-main-image' ).attr( {
				href: $this.data( 'href' )
			} ).find( 'img' ).attr( {
				src: $this.data( 'thumb' ),
				srcset: $this.find( 'img' ).attr( 'srcset' ),
				title: $this.find( 'img' ).attr( 'title' ),
				alt: $this.find( 'img' ).attr( 'alt' )
			} );
			zoom();
			index = $this.index();
			open_popup( index );
		} );
	} );

	function open_popup( index ) {
		enlarge.on( 'click', function() {
			$this = $( this );
			$.magnificPopup.open( {
				items: items,
				gallery: {
					enabled: true
				},
				type: 'image'
			}, index );
		} );
	}

	open_popup( 0 );

	function zoom() {
		if ( 768 > Math.min( $( window ).width(), screen.width ) ) {
			if( true === zoom_enabled ) {
				easyZoomApi.teardown();
				zoom_enabled = false;
			}
		} else {
			if( false === zoom_enabled ) {
				easyZoomApi._init();
				zoom_enabled = true;
			}
		}
	}

	zoom();
	$( window ).on( "resize orientationchange", zoom );

} );