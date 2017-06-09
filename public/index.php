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
            'user_data_template/', //URI
            NS . 'UserDataTemplateController', //Class
            'GET', //Class method
            Phramework::METHOD_GET, //HTTP Method
        ],
        [
            'user_data_template/{id}', //URI
            NS . 'UserDataTemplateController', //Class
            'GETById', //Class method
            Phramework::METHOD_GET, //HTTP Method
        ],
        [
            'user_data/', //URI
            NS . 'UserDataController', //Class
            'GET', //Class method
            Phramework::METHOD_GET, //HTTP Method
        ],
        [
            'user_data/{id}', //URI
            NS . 'UserDataController', //Class
            'GETById', //Class method
            Phramework::METHOD_GET, //HTTP Method
        ],
        [
            'user_data/', //URI
            NS . 'UserDataController', //Class
            'POST', //Class method
            Phramework::METHOD_POST, //HTTP Method
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
