<?php

class Contact extends View
{

    public function show()
    {

        require_once 'scripts/php/contactinfo.php';
        require_once 'scripts/php/mail.php';

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

                $message = "
                <table>
                    <tr><td><strong>" . __('contact_firstname') . ":</strong></td><td>" . htmlspecialchars($contactInfo->getFirstName()) . "</td></tr>
                    <tr><td><strong>" . __('contact_lastname') . ":</strong></td><td>" . htmlspecialchars($contactInfo->getLastName()) . "</td></tr>
                    <tr><td><strong>Email:</strong></td><td><a href='mailto:" . htmlspecialchars($contactInfo->getEmail()) . "'>" . htmlspecialchars($contactInfo->getEmail()) . "</a></td></tr>
                    <tr><td><strong>" . __('contact_phonenumber') . ":</strong></td><td><a href='tel:" . htmlspecialchars($contactInfo->getPhonenumber()) . "'>" . htmlspecialchars($contactInfo->getPhonenumber()) . "</a></td></tr>
                </table>
                <h1>" . __('contact_message') . "</h1>
                <p>" . nl2br(htmlspecialchars($contactInfo->getMessage())) . "</p>
                ";
                
                $mail = new Mail($contactInfo->getFirstName() . ' ' . $contactInfo->getLastName(),
                    $contactInfo->getSubject(),
                    $message);
                if ($mail->SendMail()) {
                    $_SESSION['sendSuccessfully'] = true;
                } else {
                    $_SESSION['sendSuccessfully'] = false;
                }

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
                <input id="firstname" class="<?= $contactInfo->getTextboxClass('firstname'); ?>" type="text"
                    placeholder="<?= __('contact_firstname'); ?>" name="firstname"
                    value="<?= $contactInfo->getFirstName(); ?>" oninput="setErrorEmptyInputbox('firstname')">

                <!-- Last name textbox -->
                <input id="lastname" class="<?= $contactInfo->getTextboxClass('lastname'); ?>" type="text"
                    placeholder="<?= __('contact_lastname'); ?>" name="lastname"
                    value="<?= $contactInfo->getLastName(); ?>" oninput="setErrorEmptyInputbox('lastname')">

                <!-- Email textbox -->
                <input id="email" class="<?= $contactInfo->getTextboxClass('email'); ?>" type="email"
                    placeholder="E-mail" name="email" value="<?= $contactInfo->getEmail(); ?>"
                    oninput="setErrorEmptyInputbox('email')">

                <!-- Phonenumber textbox -->
                <input id="phonenumber" class="<?= $contactInfo->getTextboxClass('phonenumber'); ?>" type="text"
                    placeholder="<?= __('contact_phonenumber'); ?>" name="phonenumber"
                    value="<?= $contactInfo->getPhonenumber(); ?>" oninput="setErrorEmptyInputbox('phonenumber')">

                <!-- Subject textbox -->
                <input id="subject" class="<?= $contactInfo->getTextboxClass('subject'); ?>" type="text"
                    placeholder="<?= __('contact_subject'); ?>" name="subject"
                    value="<?= $contactInfo->getSubject(); ?>" oninput="setErrorEmptyInputbox('subject')">

                <!-- Message textbox -->
                <textarea id="message" class="<?= $contactInfo->getTextboxClass('message'); ?>"
                    placeholder="<?= __('contact_message'); ?>" name="message"
                    oninput="setErrorEmptyInputbox('message')"><?= $contactInfo->getMessage(); ?></textarea>

                <!-- Send the form -->
                <button type="submit"><?= __('contact_send'); ?></button>
                <p>
                    <!-- Display an error message if an error has been returned -->
                    <?php if (isset($errorMessage)): ?>
                        <p class="error-message"><?= $errorMessage; ?></p>
                    <!-- Display a success message if all the checks passed -->
                    <?php elseif (isset($_SESSION['sendSuccessfully']) && $_SESSION['sendSuccessfully']): ?>
                    <div class="success-message">
                        <p><?= __('contactvalidations_success'); ?></p>
                    </div>
                    <?php unset($_SESSION['sendSuccessfully']); ?>
                <?php endif; ?>
                </p>
            </form>

            <div class="info-text">

                <h2><?= __('contact_invitingmessage'); ?></h2>
                <p><?= __('contact_possibilities'); ?></p>
                <h3><?= __('contact_credentialstitle'); ?></h3>
                <p>Plug & Play
                <p>
                <p>Hogeschoollaan 1</p>
                <p>4818 CR Breda</p>

                <P><?= __('contact_phonenumber'); ?>: <a href="tel:0031850073030">088 525 7500</a></p>
                <p>E-mail: <a href="mailto:info@plugplay.pro">info@plugplay.pro</a></p>

            </div>

            <div class="info-map">
                <h3><?= __('contact_map'); ?></h3>

                <iframe width="30%" height="60%"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=4.795634150505067%2C51.5823632693168%2C4.799271225929261%2C51.58643982276231&amp;layer=mapnik&amp;marker=51.58440159175703%2C4.797452688217163"
                    style="border: 1px solid black">
                </iframe>
            </div>

        </section>
        <?php

    }

}

new Contact();