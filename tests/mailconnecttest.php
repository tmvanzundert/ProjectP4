<?php

require_once 'scripts/php/mail.php';
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPUnit\Framework\TestCase;

class MailConnectTest extends TestCase
{
    public function testMailConnection()
    {
        $mail = new Mail('Test User', 'Test Subject', 'This is a test email body.');
        // Test if the mail returns an object
        $this->assertInstanceOf(PHPMailer::class, $mail->Connect(), 'Mail connection should return a PHPMailer object');
    }
}