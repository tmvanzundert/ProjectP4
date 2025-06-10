<?php
require_once 'databaseconnection.php';

Class RegisterAccount Extends DatabaseConnection 
{
    // Registers new user account into the database
    private $username;
    private $password;
    private $email;
    private $address;

    public function __construct($username, $password, $email, $address) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->address = $address;
    }
    public function registerAccount(): bool
    {
        $env = parse_ini_file('./.env');
        $dbConnection = new DatabaseConnection($env['db_servername'], $env['db_username'], $env['db_password'], $env['db_name']);
        $conn = $dbConnection->connect();
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO User (Username, Password, EmailAddress, Address) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return False;
        }
        $stmt->execute([$this->username, $hashedPassword, $this->email, $this->address]);
        return True;
    }
}