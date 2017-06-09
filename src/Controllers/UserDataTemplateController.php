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
use Phramework\Examples\JSONAPI\Models\UserDataTemplate;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class UserDataTemplateController extends \Phramework\Examples\JSONAPI\Controller
{
    /**
     * Get collection
     * @param \stdClass $params    Request parameters
     * @param string $method       Request method
     * @param array  $headers      Request headers
     */
    public static function GET( \stdClass $params, string $method, array $headers)
    {
        static::handleGET(
            $params,
            UserDataTemplate::class,
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
    public static function GETById( \stdClass $params, string $method, array $headers, string $id)
    {
        static::handleGETById(
            $params,
            $id,
            UserDataTemplate::class,
            [],
            []
        );
    }


}
