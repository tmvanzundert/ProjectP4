<?php require_once 'website-components/handlers.php'; ?>

<!DOCTYPE html>
<html>

<!-- Load the head in -->
<?php include 'website-components/head.php'; ?>

<body>

    <!-- Load the header in -->
    <?php include 'website-components/header.php'; ?>

    <?php

        require_once 'scripts/php/contactinfo.php';

        // Create the ContactInfo object
        $contactInfo = new ContactInfo(
            $_POST['firstname'] ?? '',
            $_POST['lastname'] ?? '',
            $_POST['email'] ?? '',
            $_POST['phonenumber'] ?? '',
            $_POST['subject'] ?? '',
            $_POST['message'] ?? ''
        );

        // Run checks to check if the submitted data is valid
        $contactFieldsValid = $contactInfo->validateContactInfoFields();
        if ($contactFieldsValid === true) {
            $_SESSION['sendSuccessfully'] = true;
            $contactInfo->setPostToNull();
        }

    ?>

    <section class="contact-banner">
        <div>
            <h1>Contact</h1>
        </div>
    </section>

    <section class="contact-info">
        <form class="info-form" action="" method="post" class="contact-form">

            <!-- First name textbox -->
            <input id="firstname" class="<?php echo $contactInfo->getTextboxClass('firstname'); ?>" type="text"
                   placeholder="Voornaam" name="firstname" value="<?php echo $contactInfo->getFirstName(); ?>"
                   oninput="setErrorEmptyInputbox('firstname')">

            <!-- Last name textbox -->
            <input id="lastname" class="<?php echo $contactInfo->getTextboxClass('lastname'); ?>" type="text"
                   placeholder="Achternaam" name="lastname" value="<?php echo $contactInfo->getLastName(); ?>"
                   oninput="setErrorEmptyInputbox('lastname')">
            
            <!-- Email textbox -->
            <input id="email" class="<?php echo $contactInfo->getTextboxClass('email'); ?>" type="email"
                   placeholder="E-mail" name="email" value="<?php echo $contactInfo->getEmail(); ?>"
                   oninput="setErrorEmptyInputbox('email')">

            <!-- Phonenumber textbox -->
            <input id="phonenumber" class="<?php echo $contactInfo->getTextboxClass('phonenumber'); ?>" type="text"
                   placeholder="Telefoonnummer" name="phonenumber" value="<?php echo $contactInfo->getPhonenumber(); ?>"
                   oninput="setErrorEmptyInputbox('phonenumber')">

            <!-- Subject textbox -->
            <input id="subject" class="<?php echo $contactInfo->getTextboxClass('subject'); ?>" type="text"
                   placeholder="Onderwerp" name="subject" value="<?php echo $contactInfo->getSubject(); ?>"
                   oninput="setErrorEmptyInputbox('subject')">

            <!-- Message textbox -->
            <textarea id="message" class="<?php echo $contactInfo->getTextboxClass('message'); ?>"placeholder="Bericht"
                      name="message" oninput="setErrorEmptyInputbox('message')"><?php echo $contactInfo->getMessage(); ?></textarea>

            <!-- Send the form -->
            <button type="submit">Verstuur</button>
            <p>
                <!-- Display an error message if an error has been returned -->
                <?php if ($contactFieldsValid !== true && $contactFieldsValid !== false): ?>
                    <div class="error-message">
                        <p><?php echo $contactFieldsValid; ?></p>
                    </div>
                <!-- Display a success message if all the checks passed -->
                <?php elseif (isset($_SESSION['sendSuccessfully']) && $_SESSION['sendSuccessfully']): ?>
                    <div class="success-message">
                        <p>Je bericht is met succes verzonden!</p>
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

    <!-- Load the footer in -->
    <?php include 'website-components/footer.php'; ?>

</body>

</html>