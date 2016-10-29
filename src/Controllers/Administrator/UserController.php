<?php
declare(strict_types=1);
/*
 * Copyright 2015-2016 Xenofon Spafaridis
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Phramework\Examples\JSONAPI\Controllers\Administrator;

use Phramework\Examples\JSONAPI\Request;
use Phramework\Phramework;
use Phramework\Examples\JSONAPI\Models\Administrator\User;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class UserController extends \Phramework\Examples\JSONAPI\Controller
{
    /**
     * Get collection
     * @param \stdClass $params    Request parameters
     * @param string $method       Request method
     * @param array  $headers      Request headers
     */
    public static function GET($params, $method, $headers)
    {
        $user = Request::checkPermission();

        static::handleGET(
            $params,
            User::class,
            [],
            []
        );
    }

    /**
     * Get a resource
     * @param \stdClass $params    Request parameters
     * @param string $method       Request method
     * @param array  $headers      Request headers
     * @param string $id           Resource id
     */
    public static function GETById($params, $method, $headers, string $id)
    {
        $user = Request::checkPermission();

        static::handleGETById(
            $params,
            $id,
            User::class,
            [],
            []
        );
    }

    /**
     * Post new resource
     * @param \stdClass $params    Request parameters
     * @param string $method       Request method
     * @param array  $headers      Request headers
     */
    public static function POST(\stdClass $params, string $method, array $headers)
    {
        $user = Request::checkPermission();

        static::handlePOST(
            $params,
            $method,
            $headers,
            User::class
        );
    }

    /**
     * Update a resource
     * @param        $params
     * @param        $method
     * @param        $headers
     * @param string $id
     */
    public static function PATCH(
        \stdClass $params,
        string $method,
        array $headers,
        string $id
    ) {
        $user = Request::checkPermission();

        static::handlePATCH(
            $params,
            $method,
            $headers,
            $id,
            User::class
        );
    }

    /**
     * Delete a resource
     * @param        $params
     * @param        $method
     * @param        $headers
     * @param string $id
     */
    public static function DELETE(
        \stdClass $params,
        string $method,
        array $headers,
        string $id
    ) {
        $user = Request::checkPermission();

        static::handleDELETE(
            $params,
            $method,
            $headers,
            $id,
            User::class
        );
    }

    /**
     * Manage resource's relationships
     * @param \stdClass $params    Request parameters
     * @param string $method       Request method
     * @param array  $headers      Request headers
     * @param string $id           Resource id
     * @param string $relationship Relationship
     */
    public static function byIdRelationships(
        $params,
        $method,
        $headers,
        string $id,
        string $relationship
    ) {
        $user = Request::checkPermission();

        static::handleByIdRelationships(
            $params,
            $method,
            $headers,
            $id,
            $relationship,
            User::class,
            [Phramework::METHOD_GET],
            [],
            []
        );
    }
}
