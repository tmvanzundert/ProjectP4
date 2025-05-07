<?php

    function validateContactInfoFields() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return false;
        }

        $count = 0;
        $contactValues = [$_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['phonenumber'], $_POST['subject'], $_POST['message']];
        for ($i = 0; $i < count($contactValues); $i++) { 
            
            if (empty($contactValues[$i]) && isset($contactValues[$i])) {
                $count++;
            }

            if ($i == count($contactValues) -1 && $count > 0 && $count <= count($contactValues)) {
                return "Niet alle velden zijn ingevuld";
            }

        }

        if (!preg_match("/^[a-zA-Z0-9\s]+$/", $_POST['firstname'])) {
            return "Voer een geldige voornaam in";
        }

        if (!preg_match("/^[a-zA-Z0-9\s]+$/", $_POST['lastname'])) {
            return "Voer een geldige achternaam in";
        }

        if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
            return "Je e-mailadres is ongeldig";
        }

        if (!preg_match("/^[\d\s\-\+]{0,}$/", $_POST['phonenumber'])) {
            return "Je telefoonnummer is ongeldig";
        }

        if (strlen($_POST['phonenumber']) < 6) {
            return "Het ingevoerde telefoonnummer is te kort";
        }

        if (strlen($_POST['phonenumber']) > 18) {
            return "Het ingevoerde telefoonnummer is te lang";
        }

        if (strlen($_POST['subject']) < 5) {
            return "Beschrijf je onderwerp duidelijker";
        }

        if (strlen($_POST['message']) < 20) {
            return "Voeg meer informatie toe aan je bericht";
        }

        return true;

    }

?>