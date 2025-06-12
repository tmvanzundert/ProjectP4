<?php

require_once 'data/secrets.php';

class Connector
{

    private static $connection = null;

    public function __construct()
    {
        // Constructor automatically establishes database connection
        // by calling connect() method with credentials from Secrets class
        $this->connect(
            Secrets::$ServerName,
            Secrets::$Username,
            Secrets::$Password,
            Secrets::$DBName
        );
    }

    public function connect($ServerName, $Username, $Password, $DBName)
    {
        try {
            // Create DSN (Data Source Name) string with server, database and charset
            $dsn = "mysql:host={$ServerName};dbname={$DBName};charset=utf8";
            self::$connection = new PDO($dsn, $Username, $Password);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Prepares an SQL statement for execution
     * 
     * @param string $sql SQL query to prepare
     * @return PDOStatement Prepared statement ready for execution
     */
    public function prepare($sql) {
        return self::$connection->prepare($sql);
    }

    /**
     * Prepares and executes an SQL statement with optional parameters
     * 
     * @param string $sql SQL query to execute
     * @param array $args Array of parameters to bind to the query
     * @return bool True on success, false on failure
     */
    public function execute($sql, $args = []) {
        $stmt = $this->prepare($sql);
        return $stmt->execute($args);
    }

}