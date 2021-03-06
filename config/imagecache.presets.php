<?php

/**
 * Key value pair of presets with the name and dimensions to be used
 *
 * 'PRESET_NAME' => array(
 *   'width'  => INT, // in pixels
 *   'height' => INT, // in pixels
 *   'method' => STRING, // 'crop' or 'resize'
 *   'background_color' => '#000000', //  (optional) Used with resize
 * )
 *
 * eg   'presets' => array(
 *        '800x600' => array(
 *          'width' => 800,
 *          'height' => 600,
 *          'method' => 'resize',
 *          'background_color' => '#000000',
 *        )
 *      ),
 *
 */
return array(

    'profile_image' => array(
        'width' => 32,
        'height' => 32,
        'method' => 'crop'
    ),
    'product_image' => array(
        'width' => 550,
        'height' => 500,
        'method' => 'resize',
    ),
    'cart_product_image' => array(
        'width' => 147,
        'height' => 100,
        'method' => 'crop',
    ),
    '60x60' => array(
        'width' => 60,
        'height' => 60,
        'method' => 'crop',
     ),
    '80x80' => array(
        'width' => 80,
        'height' => 80,
        'method' => 'crop',
    ),
    '63x84' => array(
        'width' => 63,
        'height' => 84,
        'method' => 'crop',
    ),
    '120x90' => array(
        'width' => 120,
        'height' => 90,
        'method' => 'crop',
    ),
    '100x43' => array(
        'width' => 100,
        'height' => 43,
        'method' => 'crop',
    ),
    '90x120' => array(
        'width' => 90,
        'height' => 120,
        'method' => 'crop',
    ),
    '215x287' => array(
        'width' => 215,
        'height' => 287,
        'method' => 'crop',
    ),
    'home_widget' => array(
        'width' => 552,
        'height' => 222,
        'method' => 'crop',
    ),
    'product_widget' => [
      'width' => 370,
      'height' => 395,
      'method' => 'crop',
    ],
    'home_product' => [
        'width' => 255,
        'height' => 271,
        'method' => 'crop',
    ],
    // Home
    '690x229' => [
        'width' => 690,
        'height' => 271,
        'method' => 'resize'
    ],
    '310x221' => [
        'width' => 310,
        'height' => 221,
        'method' => 'resize',
    ],
    '310x895' => [
        'width' => 310,
        'height' => 489,
        'method' => 'resize',
    ],
    'product_small' => [
        'width' => 70,
        'height' => 70,
        'method' => 'resize',
    ],

);
