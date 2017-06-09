<?php

namespace Phramework\Examples\JSONAPI\Controllers\Administrator;

use Phramework\Examples\JSONAPI\IRouting;
use Phramework\Phramework;

/**
 * Administrator API routing class
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
                'user/',
                UserController::class,
                'GET',
                Phramework::METHOD_GET,
                true
            ],
            [
                'user/{id}',
                UserController::class,
                'GETById',
                Phramework::METHOD_GET,
                true
            ],
            [
                'user/',
                UserController::class,
                'POST',
                Phramework::METHOD_POST,
                true
            ],
            [
                'user/{id}',
                UserController::class,
                'PATCH',
                Phramework::METHOD_PATCH,
                true
            ],
            [
                'user/{id}',
                UserController::class,
                'DELETE',
                Phramework::METHOD_DELETE,
                true
            ],
            [
                'user/{id}/relationships/{relationship}',
                UserController::class,
                'byIdRelationships',
                Phramework::METHOD_ANY,
                true
            ],
        ];
    }
}
