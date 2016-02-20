<?php
/**
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
use Phramework\Phramework;
use Phramework\Database\Database;
use Phramework\JSONAPI\Fields;
use Phramework\JSONAPI\Filter;
use Phramework\JSONAPI\Page;
use Phramework\JSONAPI\Sort;
use Phramework\JSONAPI\Relationship;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class Article extends \Phramework\Examples\JSONAPI\Model
{
    protected static $type      = 'article';
    protected static $endpoint  = 'article';
    protected static $table     = 'article';

    /**
     * @param Page|null     $page
     * @param Filter|null   $filter
     * @param Sort|null     $sort
     * @param Fields|null   $fields
     * @param mixed ...     $additionalParameters
     * @return Resource[]
     */
    public static function get(
        Page   $page = null,
        Filter $filter = null,
        Sort   $sort = null,
        Fields $fields = null,
        ...$additionalParameters
    ) {
        $query = self::handleGet(
            'SELECT {{fields}}, "creator-user_id"
            FROM "article"
            WHERE "status" <> 0
            {{filter}}
            {{sort}}
            {{page}}',
            $page,
            $filter,
            $sort,
            $fields,
            true
        );

        $records = Database::executeAndFetchAll($query);

        return self::collection($records, $fields);
    }

    public static function getFields()
    {
        return ['title', 'body'];
    }

    /**
     * @param string $tagId
     * @return string[]
     */
    public static function getRelationshipTag(
        $tagId,
        Fields $fields = null,
        $flags = Resource::PARSE_DEFAULT
    ) {
        $ids = Database::executeAndFetchAllArray(
            'SELECT "article-tag"."article_id"
            FROM "article-tag"
            JOIN "article"
             ON "article"."id" = "article-tag"."article_id"
            WHERE "article-tag"."tag_id" = ?
              AND "article-tag"."status" <> 0
              AND "article"."status" <> 0',
            [$tagId]
        );

        return $ids;
    }

    /**
     * @param string $userId
     * @return string[]
     */
    public static function getRelationshipUser(
        $userId,
        Fields $fields = null,
        $flags = Resource::PARSE_DEFAULT
    ) {
        $ids = Database::executeAndFetchAllArray(
            'SELECT "article"."id"
            FROM "article"
            WHERE "article"."creator-user_id" = ?
              AND "article"."status" <> 0',
            [$userId]
        );

        return $ids;
    }

    /**
     * @return object
     */
    public static function getRelationships()
    {
        return (object) [
            'creator' => new Relationship(
                User::class,
                Relationship::TYPE_TO_ONE,
                'creator-user_id',
                null,
                Relationship::FLAG_DEFAULT | Relationship::FLAG_DATA
            ),
            'tag' => new Relationship(
                Tag::class,
                Relationship::TYPE_TO_MANY,
                null,
                (object) [
                    Phramework::METHOD_GET   => [Tag::class, 'getRelationshipArticle']
                ],
                Relationship::FLAG_DEFAULT | Relationship::FLAG_DATA
            )
        ];
    }
}
