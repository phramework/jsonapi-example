<?php
declare(strict_types=1);

namespace Phramework\Examples\JSONAPI;

/**
 * Request model, provides function related to the request
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 */
class Request extends \Phramework\Models\Request
{
    /**
     * @param bool $userId
     * @return \Phramework\Examples\JSONAPI\CurrentUser
     */
    public static function checkPermission($userId = false)
    {
        return parent::checkPermission($userId);
    }
}
