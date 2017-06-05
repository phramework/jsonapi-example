<?php
declare(strict_types=1);
/*
 * Copyright 2017-2018 Vasilis Manolas
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

use Phramework\Examples\JSONAPI\Models\Review;
use Phramework\Phramework;
use Phramework\Examples\JSONAPI\Models\Article;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Vasilis Manolas <vasileiosmanolas@gmail.com>
 */
class ReviewController extends \Phramework\Examples\JSONAPI\Controller
{
    /**
     * Get collection
     * `/review/` handler
     * @param \stdClass $params    Request parameters
     * @param string $method       Request method
     * @param array  $headers      Request headers
     */
    public static function GET(\stdClass $params, string $method, array $headers)
    {
        static::handleGET(
            $params,
            Review::class,
            [],
            []
        );
    }

    /**
     * Get a resource
     * `/review/{id}/` handler
     * @param \stdClass $params    Request parameters
     * @param string $method       Request method
     * @param array  $headers      Request headers
     * @param string $id           Resource id
     */
    public static function GETById(\stdClass $params, string $method, array $headers, string $id)
    {
        static::handleGETById(
            $params,
            $id,
            Review::class,
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
        static::handlePOST(
            $params,
            $method,
            $headers,
            Review::class
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
        static::handlePATCH(
            $params,
            $method,
            $headers,
            $id,
            Review::class
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
            Review::class
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
            Review::class,
            [Phramework::METHOD_GET],
            [],
            []
        );
    }
}