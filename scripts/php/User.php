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

        if ($this->isEmptyLogin()) {
            return false;
        }

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
        if ($this->isSubmitted()) {
            if ($checkLogin) {
                $this->setloggedin();
                return true;
            }
        }
        return false;
    }

    public function setloggedin(): bool
    {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $this->username;

            if ($this->isAdmin()) {
                $_SESSION['role'] = 'admin';
            } else {
                $_SESSION['role'] = 'user';
            }

            return true;
        }
        return false;
    }

    // Renamed to createAccount to better reflect its purpose
    public function createAccount(): bool
    {

        if ($this->isEmptyRegister()) {
            return false;
        }

        $sql = "INSERT INTO User (Username, Password, EmailAddress, Address, DateOfBirth, FirstName, LastName, PhoneNumber, Role) VALUES (?, ?, ?, '', '1999-01-01', '', '', '', 'user')";
        $stmt = $this->prepare($sql);
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->execute([$this->username, $hashedPassword, $this->email]);
        return true;
    }

    public function registerAccount(): bool
    {  
        if ($this->isSubmitted()) {
            if ($this->createAccount()) {
                return true;
            }
        }

        return false;
    }

    // Checks if the form is submitted
    public function isSubmitted(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isEmptyLogin(): bool {
        return empty($this->username) || empty($this->password);
    }

    public function isEmptyRegister(): bool {
        return empty($this->username) || empty($this->password) || empty($this->email);
    }

    // Sets the POST array to null to prevent resubmission on page refresh
    public function setPostToNull() {
        if ($this->isSubmitted()) {
            header("Location: ?view=login");
            exit;
        }
    }

    public function isAdmin(): bool {
        if (isset($this->username)) {
            $sql = "SELECT Role FROM User WHERE Username = ?";
            $stmt = $this->prepare($sql);
            $stmt->execute([$this->username]);
            $role = $stmt->fetchColumn();
            return $role === 'Super Admin' || $role === 'Administrator';
        }
        return false;
    }

    public function getUserDetails(): array {
        if (isset($this->username) && !empty($this->username)) {
            $sql = "SELECT * FROM User WHERE Username = ?";
            $stmt = $this->prepare($sql);
            $stmt->execute([$this->username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function getName(): string {
        $userDetails = $this->getUserDetails();
        if (!empty($userDetails)) {
            return $userDetails['FirstName'] . ' ' . $userDetails['LastName'];
        }
        return '';
    }

    public function isEmailAlreadyRegistered(): bool {
        $sql = "SELECT COUNT(*) FROM User WHERE EmailAddress = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute([$this->email]);
        return $stmt->fetchColumn() > 0;
    }

    public function isUsernameAlreadyRegistered(): bool {
        $sql = "SELECT COUNT(*) FROM User WHERE Username = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute([$this->username]);
        return $stmt->fetchColumn() > 0;
    }

    public function setBlockedAccount(): bool {
        $sql = "UPDATE User SET AccountStatus = 'Blocked' WHERE Username = ?";
        $stmt = $this->prepare($sql);
        return $stmt->execute([$this->username]);
    }

    public function isBlockedAccount(): bool {
        $sql = "SELECT AccountStatus FROM User WHERE Username = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute([$this->username]);
        $status = $stmt->fetchColumn();
        return $status === 'Blocked';
    }
}
