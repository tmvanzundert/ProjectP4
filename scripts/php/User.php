<?php
require_once 'framework/connector.php';

class User extends connector
{
    // Checks the credentials against the database
    private $username;
    private $password;
    private $email;
    
    /**
     * Constructor - Initialize user object with credentials
     * @param string $username User's username
     * @param string $password User's password (plain text)
     * @param string $email User's email address
     */
    public function __construct($username, $password, $email)
    {
        parent::__construct();
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    /**
     * Validates user credentials against database
     * @return bool True if credentials are valid, false otherwise
     */
    public function checkLogin(): bool
    {
        // Check if required fields are provided
        if ($this->isEmptyLogin()) {
            return false;
        }

        // Retrieve hashed password from database
        $sql = "SELECT password FROM User WHERE username = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute([$this->username]);
        $hashedPassword = $stmt->fetchColumn();

        // Verify password using PHP's password_verify function
        if ($hashedPassword && password_verify($this->password, $hashedPassword)) {
            return true;
        }
        return false;
    }

    /**
     * Handles user login process
     * @return bool True if login successful, false otherwise
     */
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

    /**
     * Sets user session variables after successful login
     * @return bool True if session was set, false if already logged in
     */
    public function setloggedin(): bool
    {
        // Only set session if not already logged in
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $this->username;

            // Determine user role and set session accordingly
            if ($this->isAdmin()) {
                $_SESSION['role'] = 'admin';
            } else {
                $_SESSION['role'] = 'user';
            }

            return true;
        }
        return false;
    }

    /**
     * Creates a new user account in the database
     * @return bool True if account created successfully, false otherwise
     */
    public function createAccount(): bool
    {
        // Validate required registration fields
        if ($this->isEmptyRegister()) {
            return false;
        }

        // Insert new user with default values for optional fields, we do not currently handle these fields during registration or post-registration
        $sql = "INSERT INTO User (Username, Password, EmailAddress, Address, DateOfBirth, FirstName, LastName, PhoneNumber, Role) VALUES (?, ?, ?, '', '1999-01-01', '', '', '', 'user')";
        $stmt = $this->prepare($sql);
        // Hash password using secure hashing algorithm
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->execute([$this->username, $hashedPassword, $this->email]);
        return true;
    }

    /**
     * Handles user registration process
     * @return bool True if registration successful, false otherwise
     */
    public function registerAccount(): bool
    {
        if ($this->isSubmitted()) {
            if ($this->createAccount()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if form was submitted via POST method
     * @return bool True if form submitted, false otherwise
     */
    public function isSubmitted(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Validates login form fields are not empty
     * @return bool True if fields are empty, false otherwise
     */
    public function isEmptyLogin(): bool
    {
        return empty($this->username) || empty($this->password);
    }

    /**
     * Validates registration form fields are not empty
     * @return bool True if fields are empty, false otherwise
     */
    public function isEmptyRegister(): bool
    {
        return empty($this->username) || empty($this->password) || empty($this->email);
    }

    /**
     * Prevents form resubmission by redirecting after POST
     * Implements Post-Redirect-Get pattern
     */
    public function setPostToNull()
    {
        if ($this->isSubmitted()) {
            header("Location: ?view=login");
            exit;
        }
    }

    /**
     * Checks if current user has administrator privileges
     * @return bool True if user is admin, false otherwise
     */
    public function isAdmin(): bool
    {
        if (isset($this->username)) {
            $sql = "SELECT Role FROM User WHERE Username = ?";
            $stmt = $this->prepare($sql);
            $stmt->execute([$this->username]);
            $role = $stmt->fetchColumn();
            // Check for both admin role types
            return $role === 'Super Admin' || $role === 'Administrator';
        }
        return false;
    }

    /**
     * Retrieves complete user details from database
     * @return array User details or empty array if not found
     */
    public function getUserDetails(): array
    {
        if (isset($this->username) && !empty($this->username)) {
            $sql = "SELECT * FROM User WHERE Username = ?";
            $stmt = $this->prepare($sql);
            $stmt->execute([$this->username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return [];
    }

    /**
     * Gets user's full name from database
     * @return string Full name or empty string if not found
     */
    public function getName(): string
    {
        $userDetails = $this->getUserDetails();
        if (!empty($userDetails)) {
            return $userDetails['FirstName'] . ' ' . $userDetails['LastName'];
        }
        return '';
    }

    /**
     * Checks if email address is already registered
     * @return bool True if email exists, false otherwise
     */
    public function isEmailAlreadyRegistered(): bool
    {
        $sql = "SELECT COUNT(*) FROM User WHERE EmailAddress = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute([$this->email]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Checks if username is already taken
     * @return bool True if username exists, false otherwise
     */
    public function isUsernameAlreadyRegistered(): bool
    {
        $sql = "SELECT COUNT(*) FROM User WHERE Username = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute([$this->username]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Blocks user account by updating status
     * @return bool True if account blocked successfully, false otherwise
     */
    public function setBlockedAccount(): bool
    {
        $sql = "UPDATE User SET AccountStatus = 'Blocked' WHERE Username = ?";
        $stmt = $this->prepare($sql);
        return $stmt->execute([$this->username]);
    }

    /**
     * Checks if user account is blocked
     * @return bool True if account is blocked, false otherwise
     */
    public function isBlockedAccount(): bool
    {
        $sql = "SELECT AccountStatus FROM User WHERE Username = ?";
        $stmt = $this->prepare($sql);
        $stmt->execute([$this->username]);
        $status = $stmt->fetchColumn();
        return $status === 'Blocked';
    }
}
