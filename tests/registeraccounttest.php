<?php

require_once './scripts/php/User.php';

use PHPUnit\Framework\TestCase;

class Registeraccounttest extends TestCase {
    public function testRegisterAccountWithDuplicateCredentials() {
        $user = new User('testuser', 'testpass', 'test@example.com');
        $user->registerAccount();
        
        $duplicateUser = new User('testuser', 'testpass', 'test@example.com');
        $result = $duplicateUser->registerAccount();
        
        $this->assertNotEquals(true, $result, 'Duplicate registration should not succeed');
    }
}