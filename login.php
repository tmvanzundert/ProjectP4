<?php
require_once 'website-components/handlers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'scripts/php/checklogin.php';
    $login = new CheckLogin($_POST['username'], $_POST['password']);
    if ($login->checkLogin()) {
        $_SESSION['username'] = $_POST['username'];
        header("Location: index.php");
    } else {
    $message = "Server Error, Probeer het later nog eens";
    echo "<script type=\"text/javascript\">alert(\"$message\");window.location = \"login.php\"</script>";
    }
    
}
?>


<!DOCTYPE html>
<html>

<?php include 'website-components/head.php'; ?>

<body>

    <?php include 'website-components/header.php'; ?>

    <main>
        <section class="inloggen-banner">
            <h1><?php echo __('login_heading'); ?></h1>
        </section>

        <section class="inlog-form">
            <form id="loginWindow" action="" method="post">
                <label for="username"><?php echo __('username_label'); ?></label>
                <input type="text" id="username" name="username" required>

                <label for="password"><?php echo __('password_label'); ?></label>
                <input type="password" id="password" name="password" required>

                <button type="submit"><?php echo __('login_button'); ?></button>
            </form>
            <p><?php echo __('no_account_text'); ?> <a href="registratie.php"><?php echo __('register_link'); ?></a></p>
        </section>

    </main>

    <?php include 'website-components/footer.php'; ?>

</body>

</html>