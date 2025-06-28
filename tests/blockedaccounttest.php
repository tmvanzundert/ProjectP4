<?php

require_once 'scripts/php/User.php';

use PHPUnit\Framework\TestCase;

class BlockedAccountTest extends TestCase
{
    public function testBlockedAccount()
    {
        $user = new User('test', 'falsepassword', 'test@gmail.com');
        $user->setBlockedAccount();

        $this->assertTrue($user->isBlockedAccount(), 'The account should be blocked');
    }
}