<?php

namespace Phramework\Examples\JSONAPI\Controllers;

use Phramework\Examples\JSONAPI\IRouting;
use Phramework\Phramework;

/**
 * Base API routing class
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 * @since 0.0.0
 */
class Routing implements IRouting
{
    public function getRouting(): array
    {
        return [
            [
                'article/', //URI
                ArticleController::class,
                'GET', //Class method
                Phramework::METHOD_GET, //HTTP Method
            ],
            [
                'article/{id}',
                ArticleController::class,
                'GETById',
                Phramework::METHOD_GET
            ],
            [
                'article/',
                ArticleController::class,
                'POST',
                Phramework::METHOD_POST
            ],
            [
                'article/{id}',
                ArticleController::class,
                'PATCH',
                Phramework::METHOD_PATCH
            ],
            [
                'article/{id}',
                ArticleController::class,
                'DELETE',
                Phramework::METHOD_DELETE
            ],
            [
                'article/{id}/relationships/{relationship}',
                ArticleController::class,
                'byIdRelationships',
                Phramework::METHOD_ANY
            ],
            [
                'article/{id}/{relationship}',
                ArticleController::class,
                'byIdRelationshipsRelated',
                Phramework::METHOD_ANY
            ],

            [
                'tag/',
                TagController::class,
                'GET',
                Phramework::METHOD_GET
            ],
            [
                'tag/{id}',
                TagController::class,
                'GETById',
                Phramework::METHOD_GET
            ],
            [
                'tag/{id}/relationships/{relationship}',
                TagController::class,
                'byIdRelationships',
                Phramework::METHOD_ANY
            ],
            [
                'tag/{id}/{relationship}',
                TagController::class,
                'byIdRelationshipsRelated',
                Phramework::METHOD_ANY
            ],

            [
                'user/',
                UserController::class,
                'GET',
                Phramework::METHOD_GET
            ],
            [
                'user/{id}',
                UserController::class,
                'GETById',
                Phramework::METHOD_GET
            ],
            [
                'user/{id}/relationships/{relationship}',
                UserController::class,
                'byIdRelationships',
                Phramework::METHOD_ANY
            ],
            [
                'user/{id}/{relationship}',
                UserController::class,
                'byIdRelationshipsRelated',
                Phramework::METHOD_ANY
            ],
        ];
    }
}
