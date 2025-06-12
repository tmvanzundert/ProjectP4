<?php require 'website-components/handlers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'scripts/php/User.php';
    $register = new User($_POST['username'], $_POST['password'], $_POST['email'], $_POST['address']);
    if ($register->registerAccount()) {
        $message = "Account is succesvol aangemaakt. Ga terug naar het login scherm om in te loggen";
        echo "<script type=\"text/javascript\">alert(\"$message\");window.location = \"login.php\" </script>";
    } else {
    $message = "Server Error, Probeer het later nog eens";
    echo "<script type=\"text/javascript\">alert(\"$message\");window.location = \"registratie.php\" </script>";
    }

}
?>

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

                <label for="address">Address</label>
                <input type="address" id="address" name="address" required>

                <button type="submit"><?php echo __('register_button'); ?></button>
            </form>
            <p><?php echo __('already_have_account_text'); ?> <a href="login.php"><?php echo __('login_link'); ?></a>
            </p>
        </section>
        <?php
    }
}

new Registratie();
