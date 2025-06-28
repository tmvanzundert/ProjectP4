<?php

require_once './scripts/php/User.php';

use PHPUnit\Framework\TestCase;

class CheckLoginTest extends TestCase
{
    public function testlogin(): void
    {

        $email = $_POST['email'] ?? null;
        $user = new User('test', 'test', $email);
        $checkedlogin = $user->checkLogin();

        $this->assertTrue($checkedlogin, 'login condition has been met');

    }
}