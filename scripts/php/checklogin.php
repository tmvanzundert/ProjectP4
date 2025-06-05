<?php require_once 'databaseconnection.php';

class CheckLogin extends DatabaseConnection
{

    private string $username;
    private string $password;

    public function __construct(string $username, string $password) {
        $this->username = $username;
        $this->password = $password;
    }

    // Returns an array with the object values
    public function checkLogin(): array {
        try {
            return [
            'username' => $this->getUsername(),
            'password' => $this->getPassword()
        ];
        } 
        catch (Exception $e) {
            return [
                'error' => 'An error occurred while checking login: ' . $e->getMessage()
            ];
        }
    }

    // Get the username from the object
    public function getUsername(): string {
        return htmlspecialchars($this->username);
    }

    // Get the password from the object
    public function getPassword(): string {
        return htmlspecialchars($this->password);
    }

    public function 
}