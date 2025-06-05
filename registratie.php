<?php require 'website-components/handlers.php'; ?>

<!DOCTYPE html>
<html>

<?php include 'website-components/head.php'; ?>

<body>

    <?php include 'website-components/header.php'; ?>
    
    <main>
        <section class="registration-banner">
            <h1><?php echo __('registration_heading'); ?></h1>
        </section>

        <section class="registration-form">
            <form action="scripts/php/registration.php" method="post">
                <label for="username"><?php echo __('username_label'); ?></label>
                <input type="text" id="username" name="username" required>

                <label for="email"><?php echo __('email_label'); ?></label>
                <input type="email" id="email" name="email" required>

                <label for="password"><?php echo __('password_label'); ?></label>
                <input type="password" id="password" name="password" required>

                <button type="submit"><?php echo __('register_button'); ?></button>
            </form>
            <p><?php echo __('already_have_account_text'); ?> <a href="login.php"><?php echo __('login_link'); ?></a></p>
        </section>
    </main>
    <?php include 'website-components/footer.php'; ?>

</body>

</html>