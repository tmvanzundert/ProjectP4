<?php

    session_start();

    require 'website-components/handlers.php';
    require 'scripts/php/info.php';
    $contactFieldsValid = validateContactInfoFields();
    if ($contactFieldsValid === true) {

        $_SESSION['sendSuccessfully'] = true;

        // Empty POST array
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }

    }

    /* var_dump($_POST);
    echo $_POST['submit'];unset($_REQUEST); */

?>

<!DOCTYPE html>
<html>

<?php include 'website-components/head.php'; ?>

<body>

    <?php include 'website-components/header.php'; ?>

    <form action="" method="post" class="contact-form">

        <input type="text" placeholder="Voornaam" name="firstname" value="<?php echo $_POST['firstname'] ?>" >
        <input type="text" placeholder="Achternaam" name="lastname" value="<?php echo $_POST['lastname'] ?>" >
        <input type="email" placeholder="E-mail" name="email" value="<?php echo $_POST['email'] ?>" >
        <input type="text" placeholder="Telefoonnummer" name="phonenumber" value="<?php echo $_POST['phonenumber'] ?>" >
        <input type="text" placeholder="Onderwerp" name="subject" value="<?php echo $_POST['subject'] ?>" >
        <textarea placeholder="Bericht" name="message" ><?php echo $_POST['message'] ?></textarea>
        <input type="submit" name="submit" class="submit-button">
        
    </form>
    <?php if ($contactFieldsValid !== true && $contactFieldsValid !== false) : ?>
        <div class="error-message">
            <p><?php echo $contactFieldsValid; ?></p>
        </div>
    <?php elseif (isset($_SESSION['sendSuccessfully']) && $_SESSION['sendSuccessfully']) : ?>
        <div class="success-message">
            <p>Je bericht is succesvol verzonden!</p>
        </div>
        <?php unset($_SESSION['sendSuccessfully']); ?>
    <?php endif; ?>

    <?php include 'website-components/footer.php'; ?>

</body>

</html>