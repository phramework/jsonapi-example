<?php
declare(strict_types=1);

//This autoload path is for loading current version of phramework and other required packages
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

    /**
     * Prepare routing
     */
    $URIStrategy = new \Phramework\URIStrategy\URITemplate([
        [
            'article/', //URI
            NS . 'ArticleController', //Class
            'GET', //Class method
            Phramework::METHOD_GET, //HTTP Method
        ],
        [
            'article/{id}',
            NS . 'ArticleController',
            'GETById',
            Phramework::METHOD_GET
        ],
        [
            'article/',
            NS . 'ArticleController',
            'POST',
            Phramework::METHOD_POST
        ],
        [
            'article/{id}',
            NS . 'ArticleController',
            'PATCH',
            Phramework::METHOD_PATCH
        ],
        [
            'article/{id}',
            NS . 'ArticleController',
            'DELETE',
            Phramework::METHOD_DELETE
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
        [
            'review/', //URI
            NS . 'ReviewController', //Class
            'GET', //Class method
            Phramework::METHOD_GET, //HTTP Method
        ],
        [
            'review/{id}',
            NS . 'ReviewController',
            'GETById',
            Phramework::METHOD_GET
        ],
        [
            'review/',
            NS . 'ReviewController',
            'POST',
            Phramework::METHOD_POST
        ],
        [
            'review/{id}',
            NS . 'ReviewController',
            'PATCH',
            Phramework::METHOD_PATCH
        ],
        [
            'review/{id}/relationships/{relationship}',
            NS . 'ReviewController',
            'byIdRelationships',
            Phramework::METHOD_ANY
        ],
    ]);

    //Initialize API with settings and routing
    $phramework = new Phramework($settings, $URIStrategy);

    //Set database adapter connection
    \Phramework\Database\Database::setAdapter(
        new \Phramework\Database\SQLite($settings['db'])
    );

    //Set preferred viewer as JSON API viewer
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
