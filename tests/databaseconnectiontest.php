<?php 

require_once './framework/connector.php';

use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase {
    public function testConnection(): void {
        $this->expectNotToPerformAssertions();
        try {
            $connector = new Connector();
            $stmt = $connector->prepare('SELECT 1');
            $stmt->execute();
        } catch (Exception $e) {
            $this->fail('Database connection failed: ' . $e->getMessage());
        }
    }
}