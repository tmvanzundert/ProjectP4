<?php

require_once 'scripts/php/User.php';

use PHPUnit\Framework\TestCase;

class IsUserAdminTest extends TestCase
{

    public function testIsUserAdmin()
    {

        $user = new User('hdevries', 'notherealpassword', null);
        $this->assertTrue($user->isAdmin(), 'User should be an admin');

    }

}