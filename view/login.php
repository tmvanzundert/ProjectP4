<?php
require_once 'scripts/php/User.php';

class LoginPage extends View
{
    public function show()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $login = new User($username, $password, null);

        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($login->isEmptyLogin() && $login->isSubmitted()) {
                $message = __('empty_fields_error');
            } else if ($login->isBlockedAccount()) {
                $message = __('account_blocked_error');
            } else if (isset($_SESSION['logintries'][$username]) && $_SESSION['logintries'][$username] >= 10) {
                $_SESSION['logintries'][$username] = 0; // Reset the login attempts after blocking
                $login->setBlockedAccount();
                $message = __('account_blocked_error');
            }

            if (empty($message)) {
                $login->login();
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {

                    if ($login->isAdmin()) {
                        header('Location: ?view=admin-pagina');
                    } else {
                        header('Location: ?view=home');
                    }

                    exit();

                } else if ($login->isSubmitted() && empty($message)) {
                    $message = __('wrong_credentials_error');
                }
            }

        }

        ?>

        <section class="inloggen-banner">
            <h1><?= __('login_heading') ?></h1>
        </section>

        <section class="login-form">
            <form id="login" action="" method="post">
                <label for="username"><?= __('username_label'); ?></label>
                <input type="text" id="username" name="username" required>

                <label for="password"><?= __('password_label'); ?></label>
                <input type="password" id="password" name="password" required>

                <button type="submit"><?= __('login_button') ?></button>

                <p><?= __('no_account_text'); ?>
                    <a href="?view=registratie"><?= __('register_link'); ?></a>
                </p>
            </form>

            <?php if (!empty($message)): ?>
                <?php
                if (!isset($_SESSION['logintries']) || !is_array($_SESSION['logintries'])) {
                    $_SESSION['logintries'] = [];
                }
                $_SESSION['logintries'][$username] = ($_SESSION['logintries'][$username] ?? 0) + 1;
                ?>
                <span class="error-message"><?= $message ?></span>
            <?php endif; ?>
        </section>
        <?php
    }
}

new LoginPage();
