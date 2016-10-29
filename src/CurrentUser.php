<?php
declare(strict_types=1);

namespace Phramework\Examples\JSONAPI;

/**
 * Current user object, returned by Request::checkPermission methods
 * @property-read string id
 * @property-read string email
 */
abstract class CurrentUser
{
}
