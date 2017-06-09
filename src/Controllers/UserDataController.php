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

namespace Phramework\Examples\JSONAPI\Controllers;

use Phramework\Examples\JSONAPI\Request;
use Phramework\Examples\JSONAPI\Models\UserData;
use Phramework\Phramework;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class UserDataController extends \Phramework\Examples\JSONAPI\Controller
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
            UserData::class,
            [$user->id],
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
            UserData::class,
            [$user->id],
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
            UserData::class,
            [],
            [],
            [
                /**
                 * A validation callback to inject user id
                 */
                function (
                    \stdClass $requestAttributes,
                    \stdClass $requestRelationships,
                    \stdClass $attributes,
                    \stdClass $parsedRelationshipAttributes
                ) use ($user) {
                    $attributes->user_id = $user->id;
                }
            ],
            /**
             * Override view, by setting a view callback
             * to response with 204 and a Location header
             */
            function (array $ids) {
                //Prepare response with 201 Created status code and Location header
                \Phramework\Models\Response::created(
                    UserData::getSelfLink($ids[0])
                );
                \Phramework\JSONAPI\Viewers\JSONAPI::header();
                //Will overwrite 201 with 204 status code
                \Phramework\Models\Response::noContent();
            }
        );
    }



    /**
     * Manage resource's relationships
     * `/article/{id}/relationships/{relationship}/` handler
     * @param \stdClass $params       Request parameters
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
        static::handleByIdRelationships(
            $params,
            $method,
            $headers,
            $id,
            $relationship,
            UserData::class,
            [Phramework::METHOD_GET],
            [],
            []
        );
    }






}
