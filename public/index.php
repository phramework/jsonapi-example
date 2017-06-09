<?php
declare(strict_types=1);

//This autoload path is for loading current version of phramework and other required packages
require __DIR__ . '/../vendor/autoload.php';

use \Phramework\Phramework;

/**
 * Define APP as function
 */
$APP = function () {

    //Include settings
    $settings = include __DIR__ . '/../settings.php';

    /*
     * Prepare routing
     */
    $URIStrategy = new \Phramework\URIStrategy\URITemplate(
        (new \Phramework\Examples\JSONAPI\Controllers\Routing())
            ->getRouting()
    );

    //Initialize API with settings and routing
    $phramework = new Phramework($settings, $URIStrategy);

    //Set database adapter connection
    \Phramework\Database\Database::setAdapter(
        new \Phramework\Database\SQLite($settings['db'])
    );

    //Set preferred viewer as JSON API viewer
    Phramework::setViewer(
        \Phramework\Examples\JSONAPI\Viewers\JSONAPI::class
    );

    unset($settings);

    //Execute API
    $phramework->invoke();
};

/**
 * Execute APP
 */
$APP();
