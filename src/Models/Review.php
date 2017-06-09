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
 * @author Vasilis Manolas <vasileiosmanolas@gmail.com>
 */
class Review extends \Phramework\Examples\JSONAPI\Model
{
    protected static $type      = 'review';
    protected static $endpoint  = 'review';
    protected static $table     = 'review';

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
              {{fields}},
              "user_id"
            FROM "review"
            WHERE "status" <> ?
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
            [
                '0'
            ]
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
                    'score'  => new UnsignedIntegerValidator(1, 10),
                    'status' => (new UnsignedIntegerValidator(0, 1))
                        ->setDefault(1)
                ],
                ['score'], //required attributes,
                false //additional properties
            ),
            new ObjectValidator( //relationships
                (object) [
                    'reviewer' => User::getIdValidator()
                ],
                [], //required relationships,
                false //additional properties
            )
        );
    }

    public static function getPatchValidationModel()
    {
        return new ValidationModel(
            new ObjectValidator( //attributes
                (object) [ //properties
                    'score'  => new UnsignedIntegerValidator(1, 10),
                    'status' => new UnsignedIntegerValidator(0, 1)
                ],
                [], //required attributes,
                false
            ),
            new ObjectValidator( //relationships
                (object) [
                    'reviewer' => User::getIdValidator()
                ],
                [], //required relationships
                false
            )
        );
    }

    /**
     * @return string[]
     */
    public static function getMutable()
    {
        return ['score', 'status']; // 'user_id',   --> do I need to add this?
    }

    /**
     * @return string[]
     */
    public static function getFields()
    {
        return ['score']; // 'user_id',   --> do I need to add this?
    }

    /**
     * Get all reviews with given article id
     * @param string $articleId
     * @return string[]
     */
    public static function getRelationshipArticle(
        string $articleId,
        Fields $fields = null,
        $flags = Resource::PARSE_DEFAULT
    ) {
        $ids = Database::executeAndFetchAllArray(
            'SELECT "article-review"."article_id"
            FROM "article-review"
            JOIN "article"
             ON "article"."id" = "article-review"."article_id"
            WHERE
              "article-review"."article_id" = ?
              AND "article-review"."status" <> 0
              AND "article"."status" <> 0',
            [$articleId]
        );

        return $ids;
    }

//    /**
//     * Get all articles with given creator id
//     * @param string $userId
//     * @return string[]
//     */
//    public static function getRelationshipUser(
//        string $userId,
//        Fields $fields = null,
//        $flags = Resource::PARSE_DEFAULT
//    ) : array {
//        $ids = Database::executeAndFetchAllArray(
//            'SELECT "article"."id"
//            FROM "article"
//            WHERE
//              "article"."creator-user_id" = ?
//              AND "article"."status" <> 0',
//            [$userId]
//        );
//
//        return $ids;
//    }

    /**
     * @return string[]
     */
    public static function getSortable()
    {
        return ['id', 'status'];
    }

    /**
     * @return \stdClass
     */
    public static function getRelationships()
    {
        return (object) [
//            'creator' => new Relationship(
//                User::class,
//                Relationship::TYPE_TO_ONE,
//                'creator-user_id', //source data attribute
//                null, //source data callback
//                Relationship::FLAG_DEFAULT | Relationship::FLAG_DATA
//            ),
            'article' => new Relationship(
                Article::class,
                Relationship::TYPE_TO_MANY,
                null, //source data attribute
                (object) [ //source data callback
                    Phramework::METHOD_GET => [
                        Article::class,
                        'getRelationshipReview'
                    ]
                ],
                Relationship::FLAG_DEFAULT | Relationship::FLAG_DATA
            )
        ];
    }
}
