<?php
require_once 'scripts/php/checklogin.php';

class Login extends View
{

    public function show()
    {
        ?>
        <section class="inloggen-banner">
            <h1><?php echo __('login_heading'); ?></h1>
        </section>

        <section class="login-form">
            <form action="scripts/php/checklogin.php" method="post" onsubmit="return checkLogin()">
                <label for="username"><?php echo __('username_label'); ?></label>
                <input type="text" id="username" name="username" required>

                <label for="password"><?php echo __('password_label'); ?></label>
                <input type="password" id="password" name="password" required>

                <button type="submit"><?php echo __('login_button'); ?></button>
            </form>
            <p><?php echo __('no_account_text'); ?> <a href="registratie.php"><?php echo __('register_link'); ?></a></p>
        </section>
        <?php
    }
    function checkLogin()
    {
        return true;
    }
}

new Login();