<?php
require_once 'scripts/php/checklogin.php';

class LoginPage extends View
{

    public function show()
    {
        ?>
        <section class="inloggen-banner">
            <h1><?= __('login_heading'); ?></h1>
        </section>

        <section class="login-form">
            <form action="scripts/php/checklogin.php" method="post" onsubmit="return checkLogin()">
                <label for="username"><?= __('username_label'); ?></label>
                <input type="text" id="username" name="username" required>

                <label for="password"><?= __('password_label'); ?></label>
                <input type="password" id="password" name="password" required>

                <button type="submit"><?= __('login_button'); ?></button>
            </form>
            <p><?= __('no_account_text'); ?> <a href="registratie.php"><?= __('register_link'); ?></a></p>
        </section>
        <?php
    }
    function checkLogin()
    {
        return true;
    }
}

new LoginPage();