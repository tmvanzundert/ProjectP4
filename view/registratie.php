<?php require './scripts/php/User.php';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : null;

$register = new User($username, $password, $email);
$register->registerAccount();

class Registratie extends View
{

    public function show()
    {
        ?>
        <section class="registration-banner">
            <h1><?php echo __('registration_heading'); ?></h1>
        </section>

        <section class="registration-form">
            <form action="" method="post">
                <label for="username"><?php echo __('username_label'); ?></label>
                <input type="text" id="username" name="username" required>

                <label for="email"><?php echo __('email_label'); ?></label>
                <input type="email" id="email" name="email" required>

                <label for="password"><?php echo __('password_label'); ?></label>
                <input type="password" id="password" name="password" required>

                <button type="submit"><?php echo __('register_button'); ?></button>
            </form>
            <p><?php echo __('already_have_account_text'); ?> <a href="?view=login"><?php echo __('login_link'); ?></a>
            </p>
        </section>
        <?php
    }
}

new Registratie();
