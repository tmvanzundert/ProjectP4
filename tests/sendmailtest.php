<?php

require_once 'scripts/php/mail.php';

use PHPUnit\Framework\TestCase;

class SendMailTest extends TestCase
{

    public function testSendMail()
    {

        $mail = new Mail('Test User', 'Test Subject', 'This is a test email body.');
        $send = $mail->SendMail();
        $this->assertTrue($send, 'Mail should be sent successfully');

    }

}