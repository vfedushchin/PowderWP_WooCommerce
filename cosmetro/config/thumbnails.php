<?php
/**
 * Thumbnails configuration.
 *
 * @package __Tm
 */

add_action( 'after_setup_theme', 'cosmetro_register_image_sizes', 5 );
function cosmetro_register_image_sizes() {
	set_post_thumbnail_size( 370, 230, true );

    // Registers a new image sizes.
    add_image_size( '_tm-thumb-s', 150, 150, true );
    add_image_size( '_tm-thumb-241-84', 241, 84, true );
    add_image_size( '_tm-thumb-370-270', 370, 270, true );
    add_image_size( '_tm-thumb-m', 400, 400, true );
    add_image_size( '_tm-thumb-560-350', 560, 350, true );
    add_image_size( '_tm-thumb-770-562', 770, 562, true );
    add_image_size( '_tm-post-thumbnail-large', 983, 823, true );
    add_image_size( '_tm-thumb-l', 1170, 780, true );
    add_image_size( '_tm-thumb-xl', 1920, 1080, true );


    add_image_size( '_tm-thumb-536-449', 536, 449, true );
    add_image_size( '_tm-thumb-536-958', 536, 958, true );
    add_image_size( '_tm-thumb-834-536', 834, 536, true );
    add_image_size( '_tm-thumb-536-536', 536, 536, true );

    add_image_size( '_tm-thumb-834-834', 834, 834, true );
    add_image_size( '_tm-thumb-387-467', 387, 467, true );

    add_image_size( '_tm-thumb-196-213', 196, 213, true );
    add_image_size( '_tm-thumb-290-315', 290, 315, true );
    add_image_size( '_tm-thumb-153-167', 153, 167, true );

    add_image_size( '_tm-thumb-120-120', 120, 120, true );
    add_image_size( '_tm-thumb-983-823', 983, 823, true );

    add_image_size( '_tm-thumb-149-126', 149, 126, true );
}