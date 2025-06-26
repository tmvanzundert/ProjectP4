<?php
require_once 'scripts/php/User.php';

class Registratie extends View
{
    public function show()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $email = $_POST['email'] ?? null;
        $user = new User($username, $password, $email);

        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($user->isEmptyRegister()) {
                $message = __('empty_fields_error');
            }
            else if ($user->isEmailAlreadyRegistered()) {
                $message = __('email_already_registered_error');
            }
            else if ($user->isUsernameAlreadyRegistered()) {
                $message = __('username_already_registered_error');
            }
            else {
                $user->registerAccount();
            }

            if ($user->isSubmitted()) {
                header('Location: ?view=login');
                exit();
            }

        }

        ?>

        <section class="inloggen-banner">
            <h1><?= __('registration_heading') ?></h1>
        </section>

        <section class="login-form">
            <form id="register" action="" method="post">
                <label for="username"><?= __('username_label'); ?></label>
                <input type="text" id="username" name="username" required>
                
                <label for="password"><?= __('password_label'); ?></label>
                <input type="password" id="password" name="password" required>
                
                <label for="email"><?= __('email_label'); ?></label>
                <input type="email" name="email" required>
                
                <button type="submit"><?= __('register_button') ?></button>
            </form>

            <p><?php echo __('already_have_account_text'); ?>
                <a href="?view=login"><?php echo __('login_link'); ?></a>
            </p>
            
            <?php if (!empty($message)): ?>
                <span class="error-message"><?= $message ?></span>
            <?php endif; ?>
        </section>
        <?php
    }
}

new Registratie();
