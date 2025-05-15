<?php

    function validateContactInfoFields() {

        // Prevent the function running at first load
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return false;
        }

        // Test if all fields are not empty
        $requiredFields = ['firstname', 'lastname', 'email', 'phonenumber', 'subject', 'message'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                return "Niet alle velden zijn ingevuld";
            }
        }

        // Validate if the email is valid
        if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
            return "Je e-mailadres is ongeldig";
        }

        // Checks and the error messages if the check did not pass
        $validations = [
            'firstname' => [
                'pattern' => "/^[a-zA-Z0-9\s]+$/",
                'message' => "Voer een geldige voornaam in"
            ],
            'lastname' => [
                'pattern' => "/^[a-zA-Z0-9\s]+$/",
                'message' => "Voer een geldige achternaam in"
            ],
            'phonenumber' => [
                'pattern' => "/^[\d\s\-\+]{6,18}$/",
                'message' => "Je telefoonnummer is ongeldig"
            ],
            'subject' => [
                'minLength' => 3,
                'message' => "Voer een onderwerp van meer dan 3 karakters in",
            ],
            'message' => [
                'minLength' => 20,
                'message' => "Voeg meer informatie toe aan je bericht zodat je bericht meer dan 20 karakters lang is",
            ]
        ];

        // Iterate through the validations and return the error message if the check did not pass
        foreach ($validations as $inputName => $validationCheck) {
            if ( ( isset($validationCheck['minLength']) && strlen($_POST[$inputName]) < $validationCheck['minLength'] ) || ( isset($validationCheck['pattern']) && !preg_match($validationCheck['pattern'], $_POST[$inputName]) ) ) {
                return $validationCheck['message'];
            }
        }

        return true;

    }

?>