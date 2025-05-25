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
        try {
            $contactFieldsValid = $contactInfo->validateContactInfoFields();
        
            if ($contactFieldsValid === true) {
                $_SESSION['sendSuccessfully'] = true;
                $contactInfo->setPostToNull();
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
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
                   placeholder="<?php echo __('contact_firstname'); ?>" name="firstname" value="<?php echo $contactInfo->getFirstName(); ?>"
                   oninput="setErrorEmptyInputbox('firstname')">

            <!-- Last name textbox -->
            <input id="lastname" class="<?php echo $contactInfo->getTextboxClass('lastname'); ?>" type="text"
                   placeholder="<?php echo __('contact_lastname'); ?>" name="lastname" value="<?php echo $contactInfo->getLastName(); ?>"
                   oninput="setErrorEmptyInputbox('lastname')">
            
            <!-- Email textbox -->
            <input id="email" class="<?php echo $contactInfo->getTextboxClass('email'); ?>" type="email"
                   placeholder="E-mail" name="email" value="<?php echo $contactInfo->getEmail(); ?>"
                   oninput="setErrorEmptyInputbox('email')">

            <!-- Phonenumber textbox -->
            <input id="phonenumber" class="<?php echo $contactInfo->getTextboxClass('phonenumber'); ?>" type="text"
                   placeholder="<?php echo __('contact_phonenumber'); ?>" name="phonenumber" value="<?php echo $contactInfo->getPhonenumber(); ?>"
                   oninput="setErrorEmptyInputbox('phonenumber')">

            <!-- Subject textbox -->
            <input id="subject" class="<?php echo $contactInfo->getTextboxClass('subject'); ?>" type="text"
                   placeholder="<?php echo __('contact_subject'); ?>" name="subject" value="<?php echo $contactInfo->getSubject(); ?>"
                   oninput="setErrorEmptyInputbox('subject')">

            <!-- Message textbox -->
            <textarea id="message" class="<?php echo $contactInfo->getTextboxClass('message'); ?>"placeholder="<?php echo __('contact_message'); ?>"
                      name="message" oninput="setErrorEmptyInputbox('message')"><?php echo $contactInfo->getMessage(); ?></textarea>

            <!-- Send the form -->
            <button type="submit"><?php echo __('contact_send'); ?></button>
            <p>
                <!-- Display an error message if an error has been returned -->
                <?php if (isset($errorMessage)): ?>
                    <div class="error-message">
                        <p><?php echo $errorMessage; ?></p>
                    </div>
                <!-- Display a success message if all the checks passed -->
                <?php elseif (isset($_SESSION['sendSuccessfully']) && $_SESSION['sendSuccessfully']): ?>
                    <div class="success-message">
                        <p><?php echo __('contactvalidations_success'); ?></p>
                    </div>
                    <?php unset($_SESSION['sendSuccessfully']); ?>
                <?php endif; ?>
            </p>
        </form>

        <div class="info-text">

            <h2><?php echo __('contact_invitingmessage'); ?></h2>
            <p><?php echo __('contact_possibilities'); ?></p>
            <h3><?php echo __('contact_credentialstitle'); ?></h3>
            <p>Plug & Play
            <p>
            <p>Hogeschoollaan 1</p>
            <p>4818 CR Breda</p>

            <P><?php echo __('contact_phonenumber'); ?>: <a href="tel:0031850073030">088 525 7500</a></p>
            <p>E-mail: <a href="mailto:info@plugplay.pro">info@plugplay.pro</a></p>

        </div>

        <div class="info-map">
            <h3><?php echo __('contact_map'); ?></h3>

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