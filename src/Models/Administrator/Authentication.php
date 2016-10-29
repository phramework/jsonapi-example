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

/**
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class Authentication
{
    /**
     * @param string $email
     * @return array|bool
     */
    public static function getByEmailWithPassword(string $email)
    {
        $row = Database::executeAndFetch(
            'SELECT *
            FROM "user"
            WHERE 
              "email" = ?
              AND "status" <> 0',
            [$email]
        );

        if (!$row) {
            return false;
        }

        return $row;
    }
}
