<?php
declare(strict_types=1);

namespace Phramework\Examples\JSONAPI\Models;

use PHPUnit\Framework\TestCase;
use Phramework\JSONAPI\Filter;
use Phramework\JSONAPI\Page;

/**
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 * @coversDefaultClass \Phramework\Examples\JSONAPI\Models\User
 */
class UserTest extends TestCase
{

    /**
     * This test will get the user with id 1
     * Depends on user created at tools/database.php
     */
    public function testGetToReturnDefaultUser()
    {
        $users = User::get(
            new Page(1),
            new Filter(
                [1]
            )
        );

        $this->assertCount(1, $users);
    }

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
