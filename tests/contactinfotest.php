<?php

require_once './scripts/php/contactinfo.php';

use PHPUnit\Framework\TestCase;

class ContactInfoTest extends TestCase {
    public function testContactInfoObjectStoresValues() {
        $contact = new ContactInfo('John', 'Doe', 'john@example.com', '0612345678', 'Test Subject', 'This is a test message with more than twenty characters.');
        $values = $contact->setObjectValues();
        $this->assertEquals('John', $values['firstname']);
        $this->assertEquals('Doe', $values['lastname']);
        $this->assertEquals('john@example.com', $values['email']);
        $this->assertEquals('0612345678', $values['phonenumber']);
        $this->assertEquals('Test Subject', $values['subject']);
        $this->assertEquals('This is a test message with more than twenty characters.', $values['message']);
    }
}
