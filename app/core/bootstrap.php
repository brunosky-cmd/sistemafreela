<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/helpers.php';

spl_autoload_register(function (string $class): void {
    $paths = [
        __DIR__ . '/../models/' . $class . '.php',
        __DIR__ . '/../controllers/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

startSession();
