<?php

require_once 'constants/index.php';

spl_autoload_register(function ($class) {
    $array_dirs = [
        'core', 'core/common', 'core/metabox', 'handlers', 'helpers',
        'libs', 'metaboxes', 'shortcodes', 'types', 'rest-api'
    ];

    foreach ($array_dirs as $dir) {
        if (file_exists(TEMPLATEPATH . '/inc/' . $dir . '/' . $class . '.php')) {
            require_once TEMPLATEPATH . '/inc/' . $dir . '/' . $class . '.php';
            break;
        }
    }
});

$dirs = ['core', 'handlers', 'shortcodes', 'types', 'rest-api'];
foreach ($dirs as $dir) {
    $files = glob(TEMPLATEPATH . '/inc/' . $dir . '/*.php');

    foreach ($files as $path) {
        $info = pathinfo($path);
        $info['filename']::register();
    }
}

if (!function_exists('dd')) {
    function dd($value)
    {
        exit(var_dump($value));
    }
}