(function($){
	"use strict";

	CherryJsCore.utilites.namespace('theme_script');
	CherryJsCore.theme_script = {
		init: function () {
			var self = this;

			// Document ready event check
			if( CherryJsCore.status.is_ready ){
				self.document_ready_render( self );
			}else{
				CherryJsCore.variable.$document.on( 'ready', self.document_ready_render( self ) );
			}

			// Windows load event check
			if( CherryJsCore.status.on_load ){
				self.window_load_render( self );
			}else{
				CherryJsCore.variable.$window.on( 'load', self.window_load_render( self ) );
			}
		},

		document_ready_render: function ( self ) {
			var self = self;

			self.smart_slider_init( self );
			self.swiper_carousel_init( self );
			self.post_formats_custom_init( self );
			self.navbar_init( self );
			self.subscribe_init( self );
			self.main_menu( self, $( '.main-navigation' ) );
			self.to_top_init( self );
		},

		window_load_render: function ( self ) {
			var self = self;
			self.page_preloader_init( self );
		},

		smart_slider_init: function( self ) {
			$( '.cosmetro-smartslider' ).each( function() {
				var slider = $(this),
					sliderId = slider.data('id'),
					sliderWidth = slider.data('width'),
					sliderHeight = slider.data('height'),
					sliderOrientation = slider.data('orientation'),
					slideDistance = slider.data('slide-distance'),
					slideDuration = slider.data('slide-duration'),
					sliderFade = slider.data('slide-fade'),
					sliderNavigation = slider.data('navigation'),
					sliderFadeNavigation = slider.data('fade-navigation'),
					sliderPagination = slider.data('pagination'),
					sliderAutoplay = slider.data('autoplay'),
					sliderFullScreen = slider.data('fullscreen'),
					sliderShuffle = slider.data('shuffle'),
					sliderLoop = slider.data('loop'),
					sliderThumbnailsArrows = slider.data('thumbnails-arrows'),
					sliderThumbnailsPosition = slider.data('thumbnails-position'),
					sliderThumbnailsWidth = slider.data('thumbnails-width'),
					sliderThumbnailsHeight = slider.data('thumbnails-height');

				if ( $('.cosmetro-smartslider__slides', '#' + sliderId ).length > 0 ) {
					$( '#' + sliderId ).sliderPro( {
						width: sliderWidth,
						height: sliderHeight,
						orientation: sliderOrientation,
						slideDistance: slideDistance,
						slideAnimationDuration: slideDuration,
						fade: sliderFade,
						arrows: sliderNavigation,
						fadeArrows: sliderFadeNavigation,
						buttons: sliderPagination,
						autoplay: sliderAutoplay,
						fullScreen: sliderFullScreen,
						shuffle: sliderShuffle,
						loop: sliderLoop,
						waitForLayers: false,
						thumbnailArrows: sliderThumbnailsArrows,
						thumbnailsPosition: sliderThumbnailsPosition,
						thumbnailWidth: sliderThumbnailsWidth,
						thumbnailHeight: sliderThumbnailsHeight,
						init: function() {
							$( this ).resize();
						},
						sliderResize: function( event ) {
							var thisSlider = $( '#' + sliderId ),
								slides = $( '.sp-slide', thisSlider );

								slides.each( function(){

									if ( $( '.sp-title a', this ).width() > $( this ).width() ){
										console.log(123);
										$( this ).addClass('text-wrapped');
									}else{
										$( this ).removeClass('text-wrapped');
									}

								} );
						},
						breakpoints: {
							992: {
								height: parseFloat( sliderHeight ) * 0.75,
							},
							768: {
								height: parseFloat( sliderHeight ) * 0.5
							}
						}
					} );
				}
			});//each end
		},

		swiper_carousel_init: function ( self ) {

			// Enable swiper carousels
			jQuery('.cosmetro-carousel').each( function() {
				var swiper = null,
					uniqId = jQuery(this).data('uniq-id'),
					slidesPerView = parseFloat( jQuery(this).data('slides-per-view') ),
					slidesPerGroup = parseFloat( jQuery(this).data('slides-per-group') ),
					slidesPerColumn = parseFloat( jQuery(this).data('slides-per-column') ),
					spaceBetweenSlides = parseFloat( jQuery(this).data('space-between-slides') ),
					durationSpeed = parseFloat( jQuery(this).data('duration-speed') ),
					swiperLoop = jQuery(this).data('swiper-loop'),
					freeMode = jQuery(this).data('free-mode'),
					grabCursor = jQuery(this).data('grab-cursor'),
					mouseWheel = jQuery(this).data('mouse-wheel'),
					breakpointsSettings = {
						992: {
							slidesPerView: Math.ceil( slidesPerView * 0.6 ),
							spaceBetween: Math.ceil( spaceBetweenSlides * 0.6 )
						},
						768: {
							slidesPerView: Math.ceil( slidesPerView * 0.5 ),
							spaceBetween: Math.ceil( spaceBetweenSlides * 0.5 )
						},
						479: {
							slidesPerView: Math.ceil( slidesPerView * 0.25 ),
							spaceBetween: Math.ceil( spaceBetweenSlides * 0.25 )
						}
					};

				if ( 1 == slidesPerView ) {
					breakpointsSettings = {}
				}

				var swiper = new Swiper( '#' + uniqId, {
						slidesPerView: slidesPerView,
						slidesPerGroup: slidesPerGroup,
						slidesPerColumn: slidesPerColumn,
						spaceBetween: spaceBetweenSlides,
						speed: durationSpeed,
						loop: swiperLoop,
						freeMode: freeMode,
						grabCursor: grabCursor,
						mousewheelControl: mouseWheel,
						paginationClickable: true,
						nextButton: '#' + uniqId + '-next',
						prevButton: '#' + uniqId + '-prev',
						pagination: '#' + uniqId + '-pagination',
						onInit: function(){
							$( '#' + uniqId + '-next' ).css({ 'display': 'block' });
							$( '#' + uniqId + '-prev' ).css({ 'display': 'block' });
						},
						breakpoints: breakpointsSettings
					}
				);
			});
		},

		post_formats_custom_init: function ( self ) {
			CherryJsCore.variable.$document.on( 'cherry-post-formats-custom-init', function( event ) {

				if ( 'slider' !== event.object ) {
					return;
				}

				var uniqId = '#' + event.item.attr( 'id' ),
					swiper = new Swiper( uniqId, {
						pagination: uniqId + ' .swiper-pagination',
						paginationClickable: true,
						nextButton: uniqId + ' .swiper-button-next',
						prevButton: uniqId + ' .swiper-button-prev',
						spaceBetween: 0,
						onInit: function(){
							$( uniqId + ' .swiper-button-next' ).css({ 'display': 'block' });
							$( uniqId + ' .swiper-button-prev' ).css({ 'display': 'block' });
						},
					} );

				event.item.data( 'initalized', true );
			});

			var items = [];

			$('.mini-gallery .post-thumbnail__link').on('click', function(event) {
				event.preventDefault();

				$(this).parents('.mini-gallery').find('.post-gallery__slides > a[href]').each(function() {
					items.push({
						src: $(this).attr('href'),
						type: 'image'
					});
				});

				$.magnificPopup.open({
					items: items,
					gallery: {
						enabled: true
					}
				});
			});
		},

		navbar_init: function ( self ) {

			$( window ).load( function() {

				var $navbar = $('.main-navigation');

				if ( ! $.isFunction( jQuery.fn.stickUp ) || ! $navbar.length ) {
					return !1;
				}

				if ( $('#wpadminbar').length ) {
					$navbar.addClass('has-bar');
				}

				$navbar.stickUp();

			});
		},

		subscribe_init: function( self ) {
			CherryJsCore.variable.$document.on( 'click', '.subscribe-block__submit', function( event ){

				event.preventDefault();

				var $this       = $(this),
					form       = $this.parents( 'form' ),
					nonce      = form.find( 'input[name="cosmetro_subscribe"]' ).val(),
					mail_input = form.find( 'input[name="subscribe-mail"]' ),
					mail       = mail_input.val(),
					error      = form.find( '.subscribe-block__error' ),
					success    = form.find( '.subscribe-block__success' ),
					hidden     = 'hidden';

				if ( '' == mail ) {
					mail_input.addClass( 'error' );
					return !1;
				}

				if ( $this.hasClass( 'processing' ) ) {
					return !1;
				}

				$this.addClass( 'processing' );
				error.empty();

				if ( ! error.hasClass( hidden ) ) {
					error.addClass( hidden );
				}

				if ( ! success.hasClass( hidden ) ) {
					success.addClass( hidden );
				}

				$.ajax({
					url: cosmetro.ajaxurl,
					type: 'post',
					dataType: 'json',
					data: {
						action: 'cosmetro_subscribe',
						mail: mail,
						nonce: nonce
					},
					error: function() {
						$this.removeClass( 'processing' );
					}
				}).done( function( response ) {

					$this.removeClass( 'processing' );

					if ( true === response.success ) {
						success.removeClass( hidden );
						mail_input.val('');
						return 1;
					}

					error.removeClass( hidden ).html( response.data.message );
					return !1;

				});

			})
		},

				main_menu: function ( self, target ) {

			var menu = target,
				duration_timeout,
				closeSubs,
				hideSub,
				showSub,
				init;

			closeSubs = function() {
				$( '.menu-hover > a', menu ).each(
					function() {
						hideSub( $(this) );
					}
				);
			};

			hideSub = function( anchor ) {

				anchor.parent().removeData( 'index' ).removeClass( 'menu-hover' ).triggerHandler( 'close_menu' );

				anchor.siblings('ul').addClass('in-transition');

				clearTimeout( duration_timeout );
				duration_timeout = setTimeout(
					function() {
						anchor.siblings('ul').removeClass( 'in-transition' );
					},
					200
				);
			};

			showSub = function( anchor ) {

				// all open children of open siblings
				var item = anchor.parent();

				item
					.siblings()
					.find( '.menu-hover' )
					.addBack( '.menu-hover' )
					.children( 'a' )
					.each(function() {
						hideSub( $( this ), true );
					});

				item.addClass( 'menu-hover' ).triggerHandler( 'open_menu' );
			};

			init = function() {
				var $mainNavigation = $( '.main-navigation' ),
					$mainMenu = $( 'ul.menu', $mainNavigation ),
					$menuToggle = $( '.menu-toggle', $mainNavigation ),
					$liWithChildren = $( 'li.menu-item-has-children, li.page_item_has_children', menu ),
					$self;

				$liWithChildren.hoverIntent( {
					over   : function() {
						showSub( $( this ).children( 'a' ) );
					},
					out    : function() {
						if ( $( this ).hasClass( 'menu-hover' ) ) {
							hideSub( $( this ).children( 'a' ) );
						}
					},
					timeout: 800
				} );

				var $parentNode,
					$self,
					index = -1;

				/**
				 * Double click on menu item
				 * @access private
				 */
				function doubleClickMenu( $jqEvent ) {
					$self = $(this);

					if ( $self.index() !== parseInt( $parentNode.data( 'index' ), 10 ) ) {
						$jqEvent.preventDefault();
					}

					$parentNode.data( 'index', $self.index() );
				}

				// Check if touch events supported
				if ( 'ontouchend' in window ) {

					// Attach event listener for double click
					$mainNavigation.find( '#main-menu li[class*="children"] > a' ).on( 'click', doubleClickMenu );

					// Reset index on touchend event
					CherryJsCore.variable.$document.on( 'touchend', function( $jqEvent ) {
						$parentNode = $( $jqEvent.target ).parent();

						if ( $parentNode.hasClass( 'menu-hover' ) === false ) {
							closeSubs();

							index = $parentNode.data( 'index' );

							if ( index ) {
								$parentNode.data( 'index', parseInt( index, 10 ) - 1 );
							}
						}
					} );
				}

				$menuToggle.on( 'click', function(){
					$mainNavigation.toggleClass( 'toggled' );
				});
			};

			init();
		},

		page_preloader_init: function ( self ) {

			if ( $( '.page-preloader-cover' )[0] ) {
				$( '.page-preloader-cover' ).delay( 500 ).fadeTo( 500, 0, function() {
					$( this ).remove();
				});
			}
		},

		to_top_init: function ( self ) {
			if ( $.isFunction( jQuery.fn.UItoTop ) ) {
				$().UItoTop({
					text: cosmetro.labels.totop_button,
					scrollSpeed: 600
				});
			}
		}
	}
	CherryJsCore.theme_script.init();
/*Styles for Woocommerce part*/
// Dropdown toggle
	$('.div_dropdown_top_menu .material-icons').click(function () {
		$(this).next('.top-panel__menu').toggleClass("show");
		$(this).toggleClass("dropdown_top_menu-active");
	});
	$(document).click(function (e) {
		var target = e.target;
		if (!$(target).is('.div_dropdown_top_menu .material-icons') && !$(target).parents().is('.div_dropdown_top_menu .material-icons')) {
			$('.top-panel__menu').removeClass("show");
			$('.div_dropdown_top_menu .material-icons').removeClass("dropdown_top_menu-active");
		}
	});

	if ($('input[type=number][name=quantity]').length) {

		var $input = $('input[type=number][name=quantity]');
		$('input[type=number][name=quantity]').after('<span class="tm-qty-minus"></span><span class="tm-qty-plus"></span>');

		$('.tm-qty-minus').click(function () {
			if ($input.val() > $input.attr('min')) $input.val($input.val() - 1);
		});
		$('.tm-qty-plus').click(function () {
			$input.val(parseInt($input.val()) + 1);
		});
	}

	// Dropdown header cart
	 /*$(document.body).on('wc_fragments_refreshed wc_fragments_loaded added_to_cart', function () {
		$('.cart-contents').on('click', function () {
		 $('.header-cart-dropdown').toggleClass('header-cart-dropdown-active');
		});

		$(document).on('click touchstart touchend', function (e) {
		 var target = e.target;
		 if (!$(target).is('.site-header-cart') && !$(target).is('.cart-contents') && $(target).parents('.site-header-cart').length == 0) {
			$('.header-cart-dropdown').removeClass('header-cart-dropdown-active');
		 }
		});
	 });*/
		$(document.body).on('wc_fragments_refreshed wc_fragments_loaded added_to_cart', function () {
		 $('.cart-contents').on('click', function () {
		  $('.header-cart-dropdown').toggleClass('header-cart-dropdown-active');
		 });
		 $(document).on('click touchstart touchend', function (e) {
		  var target = e.target;
		  if (!$(target).is('.site-header-cart') && !$(target).is('.cart-contents') && $(target).parents('.site-header-cart').length == 0) {
		      $('.header-cart-dropdown').removeClass('header-cart-dropdown-active');
		     }
		 });
		});

	 // top menu fix (to close on apple devices)
	 $(document).on('click touchstart touchend', function (e) {
		var target = e.target;
		if (!$(target).is('.top-panel__menu') && !$(target).is('.div_dropdown_top_menu .material-icons') && $(target).parents('.top-panel__menu').length == 0) {
		 $('.top-panel__menu').removeClass("show");
		 $('.div_dropdown_top_menu .material-icons').removeClass("dropdown_top_menu-active");
		}
	 });



	$(document).on('click', '.cherry-compare', function (ev) {
		ev.preventDefault();
		var table_url = this.href;
		 $('body').trigger('yith_woocompare_open_popup', {response: cosmetro.compare_table_url, button: $(this)});
	});


	$('h4').each(function () {
		var me = $(this);
		// me.html(me.html().replace(/^(\w+)/, '<span>$1</span>'));
	});

	$('.wp-audio-shortcode').wrap('<div class="audio-player-wrap"></div>')
;
	$('#wcj-currency').find('option').each(function(){
		$(this).text($(this).val());
	});

	 $(document).ready(function() {
		$('.wcj_widget_multicurrency select').chosen();
		$('.orderby').chosen();

		$('.tm-products-sale-end-date[data-countdown]').each(function() {
			var $this = $(this), finalDate = $(this).data('countdown'), format = $(this).data('format');
			$this.countdown(finalDate, function(event) {
				$this.html(event.strftime(format));
			});
		});

		if ($('.menu-item_description').length) {
			$('.menu').addClass('menu-item_description-active');
		}
	});

}(jQuery));








