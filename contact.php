<?php

require_once 'website-components/handlers.php';
require_once 'scripts/php/info.php';
$contactFieldsValid = validateContactInfoFields();
if ($contactFieldsValid === true) {

    $_SESSION['sendSuccessfully'] = true;

    // Empty POST array
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

}

?>

<!DOCTYPE html>
<html>

<?php include 'website-components/head.php'; ?>

<body>

    <?php include 'website-components/header.php'; ?>

    <section class="contact-banner">
        <div>
            <h1>Contact</h1>
        </div>
    </section>

    <section class="contact-info">
        <form class="info-form" action="" method="post" class="contact-form">

            <input id="firstname" class="textbox <?php echo $_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['firstname'] == "" ? "textbox-error" : ''; ?>"
                type="text" placeholder="Voornaam" name="firstname" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : ''; ?>"
                oninput="setErrorEmptyInputbox('firstname')">
            <input id="lastname" class="textbox <?php echo $_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['lastname'] == "" ? "textbox-error" : ''; ?>"
                type="text" placeholder="Achternaam" name="lastname" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : ''; ?>"
                oninput="setErrorEmptyInputbox('lastname')">
            <input id="email" class="textbox <?php echo $_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['email'] == "" ? "textbox-error" : ''; ?>"
                type="email" placeholder="E-mail" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"
                oninput="setErrorEmptyInputbox('email')">
            <input id="phonenumber" class="textbox <?php echo $_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['phonenumber'] == "" ? "textbox-error" : ''; ?>"
                type="text" placeholder="Telefoonnummer" name="phonenumber" value="<?php echo isset($_POST['phonenumber']) ? $_POST['phonenumber'] : ''; ?>"
                oninput="setErrorEmptyInputbox('phonenumber')">
            <input id="subject" class="textbox <?php echo $_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['subject'] == "" ? "textbox-error" : ''; ?>"
                type="text" placeholder="Onderwerp" name="subject" value="<?php echo isset($_POST['subject']) ? $_POST['subject'] : ''; ?>"
                oninput="setErrorEmptyInputbox('subject')">
            <textarea id="message" class="textbox <?php echo $_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['message'] == "" ? "textbox-error" : ''; ?>"
                placeholder="Bericht" name="message" oninput="setErrorEmptyInputbox('message')"><?php echo isset($_POST['message']) ? $_POST['message'] : ''; ?></textarea>
            <button type="submit">Verstuur</button>
            <!-- <input type="submit" name="submit" class="submit-button"> -->
            <p>
                <?php if ($contactFieldsValid !== true && $contactFieldsValid !== false): ?>
                    <div class="error-message">
                        <p><?php echo $contactFieldsValid; ?></p>
                    </div>
                <?php elseif (isset($_SESSION['sendSuccessfully']) && $_SESSION['sendSuccessfully']): ?>
                    <div class="success-message">
                        <p>Je bericht is succesvol verzonden!</p>
                    </div>
                    <?php unset($_SESSION['sendSuccessfully']); ?>
                <?php endif; ?>
            </p>
        </form>

            

        <div class="info-text">

            <h2>DE KOFFIE STAAT KLAAR!</h2>
            <p>
                Bent u nieuwsgierig geworden naar de mogelijkheden om samen met ons te werken? Neem dan contact met ons
                op.
                In een persoonlijk gesprek vertellen wij u graag meer.
                U vindt ons in het Brabantse Breda.
                Wij zorgen dat de koffie klaarstaat!
            </p>
            <h3>U kunt ons bereiken op:</h3>
            <p>Plug & Play
            <p>
            <p>Hogeschoollaan 1</p>
            <p>4818 CR Breda</p>

            <P>Telefoon: <a href="tel:0031850073030">088 525 7500</a></p>
            <p>E-mail: <a href="mailto:info@plugplay.pro">info@plugplay.pro</a></p>

        </div>

        <div class="info-map">
            <h3>Bekijk ons op de kaart</h3>

            <iframe width="30%" height="60%"
                src="https://www.openstreetmap.org/export/embed.html?bbox=4.795634150505067%2C51.5823632693168%2C4.799271225929261%2C51.58643982276231&amp;layer=mapnik&amp;marker=51.58440159175703%2C4.797452688217163"
                style="border: 1px solid black">
            </iframe>
        </div>

    </section>

    

    <?php include 'website-components/footer.php'; ?>

</body>

</html>