<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

wp_enqueue_script( 'jssor-init', COSMETRO_THEME_URI . '/assets/js/single_product.js', array( 'jquery-jssor' ), '1.0.0', true );

wp_enqueue_script( 'magnific-popup' );

$vertical = get_theme_mod( 'single_product_slider_layout', 'vertical' ) == 'vertical' ? true : false;
$image_size = get_option( 'shop_single_image_size' );
$thumb_size = get_option( 'shop_thumbnail_image_size' );
$visible_thumbs = $vertical ? intval ($image_size['height']/$thumb_size['height']) : intval ($image_size['width']/$thumb_size['width']);
$space = $vertical ? round( ($image_size['height'] - $thumb_size['height']*$visible_thumbs)/($visible_thumbs - 1) ) : round( ($image_size['width'] - $thumb_size['width']*$visible_thumbs)/($visible_thumbs - 1) );
$container_size['height'] = $vertical ? $image_size['height'] : $image_size['height'] + $thumb_size['height'] + $space;
$container_size['width'] = $vertical ? $image_size['width'] + $thumb_size['width'] + $space : $image_size['width'];

$jssor_options = array(
	'orientation' => $vertical ? 2 : 1,
	'cols' => $visible_thumbs,
	'spaceX' => $space,
	'spaceY' => $space
);

wp_localize_script( 'jssor-init', 'jssor_options', $jssor_options );;

?>
<div class="single-product-images single-product-images-<?php echo $vertical ? 'vertical' : 'horizontal'; ?>" id="jssor_1" style="width: <?php echo $container_size['width']; ?>px; height: <?php echo $container_size['height']; ?>px;">
	<?php
	if ('yes' === get_option( 'woocommerce_enable_lightbox', 'yes' )) { ?>
	<div class="enlarge"></div>
	<?php } ?>
<!-- Loading Screen -->
	<div data-u="loading">
		<div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
		<div style="position:absolute;display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
	</div>
	<div data-u="slides" class="single-product-main_image" style="width: <?php echo $image_size['width']; ?>px; height: <?php echo $image_size['height']; ?>px;">
		<?php do_action( 'woocommerce_product_thumbnails' ); ?>
	</div>
	<!-- Thumbnail Navigator -->
	<div data-u="thumbnavigator" class="jssort01-99-66" style="left: 0; bottom: 0;<?php echo $vertical ? 'width: ' . $thumb_size['width'] . 'px; height: ' . $image_size['height'] . 'px;' : 'width: ' . $image_size['width'] . 'px; height: ' . $thumb_size['height'] . 'px;'; ?>">
		<!-- Thumbnail Item Skin Begin -->
		<div data-u="slides">
			<div data-u="prototype" class="p" style="<?php echo 'height: ' . $thumb_size['height'] . 'px; width: ' . $thumb_size['width'] . 'px'; ?>">
				<div class="w">
					<div data-u="thumbnailtemplate" class="t"></div>
				</div>
				<div class="c"></div>
			</div>
		</div>
		<span u="arrowleft" class="jssora11l"></span>
		<span u="arrowright" class="jssora11r"></span>
		<!-- Thumbnail Item Skin End -->
	</div>
</div>
