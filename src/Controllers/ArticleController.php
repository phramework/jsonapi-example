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

use Phramework\Phramework;
use Phramework\Examples\JSONAPI\Models\Article;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class ArticleController extends \Phramework\Examples\JSONAPI\Controller
{
    /**
     * Get collection
     * `/article/` handler
     * @param \stdClass $params    Request parameters
     * @param string $method       Request method
     * @param array  $headers      Request headers
     */
    public static function GET(
        \stdClass $params,
        string $method,
        array $headers
    ) {
        static::handleGET(
            $params,
            Article::class,
            [],
            []
        );
    }

    /**
     * Get a resource
     * `/article/{id}/` handler
     * @param \stdClass $params    Request parameters
     * @param string $method       Request method
     * @param array  $headers      Request headers
     * @param string $id           Resource id
     */
    public static function GETById(
        \stdClass $params,
        string $method,
        array $headers,
        string $id
    ) {
        static::handleGETById(
            $params,
            $id,
            Article::class,
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
    public static function POST(
        \stdClass $params,
        string $method,
        array $headers
    ) {
        $now = time();

        static::handlePOST(
            $params,
            $method,
            $headers,
            Article::class,
            [],
            [],
            [
                /**
                 * A validation callback to inject created timestamp
                 */
                function (
                    \stdClass $requestAttributes,
                    \stdClass $requestRelationships,
                    \stdClass $attributes,
                    \stdClass $parsedRelationshipAttributes
                ) use ($now) {
                    $attributes->created = $now;
                }
            ],
            /**
             * Override view, by setting a view callback
             * to response with 204 and a Location header
             */
            function (array $ids) {
                //Prepare response with 201 Created status code and Location header
                \Phramework\Models\Response::created(
                    Article::getSelfLink($ids[0])
                );

                \Phramework\JSONAPI\Viewers\JSONAPI::header();

                //Will overwrite 201 with 204 status code
                \Phramework\Models\Response::noContent();
            }
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
        $now = time();

        static::handlePATCH(
            $params,
            $method,
            $headers,
            $id,
            Article::class,
            [],
            [
                function (
                    string $id,
                    \stdClass $requestAttributes,
                    \stdClass $requestRelationships,
                    \stdClass $attributes,
                    \stdClass $parsedRelationshipAttributes
                ) use ($now) {
                    $attributes->updated = $now;
                }
            ],
            /**
             * Override view, by setting a view callback
             * to response with 204
             */
            function (string $id) {
                \Phramework\Models\Response::noContent();
            }
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
        static::handleDELETE(
            $params,
            $method,
            $headers,
            $id,
            Article::class
        );
    }

    /**
     * Access resource's relationships
     * `/article/{id}/relationships/{relationship}/` handler
     * @param \stdClass $params       Request parameters
     * @param string $method       Request method
     * @param array  $headers      Request headers
     * @param string $id           Resource id
     * @param string $relationship Relationship
     */
    public static function byIdRelationships(
        \stdClass $params,
        string $method,
        array $headers,
        string $id,
        string $relationship
    ) {
        static::handleByIdRelationships(
            $params,
            $method,
            $headers,
            $id,
            $relationship,
            Article::class,
            [Phramework::METHOD_GET],
            [],
            []
        );
    }

    /**
     * Access resource's relationship resources
     * `/article/{id}/{relationship}/` handler
     * @param \stdClass $params
     * @param string    $method
     * @param array     $headers
     * @param string    $id
     * @param string    $relationship
     */
    public static function byIdRelationshipsRelated(
        \stdClass $params,
        string $method,
        array $headers,
        string $id,
        string $relationship
    ) {
        static::handleByIdRelationshipsRelated(
            $params,
            $method,
            $headers,
            $id,
            $relationship,
            Article::class,
            [\Phramework\Phramework::METHOD_GET],
            []
        );
    }
}
