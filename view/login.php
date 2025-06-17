<?php
require_once './scripts/php/User.php';

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$login = new User($username, $password, null);
$login->login();

class LoginPage extends View
{

    public function show()
    {
        ?>
        <section class="inloggen-banner">
            <h1><?= __('login_heading'); ?></h1>
        </section>

        <section class="login-form">
            <form action="" method="post">
                <label for="username"><?= __('username_label'); ?></label>
                <input type="text" id="username" name="username" required>

                <label for="password"><?= __('password_label'); ?></label>
                <input type="password" id="password" name="password" required>

                <button type="submit"><?= __('login_button'); ?></button>
            </form>
            <p><?= __('no_account_text'); ?> <a href="?view=registratie"><?= __('register_link'); ?></a></p>
        </section>
        <?php
    }
}

new LoginPage();