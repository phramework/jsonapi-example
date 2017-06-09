<?php
declare(strict_types=1);

//This autoload path is for loading current version of phramework and other required packages
require __DIR__ . '/../../vendor/autoload.php';

use \Phramework\Phramework;

/**
 * Define APP as function
 */
$APP = function () {

    //Include settings
    $settings = include __DIR__ . '/../../settings.php';

    /*
     * Prepare routing
     */
    $URIStrategy = new \Phramework\URIStrategy\URITemplate(
        (new \Phramework\Examples\JSONAPI\Controllers\Administrator\Routing())
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

    //Set authentication class
    \Phramework\Authentication\Manager::register(
        \Phramework\Authentication\BasicAuthentication\BasicAuthentication::class
    );

    //Set method to fetch user object, including password attribute
    \Phramework\Authentication\Manager::setUserGetByEmailMethod(
        [
            \Phramework\Examples\JSONAPI\Models\Administrator\Authentication::class,
            'getByEmailWithPassword'
        ]
    );

    \Phramework\Authentication\Manager::setAttributes(
        ['email']
    );

    unset($settings);

    //Execute API
    $phramework->invoke();
};

/**
 * Execute APP
 */
$APP();