/* start for screenshort image - developing
=============================================*/
// ------------------------------------------------------------------------
function setCookie(name, value, options) {
		options = options || {};
		var expires = options.expires;
		if (typeof expires == "number" && expires) {
				var d = new Date();
				d.setTime(d.getTime() + expires * 1000);
				expires = options.expires = d;
		}
		if (expires && expires.toUTCString) {
				options.expires = expires.toUTCString();
		}
		value = encodeURIComponent(value);
		var updatedCookie = name + "=" + value;
		for (var propName in options) {
				updatedCookie += "; " + propName;
				var propValue = options[propName];
				if (propValue !== true) {
						updatedCookie += "=" + propValue;
				}
		}
		document.cookie = updatedCookie;
};

// ------------------------------------------------------------------------
function getCookie(name) {
		var matches = document.cookie.match(new RegExp(
				"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
		));
		return matches ? decodeURIComponent(matches[1]) : undefined;
};
// ------------------------------------------------------------------------
function deleteCookie(name) {
		setCookie(name, "", {
				expires: -1
		});
};
// ------------------------------------------------------------------------
var _display_screen_class;
_display_screen_class = getCookie('_display_screen_class');


;(function ($) {
		$("body").prepend("<div class='preview-container pr-bg-1'><div class='preview-container_bg'></div></div>");
		$('.preview-container').addClass(_display_screen_class);
		addEventListener("keydown", function(event) {
				if (event.keyCode == 81 && event.ctrlKey) {
						//press Ctl+q to show/hide screenshort
						// $('.preview-container').toggleClass('display');
						if ($('.preview-container').hasClass("display")) {
								$('.preview-container').removeClass('display');
								setCookie('_display_screen_class', '');
						} else {
								$('.preview-container').addClass('display');
								setCookie('_display_screen_class', 'display');
						}
				}
		});
})(jQuery);
/* end for screenshort image - developing
=============================================*/