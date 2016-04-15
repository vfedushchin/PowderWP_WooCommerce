/* global jssor_options */

jQuery(function ($) {

	var $easyzoom = $( '.single_product_wrapper .images .easyzoom' ).easyZoom(),
	easyZoomApi = $easyzoom.data('easyZoom'),
	items = [],
	index;
	$( '.single_product_wrapper .images .thumbnails .thumbnail' ).eq(0).addClass( 'selected' );
	$( '.single_product_wrapper .images .thumbnails .thumbnail' ).each( function() {
		items.push( {
			src: $( this ).data( 'href' )
		} );
		$( this ).on( 'click', function() {
			$( '.single_product_wrapper .images .thumbnails .thumbnail' ).removeClass( 'selected' );
			$this = $( this );
			$this.addClass( 'selected' );
			easyZoomApi.teardown();
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
			$( '.single_product_wrapper .images .enlarge' ).on( 'click', function() {
				$.magnificPopup.open( {
					items: items,
					gallery: {
						enabled: true
					},
					type: 'image'
				}, index );
			} );
		} );
	} );

	$( '.single_product_wrapper .images .enlarge' ).on( 'click', function() {
		$this = $( this );
		$.magnificPopup.open( {
			items: items,
			gallery: {
				enabled: true
			},
			type: 'image'
		}, 0 );
	} );

	function zoom() {
		if ( 768 > Math.min( $( window ).width(), screen.width ) ) {
			easyZoomApi.teardown();
		} else {
			easyZoomApi._init();
		}
	}

	zoom();
	$( window ).on( "resize orientationchange", zoom );

} );