/* global banners_grid_widget_admin */

(function($){
	"use strict";

	var tm_banners_grid_widget_admin = {

		init: function () {

			$( '#widgets-right' ).find( 'div.widget[id*=tm_banners_grid_widget]' ).each( function () {
				var $widget = $( this ),
					form = $widget.find( 'form' ),
					add_media = $widget.find( '.tm_banners_grid_widget_add_media' ),
					thumbs_container = $widget.find( '.tm_banners_grid_widget_banners_thumbs' ),
					thumbs_container_inner = thumbs_container.find( '.tm_banners_grid_widget_banners_thumbs_inner' ),
					cols = thumbs_container_inner.find( '.tm_banners_grid_widget_img_col' ),
					remove_btns = cols.find( '.banner_remove' ),
					banner_links = cols.find( '.banner_link' ),
					grids_container = $widget.find( '.tm_banners_grid_widget_banners_grids' ),
					grid = grids_container.find( '.tm_banners_grid_widget_banners_grid' ),
					banners = $widget.find( '.tm_banners_grid_widget_banners' ),
					wrapper = $widget.find( '.banner_link_wrapper' ),
					link_input = $widget.find( '.tm_banners_grid_widget_banner_link' ),
					links_input = $widget.find( '.tm_banners_grid_widget_banners_links' );

				if ( cols.length < banners_grid_widget_admin.max_banners ) {
					add_media.show();
				}

				if( cols.length > 0 ) {
					grids_container.find( '.tm_banners_grid_widget_banners_grid' ).eq( cols.length-1).show();
				}

				add_media.on( 'click', function( event ) {

					var media_frame = wp.media.frames.downloadable_file = wp.media({
						title: banners_grid_widget_admin.media_frame_title,
						multiple: true
					});

					media_frame.on( 'select', function() {

						var attachment = media_frame.state().get( 'selection' ).toJSON(),
							attachment_ids = new Array(),
							old_val = banners.val() ? banners.val().split(',') : new Array(),
							new_val,
							max_banners_to_add = 6 - old_val.length,
							attachment = attachment.slice(0, max_banners_to_add);

						for (var i = 0; i < attachment.length; i++) {
							attachment_ids[i] = attachment[i].id;
							thumbs_container_inner.append('<div class="tm_banners_grid_widget_img_col" data-id="' + attachment[i].id + '"><div style="background-image: url('+attachment[i].sizes.thumbnail.url+');"><span class="fa-stack banner_remove" title="'+banners_grid_widget_admin.set_link_text+'"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-times fa-stack-1x"></i></span><span class="fa-stack banner_link" title="' + banners_grid_widget_admin.set_link_text + '"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-link fa-stack-1x"></i></span></div></div>');
						};

						new_val = old_val.concat(attachment_ids);
						if( new_val.length == 6 ) {
							add_media.remove();
						}
						grid.hide().find( 'input' ).removeAttr( 'checked' );
						grid.eq( new_val.length - 1 ).show().find( 'input' ).eq( 0 ).attr( 'checked', 'checked' );
						banners.val( new_val.join() ).trigger( 'change' );
						tm_banners_grid_widget_admin.reinit();
					});
					media_frame.open();
				});

				remove_btns.each(function(){

					var $del_btn = $( this ),
						index = $del_btn.parents( '.tm_banners_grid_widget_img_col' ).index(),
						id = $del_btn.parents( '.tm_banners_grid_widget_img_col' ).data('id'),
						links,
						val;

					$del_btn.on( 'click', function() {
						$del_btn.parents( '.tm_banners_grid_widget_img_col' ).remove();
						val = banners.val().split( ',' );
						val.splice( index, 1 );
						banners.val( val.join() ).trigger( 'change' );
						links = links_input.val() != '' ? JSON.parse(links_input.val()) : {};
						delete links[''+id];
						links_input.val( JSON.stringify( links ) );
						grid.hide().find( 'input' ).removeAttr( 'checked' );
						if( val.length > 0 ){
							grid.eq( val.length - 1 ).show().find( 'input' ).eq( 0 ).attr( 'checked', 'checked' );
						}
						tm_banners_grid_widget_admin.reinit();
					});

				});

				thumbs_container_inner.sortable({
					distance: 2,
					zIndex: 100,
					disabled: false,
					update: function () {
						var ids = new Array();
						thumbs_container_inner.find( '.tm_banners_grid_widget_img_col' ).each( function ( i ) {
							ids[i] = $( this ).data( 'id' );
						})
						banners.val( ids.join() ).trigger( 'change' );
						tm_banners_grid_widget_admin.reinit();
					}
				});

				var validator = form.validate({onsubmit: false});

				banner_links.each( function () {

					var $link_btn = $( this ),
						$parent = $link_btn.parents( '.tm_banners_grid_widget_img_col' ),
						id = $parent.data('id'),
						links;

					$link_btn.on( 'click', function () {
						links = links_input.val() != '' ? JSON.parse(links_input.val()) : {};
						thumbs_container_inner.addClass( 'blocked' ).sortable( 'option', 'disabled', true );
						cols.removeClass( 'blocked' );
						$parent.addClass( 'blocked' );
						link_input.focus().val( links[id] ? window.atob( links[id] ) : '' ).trigger( 'change' );
						wrapper.removeClass( 'hide' );
						wrapper.find( '.button-cancel' ).on( 'click', function () {
							validator.resetForm();
							wrapper.addClass( 'hide' );
							link_input.val( '' ).trigger( 'change' );
							$parent.removeClass( 'blocked' );
							thumbs_container_inner.removeClass( 'blocked' );
							tm_banners_grid_widget_admin.reinit();
						});
						wrapper.find( '.button-submit' ).on( 'click', function () {
							if( validator.form() ){
								links[''+id] = window.btoa( link_input.val() );
								links_input.val( JSON.stringify( links ) ).trigger( 'change' );
								wrapper.addClass( 'hide' );
								$parent.removeClass( 'blocked' );
								thumbs_container_inner.removeClass( 'blocked' );
								tm_banners_grid_widget_admin.reinit();
							}
						});
					});
				});
			});
		},

		reinit: function () {
			$('.tm_banners_grid_widget_add_media').off( 'click');
			$('.tm_banners_grid_widget_banners_thumbs .tm_banners_grid_widget_img_col .banner_remove').each( function () {
				var $del_btn = $( this );
				$del_btn.off( 'click');
			});
			tm_banners_grid_widget_admin.init();
		}
	}
	tm_banners_grid_widget_admin.init();

	$( document ).on( 'widget-updated widget-added', tm_banners_grid_widget_admin.reinit );

})(jQuery);