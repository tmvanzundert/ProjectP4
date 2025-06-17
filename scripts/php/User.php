<?php
require_once 'framework/connector.php';

class User Extends connector
{
    // Checks the credentials against the database
    private $username;
    private $password;
    private $email;
    private $address;
    public function __construct($username, $password, $email, $address = '')
    {
        parent::__construct();
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->address = $address;
    }

    public function checkLogin(): bool
    {
        $sql = "SELECT password FROM User WHERE username = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute([$this->username]);
        $hashedPassword = $stmt->fetchColumn();

        if ($hashedPassword && password_verify($this->password, $hashedPassword)) {
            return true;
        }
        return false;
    }
    
    public function login(): bool
    {
        $checkLogin = $this->checkLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $checkLogin) {
            $this->setloggedin();
            $message = "Logged in";
            echo "<script type=\"text/javascript\">alert(\"$message\");window.location = \"login.php\"</script>";
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

    public function registerAccount(): bool
    {

        $sql = "INSERT INTO User (Username, Password, EmailAddress, Address) VALUES (?, ?, ?, ?)";
        $stmt = $this->prepare($sql);
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->execute([$this->username, $hashedPassword, $this->email, $this->address]);
        return True;
    }
}