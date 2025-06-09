<?php
require_once 'databaseconnection.php';

class CheckLogin extends DatabaseConnection
{
    // Checks the credentials against the database
    public function checkLogin(): bool {
        $conn = $this->connect();

        $sql = "SELECT password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->execute([$this->Username]);
        $hashedPassword = $stmt->fetchColumn();

        if ($hashedPassword && password_verify($this->Password, $hashedPassword)) {
            return true;
        }
        return false;
    }
}