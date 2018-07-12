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

    '50x73' => array(
        'width' => 50,
        'height' => 73,
        'method' => 'crop',
    ),
    '80x80' => array(
        'width' => 80,
        'height' => 80,
        'method' => 'crop',
    ),
    '132x193' => array(
        'width' => 173,
        'height' => 231,
        'method' => 'crop',
    ),
    '173x231' => array(
        'width' => 173,
        'height' => 231,
        'method' => 'crop',
    ),
    '315x420' => array(
        'width' => 315,
        'height' => 420,
        'method' => 'crop',
    ),
    '350x466' => array(
        'width' => 350,
        'height' => 466,
        'method' => 'crop',
    ),
);
