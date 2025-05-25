<?php

    class ContactInfo {

        private string $firstname;
        private string $lastname;
        private string $email;
        private string $phonenumber;
        private string $subject;
        private string $message;

        public function __construct(string $firstname, string $lastname, string $email, string $phonenumber, string $subject, string $message) {
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->email = $email;
            $this->phonenumber = $phonenumber;
            $this->subject = $subject;
            $this->message = $message;
        }

        // Returns an array with the object values
        public function setObjectValues(): array {
            return [
                'firstname' => $this->getFirstName(),
                'lastname' => $this->getLastName(),
                'email' => $this->getEmail(),
                'phonenumber' => $this->getPhonenumber(),
                'subject' => $this->getSubject(),
                'message' => $this->getMessage()
            ];
        }

        // Get the first name from the object
        public function getFirstName(): string {
            return htmlspecialchars($this->firstname);
        }

        // Get the last name from the object
        public function getLastName(): string {
            return htmlspecialchars($this->lastname);
        }

        // Get the email from the object
        public function getEmail(): string {
            return htmlspecialchars($this->email);
        }

        // Get the phone number from the object
        public function getPhonenumber(): string {
            return htmlspecialchars($this->phonenumber);
        }

        // Get the subject from the object
        public function getSubject(): string {
            return htmlspecialchars($this->subject);
        }

        // Get the message from the object
        public function getMessage(): string {
            return htmlspecialchars($this->message);
        }

        // Sets the POST array to null to prevent resubmission on page refresh
        public function setPostToNull() {
            if ($this->isSubmitted()) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        }

        // Checks if the form is submitted
        public function isSubmitted(): bool {
            return $_SERVER['REQUEST_METHOD'] === 'POST';
        }

        // Checks if any of the required fields are empty
        public function isVariableEmpty(): bool {

            $requiredFields = [$this->getFirstName(), $this->getLastName(), $this->getEmail(), $this->getPhonenumber(), $this->getSubject(), $this->getMessage()];
            foreach ($requiredFields as $field) {
                if (empty($field)) {
                    return false;
                }
            }

            return true;

        }

        // Returns the class for the textbox based on whether the field is empty or not
        public function getTextboxClass(string $fieldName): string {

            // Check if the form is submitted and the field is empty
            if ($this->isSubmitted() && empty($this->setObjectValues()[$fieldName])) {
                return "textbox textbox-error";
            }

            // Return the default class
            return "textbox";
            
        }

        // Validates the contact info fields
        function validateContactInfoFields() {

            // Prevent the function running at first load
            if ($this->isSubmitted() === false) {
                return false;
            }

            // Test if all fields are not empty
            if ($this->isVariableEmpty() === false) {
                return "Niet alle velden zijn ingevuld";
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

            // Return true if all checks passed
            return true;

        }
    }

?>