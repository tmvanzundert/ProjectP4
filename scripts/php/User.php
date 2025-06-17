<?php
require_once 'framework/connector.php';

class User Extends connector
{
    // Checks the credentials against the database
    private $username;
    private $password;
    private $email;
    public function __construct($username, $password, $email)
    {
        parent::__construct();
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($checkLogin) {
                $this->setloggedin();
                $message = "Successfully logged in.";
                echo "<script type=\"text/javascript\">alert(\"$message\");window.location = \"?view=admin-pagina\";</script>";
                exit;
            } else {
                $message = "Wrong credentials.";
                echo "<script type=\"text/javascript\">alert(\"$message\");window.location = \"?view=login\";</script>";
                exit;
            }
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

    // Renamed to createAccount to better reflect its purpose
    public function createAccount(): bool
    {
        $sql = "INSERT INTO User (Username, Password, EmailAddress) VALUES (?, ?, ?)";
        $stmt = $this->prepare($sql);
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->execute([$this->username, $hashedPassword, $this->email]);
        return true;
    }

    public function registerAccount(): void
    {  
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->createAccount()) {
                $message = "Account is succesvol aangemaakt. Ga terug naar het login scherm om in te loggen";
                echo "<script type=\"text/javascript\">alert(\"$message\");window.location = \"?view=login\" </script>";
                exit;
            } else {
                $message = "Server Error, Probeer het later nog eens";
                echo "<script type=\"text/javascript\">alert(\"$message\");window.location = \"?view=registratie\" </script>";
                exit;
            }
        }
    }
}
