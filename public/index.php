<?php

//This autoload path is for loading current version of phramework
require __DIR__ . '/../vendor/autoload.php';

//define controller namespace, as shortcut
define('NS', 'Phramework\\Examples\\JSONAPI\\Controllers\\');

use \Phramework\Phramework;

/**
 * Define APP as function
 */
$APP = function () {

    //Include settings
    $settings = include __DIR__ . '/../settings.php';

    $URIStrategy = new \Phramework\URIStrategy\URITemplate([
        [
            'article/',
            NS . 'ArticleController',
            'GET',
            Phramework::METHOD_GET
        ],
        [
            'article/{id}',
            NS . 'ArticleController',
            'GETById',
            Phramework::METHOD_GET
        ],
        [
            'article/{id}/relationships/{relationship}',
            NS . 'ArticleController',
            'byIdRelationships',
            Phramework::METHOD_ANY
        ],

        [
            'tag/',
            NS . 'TagController',
            'GET',
            Phramework::METHOD_GET
        ],
        [
            'tag/{id}',
            NS . 'TagController',
            'GETById',
            Phramework::METHOD_GET
        ],
        [
            'tag/{id}/relationships/{relationship}',
            NS . 'TagController',
            'byIdRelationships',
            Phramework::METHOD_ANY
        ],

        [
            'user/',
            NS . 'UserController',
            'GET',
            Phramework::METHOD_GET
        ],
        [
            'user/{id}',
            NS . 'UserController',
            'GETById',
            Phramework::METHOD_GET
        ],
        [
            'user/{id}/relationships/{relationship}',
            NS . 'UserController',
            'byIdRelationships',
            Phramework::METHOD_ANY
        ],
    ]);

    //Initialize API
    $phramework = new Phramework($settings, $URIStrategy);

    \Phramework\Database\Database::setAdapter(
        new \Phramework\Database\SQLite($settings['db'])
    );

    Phramework::setViewer(
        \Phramework\JSONAPI\Viewers\JSONAPI::class
    );

    unset($settings);

    //Execute API
    $phramework->invoke();
};

/**
 * Execute APP
 */
$APP();
