<?php require_once 'framework/connector.php';

class Checklogin extends Connector
{

    private string $username;
    private string $password;

    public function __construct(string $username, string $password) {
        $this->username = $username;
        $this->password = $password;
    }

    // Returns an array with the object values
    public function checkLogin(): array {
        return [
            'username' => $this->getUsername(),
            'password' => $this->getPassword()
        ];
    }

    // Get the username from the object
    public function getUsername(): string {
        return htmlspecialchars($this->username);
    }

    // Get the password from the object
    public function getPassword(): string {
        return htmlspecialchars($this->password);
    }
}

new CheckLogin();