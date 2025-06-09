<?php

class Secrets {
    public static $Username;
    public static $Password;
    public static $DBName;
    public static $ServerName;

    public function __construct() {

        try {
            $env = parse_ini_file('.env');
        }
        catch (Exception $e) {
            die('Failed to load .env file: ' . $e->getMessage());
        }

        self::$Username = $env['db_username'] ?? '';
        self::$Password = $env['db_password'] ?? '';
        self::$DBName = $env['db_name'] ?? '';
        self::$ServerName = $env['db_servername'] ?? '';
    }
}

// Initialize Secrets
new Secrets();