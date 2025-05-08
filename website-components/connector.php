<?php

use PDO;
use PDOException;
class Database {

    private $Servername;
    private $Username;
    private $Password;
    private $Database;

    public function __construct($servername, $username, $password, $database) {
        $this->Servername = $servername;
        $this->Username = $username;
        $this->Password = $password;
        $this->Database = $database;
    }

    public function connect() {
        try {
            $connection = new PDO(
                "mysql:host={$this->Servername};dbname={$this->Database}",
                $this->Username,
                $this->Password
            );
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        } catch (PDOException $e) {
            // Log the error message and return null
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function __destruct() {
        // Clear sensitive data
        $this->Servername = null;
        $this->Username = null;
        $this->Password = null;
        $this->Database = null;
    }
}

?>