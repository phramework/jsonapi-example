<?php
declare(strict_types=1);

$settings = [
    'debug' => true,
    'base' => 'http://localhost:8004/',
    'db' => (object) [
        'adapter' => 'sqlite',
        'file'    => __DIR__ . '/schema/example.sqlite'
    ]
];

//Overwrite setting if localsettings.php exists
if (file_exists(__DIR__ .'/localsettings.php')) {
    include(__DIR__ . '/localsettings.php');
}

return $settings;
