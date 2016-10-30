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
namespace Phramework\Examples\JSONAPI\Models\Administrator;

use Phramework\Database\Database;
use Phramework\JSONAPI\Fields;
use Phramework\JSONAPI\Filter;
use Phramework\JSONAPI\Page;
use Phramework\JSONAPI\Sort;
use Phramework\JSONAPI\ValidationModel;
use Phramework\Validate\EmailValidator;
use Phramework\Validate\ObjectValidator;
use Phramework\Validate\StringValidator;
use Phramework\Validate\UnsignedIntegerValidator;

/**
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class User extends \Phramework\Examples\JSONAPI\Models\User
{
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
            FROM "user"
              {{filter}}
              {{sort}}
              {{page}}',
            $page,
            $filter,
            $sort,
            $fields,
            false //query has where
        );

        $records = Database::executeAndFetchAll($query);

        array_walk(
            $records,
            [static::class, 'prepareRecord']
        );

        return static::collection($records, $fields);
    }

    /**
     * Override post to hash password if it set
     * @param \stdClass $attributes
     * @param int   $return
     * @return mixed
     */
    public static function post(
        $attributes,
        $return = \Phramework\Database\Operations\Create::RETURN_ID
    ) {
        if (is_array($attributes)) {
            $attributes = (object) $attributes;
        }

        if (isset($attributes->password)) {
            $attributes->password = User::getHash($attributes->password);
        }

        return parent::post($attributes, $return);
    }

    /**
     * Override post to hash password if it set
     * @param mixed  $id
     * @param \stdClass $attributes
     * @return int
     */
    public static function patch($id, $attributes)
    {
        if (is_array($attributes)) {
            $attributes = (object) $attributes;
        }

        if (isset($attributes->password)) {
            $attributes->password = User::getHash($attributes->password);
        }

        return parent::patch($id, $attributes);
    }

    /**
     * @return ValidationModel
     */
    public static function getValidationModel()
    {
        return new ValidationModel(
            new ObjectValidator(
                (object) [
                    'username' => new StringValidator(2, 24),
                    'email'    => new EmailValidator(),
                    'name'     => new StringValidator(3, 32),
                    'status'   => new UnsignedIntegerValidator(0, 1),
                    'password' => new StringValidator(3, 32)
                ],
                [
                    'username',
                    'email',
                    'name',
                    'status',
                    'password'
                ],
                false
            )
        );
    }

    /**
     * @return string[]
     */
    public static function getMutable()
    {
        return [
            'username',
            'email',
            'name',
            'status',
            'password'
        ];
    }

    /**
     * @return string[]
     */
    public static function getFields()
    {
        return [
            'username',
            'email',
            'name',
            'status'
        ];
    }

    /**
     * @return \stdClass
     */
    public static function getDefaultFields()
    {
        return new Fields((object) [
            static::getType() => static::getFields()
        ]);
    }

    /**
     * Return a password hash.
     * @param string $password
     * @uses password_hash https://secure.php.net/manual/en/function.password-hash.php
     * @return string Will return a standard crypt() compatible hash using the
     * "$2y$" identifier. The result will always be a 60 character string.
     */
    public static function getHash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @inheritdoc
     */
    public static function prepareRecord(array &$record)
    {
        //Although not needed, we make sure password column is removed from record
        unset($record['password']);
    }
}
