/* global jssor_options */

jQuery(document).ready(function ($) {
		
	var jssor_1_options = {
		$Loop: 0,
		$ThumbnailNavigatorOptions: {
			$Class: $JssorThumbnailNavigator$,
			$Cols: parseInt(jssor_options.cols),
			$SpacingX: parseInt(jssor_options.spaceX),
			$SpacingY: parseInt(jssor_options.spaceY),
			$Orientation: parseInt(jssor_options.orientation),
			$Loop: 0,
			$ArrowNavigatorOptions: {
				$Class: $JssorArrowNavigator$
			}
		}
	};
	
	var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
	
	//responsive code begin
	//you can remove responsive code if you don't want the slider scales while window resizing
	function ScaleSlider() {
			var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
			if (refSize) {
					refSize = Math.min(refSize, 960);
					refSize = Math.max(refSize, 300);
					jssor_1_slider.$ScaleWidth(refSize);
			}
			else {
					window.setTimeout(ScaleSlider, 30);
			}
	}
	ScaleSlider();
	$(window).bind("load", ScaleSlider);
	$(window).bind("resize", ScaleSlider);
	$(window).bind("orientationchange", ScaleSlider);
	//responsive code end

	var $easyzoom = jQuery(".single-product-main_image:last > div.easyzoom").easyZoom();

	var items = [];
	$('.single-product-main_image:last').find('.easyzoom').each(function() {
		items.push( {
			src: $(this).find('>a').attr('href')
		} );
	});

	jssor_1_slider.$On($JssorSlider$.$EVT_STATE_CHANGE,function(slideIndex, progress){

		$('.single-product-images .enlarge').click(function() {

			$.magnificPopup.open({
				items:items,
				gallery: {
					enabled: true 
				},
				type: 'image'
			}, slideIndex);
		})
	});

	
});