<?php
declare(strict_types=1);

namespace Phramework\Examples\JSONAPI\Models;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 * @coversDefaultClass \Phramework\Examples\JSONAPI\Models\User
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::getType
     */
    public function testGetType()
    {
        $this->assertSame(
            'user',
            User::getType()
        );
    }
}
