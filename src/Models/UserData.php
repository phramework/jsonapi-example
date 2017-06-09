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
use Phramework\Validate\IntegerValidator;
use Phramework\Validate\UnsignedIntegerValidator;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Kostas Nikolopoulos <kosnikolopoulos@gmail.com>
 */
class UserData extends \Phramework\Examples\JSONAPI\Model
{
    protected static $type      = 'user_data';
    protected static $endpoint  = 'user_data';
    protected static $table     = 'user_data';

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
            FROM "user_data"
            WHERE 
              "user_id" = ?
              {{filter}}
              {{sort}}
              {{page}}',
            $page,
            $filter,
            $sort,
            $fields,
            true
        );

        $records = Database::executeAndFetchAll(
            $query,
            [ $additionalParameters[0] ]
        );

        array_walk(
            $records,
            [static::class, 'prepareRecord']
        );

        return static::collection($records, $fields);
    }

    /**
     * Defines model's validator for POST requests
     * also may be used for PATCH requests and to validate filter directive values
     * @return ValidationModel
     */
    public static function getValidationModel()
    {
        return new ValidationModel(
            new ObjectValidator( //attributes
                (object) [ //properties
                    'value'   => new ObjectValidator((object)[], [], true),
                ],
                ['value'], //required attributes,
                false //additional properties
            ),
            new ObjectValidator( //relationships
                (object) [
                    'user' => User::getIdValidator(),
                    'template'=> UserDataTemplate::getIdValidator(),
                ],
                ['template'], //required relationships,
                false //additional properties
            )
        );
    }

    /**
     * @return string[]
     */
    public static function getFields()
    {
        return ['user_id', 'user_data_template_id', 'value'];
    }

    /**
    * Override post behaviour,
    * to encode json value to string
    * @param \stdClass|array $attributes
    * @return string
    */
    public static function post(
        $attributes,
        $return = \Phramework\Database\Operations\Create::RETURN_ID
    ) {
        /*
         * Work with object
         */

        if (is_array($attributes)) {
            $attributes = (object) $attributes;
        }

        if (isset($attributes->value)) {
            $attributes->value = json_encode($attributes->value);
        }

        return parent::post($attributes, $return);
    }

    /**
     * @return \stdClass
     */
    public static function getRelationships()
    {
        return (object) [
            'user' => new Relationship(
                User::class,
                Relationship::TYPE_TO_ONE,
                'user_id', //source data attribute
                null, //source data callback
                Relationship::FLAG_DEFAULT | Relationship::FLAG_DATA
            ),
            'template' => new Relationship(
                UserDataTemplate::class,
                Relationship::TYPE_TO_ONE,
                'user_data_template_id', //source data attribute
                null,
                Relationship::FLAG_DEFAULT | Relationship::FLAG_DATA
            )
        ];
    }

    /**
     * Prepare records
     * @param  array $record Database record row
     * @return array|null on failure
     */
    protected static function prepareRecord(array &$record)
    {
        if (isset($record['value'])) {
            $record['value'] = json_decode($record['value']);
        }
    }
}
