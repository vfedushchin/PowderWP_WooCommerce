/* global custom_menu_widget_admin */

(function($){
	"use strict";

	var tm_custom_menu_widget_admin = {

		init: function () {

			$( '#widgets-right' ).find( 'div.widget[id*=tm_custom_menu_widget], div.widget[id*=tm_about_store_widget]' ).each( function () {
				var $widget = $( this ),
					add_media = $widget.find( '.tm_custom_menu_widget_add_media' ),
					thumb_container = $widget.find( '.tm_custom_menu_widget_img' ),
					remove_btn = thumb_container.find( '.banner_remove' ),
					id = $widget.find( '.tm_custom_menu_widget_id' );

				add_media.on( 'click', function( event ) {

					var media_frame = wp.media.frames.downloadable_file = wp.media({
						title: custom_menu_widget_admin.media_frame_title,
						multiple: false
					});

					media_frame.on( 'select', function() {

						var attachment = media_frame.state().get( 'selection' ).first().toJSON();

						thumb_container.show().find('>div').attr({
							style: 'background-image: url('+attachment.sizes.thumbnail.url+');'
						})
						add_media.hide();
						id.val( attachment.id ).trigger( 'change' );
						tm_custom_menu_widget_admin.reinit();
					});
					media_frame.open();
				});

				remove_btn.on( 'click', function() {

					var index = remove_btn.parents( '.tm_img_grid_widget_img_col' ).index(),
						val;
					thumb_container.removeAttr('style').hide();
					id.val( '' ).trigger( 'change' );
					add_media.show();
					tm_custom_menu_widget_admin.reinit();

				});
			});
		},

		reinit: function () {
			$('.tm_custom_menu_widget_add_media').off( 'click');
			$('.tm_custom_menu_widget_img .banner_remove').off( 'click');
			tm_custom_menu_widget_admin.init();
		}
	}
	tm_custom_menu_widget_admin.init();

	$( document ).on( 'widget-updated widget-added', tm_custom_menu_widget_admin.reinit );

})(jQuery);