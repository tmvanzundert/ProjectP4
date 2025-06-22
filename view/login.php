<?php
require_once 'scripts/php/User.php';


class LoginPage extends View
{

    public function show()
    {

        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $login = new User($username, $password, $email);

        // Handle switching
        isset($_SESSION['loginType']) or $_SESSION['loginType'] = 'login';
        if ((isset($_POST['switch-input']) && $_POST['switch-input'] == '1')) {
            if ($_SESSION['loginType'] == 'login') {
                $_SESSION['loginType'] = 'register';
            }
            else {
                $_SESSION['loginType'] = 'login';
            }
            
            $_SESSION['isSwitched'] = true;
        }
        else {
            $_SESSION['isSwitched'] = false;
        }

        if (isset($_SESSION['loginType']) && $_SESSION['loginType'] == 'register') {
            $login->registerAccount();
            if ($login->isEmptyRegister() && $login->isSubmitted() && $_SESSION['isSwitched'] === false) {
                $message = "Please fill in all fields";
            }

            $title = __('registration_heading');
            $accountText = __('already_have_account_text');
            $linkText = __('login_link');
            $buttonText = __('register_button');
            $showEmail = true;
        }
        else {
            $login->login();
            if ($_SESSION['loggedin'] === true) {
                header('Location: ?view=admin-pagina');
            }
            else if ($login->isEmptyLogin() && $login->isSubmitted() && $_SESSION['isSwitched'] === false) {
                $message = "Please fill in all fields";
            }
            else if ($login->isSubmitted() && $_SESSION['isSwitched'] === false) {
                $message = "Wrong credentials";
            }
            $title = __('login_heading');
            $accountText = __('no_account_text');
            $linkText = __('register_link');
            $buttonText = __('login_button');
            $showEmail = false;
        }
        ?>

        <section class="inloggen-banner">
            <h1><?= $title ?></h1>
        </section>

        <section class="login-form">
            <form id="login" action="" method="post">
                <input type="hidden" id="switch-input" name="switch-input" value="">
                
                <label for="username"><?= __('username_label'); ?></label>
                <input type="text" id="username" name="username" required>
                
                <?php if ($showEmail): ?>
                    <label for="email"><?= __('email_label'); ?></label>
                    <input type="email" name="email" required>
                <?php endif; ?>
                
                <label for="password"><?= __('password_label'); ?></label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit"><?= $buttonText ?></button>
                
                <p><?= $accountText ?>
                    <a href="javascript:void(0);" onclick="switchForm();"><?= $linkText ?></a>
                </p>
            </form>
            
            <?php if (isset($message)): ?>
                <span class="error-message"><?= $message ?></span>
            <?php endif; ?>
        </section>

        <script>
        function switchForm() {
            document.getElementById('switch-input').value = '1';
            document.getElementById('login').submit();
        }
        </script>
        <?php
    }
}

new LoginPage();