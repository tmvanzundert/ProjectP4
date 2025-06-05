<?php

class DatabaseConnection
{

    public $Servername;
    public $Username;
    public $Password;
    public $Database;



    public function __construct($servername, $username, $password, $database)
    {
        $this->Servername = $servername;
        $this->Username = $username;
        $this->Password = $password;
        $this->Database = $database;
    }

    public function connect()
    {
        try {
            $dsn = "mysql:host={$this->Servername};dbname={$this->Database};charset=utf8mb4";
            $connection = new PDO($dsn, $this->Username, $this->Password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        } catch (Exception $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function update($table, $fields, $where) {
        
    }


    public function __destruct()
    {
        $this->Servername = null;
        $this->Username = null;
        $this->Password = null;
        $this->Database = null;
    }

}




