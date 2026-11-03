<?php
/**
 * Plugin Name: Krym — фотографии номеров
 * Description: Фотографии и галереи для всех шести категорий номерного фонда без изменения темы.
 * Version: 1.1.0
 * Author: Website project
 * Text Domain: krym-room-photos
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', function () {
    if (is_admin()) {
        return;
    }

    $root = plugin_dir_path(__FILE__);
    $url  = plugin_dir_url(__FILE__);

    wp_enqueue_style(
        'krym-room-photos',
        $url . 'assets/css/room-photos.css',
        array(),
        filemtime($root . 'assets/css/room-photos.css')
    );

    wp_enqueue_script(
        'krym-room-photos',
        $url . 'assets/js/room-photos.js',
        array(),
        filemtime($root . 'assets/js/room-photos.js'),
        true
    );

    $categories = array(
        'pk1-1' => array(
            'label' => 'ПК 1.1',
            'cover' => 'assets/images/pk1-1/cover.webp',
            'count' => 4,
        ),
        'pk2-2' => array(
            'label' => 'ПК 2.2',
            'cover' => 'assets/images/pk2-2/cover.webp',
            'count' => 5,
        ),
        'pk1-2' => array(
            'label' => 'ПК 1.2',
            'cover' => 'assets/images/pk1-2/cover.webp',
            'count' => 4,
        ),
        'st1-2' => array(
            'label' => 'СТ 1.2',
            'cover' => 'assets/images/st1-2/cover.webp',
            'count' => 3,
        ),
        'chu1-1' => array(
            'label' => 'ЧУ 1.1',
            'cover' => 'assets/images/chu1-1/cover.webp',
            'count' => 6,
        ),
        'luxe2-2' => array(
            'label' => 'Люкс 2.2',
            'cover' => 'assets/images/luxe2-2/cover.webp',
            'count' => 9,
        ),
    );

    foreach ($categories as $key => &$category) {
        // Public checkout uses an original SVG when private media is absent.
        $placeholder = esc_url_raw($url . 'assets/placeholder.svg');
        $category['cover'] = is_file($root . $category['cover'])
            ? esc_url_raw($url . $category['cover'])
            : $placeholder;
        $category['photos'] = array();
        for ($i = 1; $i <= $category['count']; $i++) {
            $photo = 'assets/images/' . $key . '/' . sprintf('%02d', $i) . '.webp';
            if (is_file($root . $photo)) {
                $category['photos'][] = esc_url_raw($url . $photo);
            }
        }
        if (empty($category['photos'])) {
            $category['photos'][] = $placeholder;
        }
        unset($category['count']);
    }
    unset($category);

    wp_localize_script('krym-room-photos', 'KrymRoomPhotos', array(
        'categories' => $categories,
    ));
});
