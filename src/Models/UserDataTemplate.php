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

namespace Phramework\Examples\JSONAPI\Models;

use Phramework\JSONAPI\Resource;
use Phramework\JSONAPI\ValidationModel;
use Phramework\Phramework;
use Phramework\Database\Database;
use Phramework\JSONAPI\Fields;
use Phramework\JSONAPI\Filter;
use Phramework\JSONAPI\Page;
use Phramework\JSONAPI\Sort;
use Phramework\JSONAPI\Relationship;
use Phramework\Validate\ObjectValidator;
use Phramework\Validate\StringValidator;
use Phramework\Validate\UnsignedIntegerValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class UserDataTemplate extends \Phramework\Examples\JSONAPI\Model
{
    protected static $type      = 'user_data_template';
    protected static $endpoint  = 'user_data_template';
    protected static $table     = 'user_data_template';

    /**
     * @param Page     $page
     * @param Filter   $filter
     * @param Sort     $sort
     * @param Fields   $fields
     * @param mixed ...$additionalParameters
     * @return Resource[]
     */
    public static function get(
        Page   $page = null,
        Filter $filter = null,
        Sort   $sort = null,
        Fields $fields = null,
        ...$additionalParameters
    ) {
        $query = static::handleGet(
            'SELECT 
              {{fields}}
            FROM "user_data_template"
              {{filter}}
              {{sort}}
              {{page}}',
            $page,
            $filter,
            $sort,
            $fields,
            false
        );

        $records = Database::executeAndFetchAll(
            $query,
            [ ]
        );

        array_walk(
            $records,
            [static::class, 'prepareRecord']
        );

        return static::collection($records, $fields);
    }

    /**
     * @return string[]
     */
    public static function getFields()
    {
        return ['value'];
    }

}
