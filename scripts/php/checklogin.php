<?php
require_once 'databaseconnection.php';

class CheckLogin extends DatabaseConnection
{
    // Checks the credentials against the database
    private $inputUsername;
    private $inputPassword;

    public function __construct($inputUsername, $inputPassword) {
        $this->inputUsername = $inputUsername;
        $this->inputPassword = $inputPassword;
    }
    public function checkLogin(): bool {
        
        $env = parse_ini_file('./.env');
        $dbConnection = new DatabaseConnection($env['db_servername'], $env['db_username'], $env['db_password'], $env['db_name']);
        $conn = $dbConnection->connect();
        $sql = "SELECT password FROM User WHERE username = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->execute([$this->inputUsername]);
        $hashedPassword = $stmt->fetchColumn();
        if ($hashedPassword && password_verify($this->inputPassword, $hashedPassword)) {
            return true;
        }
        return false;
    }
}