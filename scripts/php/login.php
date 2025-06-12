<?php

class Login extends Connector {

    public string $Username;
    public string $Password;
    public bool $RememberMe;

    public function __construct(string $username, string $password, bool $rememberMe = false) {
        $this->Username = htmlspecialchars($username);
        $this->Password = htmlspecialchars($password);
        $this->RememberMe = $rememberMe;
    }

    public function getUsername(): string {
        return $this->Username;
    }

    public function getRememberMe(): bool {
        return $this->RememberMe;
    }

    public function setLoggedIn(): void {
        session_start();
        $_SESSION['username'] = $this->getUsername();
        $_SESSION['loggedin'] = true;

        if ($this->getRememberMe()) {
            setcookie('username', $this->getUsername(), time() + (86400 * 30), "/"); // 30 days
        }
    }

}