<?php
require_once 'databaseconnection.php';

class User
{
    // Checks the credentials against the database
    private $username;
    private $password;
    private $email;
    private $address;
    public function __construct($username, $password, $email, $address = '')
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->address = $address;
    }

    public function checkLogin(): bool
    {

        $env = parse_ini_file('./.env');
        $dbConnection = new DatabaseConnection($env['db_servername'], $env['db_username'], $env['db_password'], $env['db_name']);
        $conn = $dbConnection->connect();
        $sql = "SELECT password FROM User WHERE username = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->execute([$this->username]);
        $hashedPassword = $stmt->fetchColumn();
        if ($hashedPassword && password_verify($this->password, $hashedPassword)) {
            return true;
        }
        return false;
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

    public function login(): bool
    {
        $checkLogin = $this->checkLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $checkLogin) {
            $this->setloggedin();
            header("Location: index.php");
            exit;
        } else if ($checkLogin) {
            $message = "Server Error, Probeer het later nog eens";
            echo "<script type=\"text/javascript\">alert(\"$message\");window.location = \"login.php\"</script>";
        }
        return false;
    }

    public function setloggedin(): bool
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $this->username;
            return true;
        }
        return false;
    }
}
