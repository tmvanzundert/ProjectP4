<?php

class ContactInfo
{

    private string $firstname;
    private string $lastname;
    private string $email;
    private string $phonenumber;
    private string $subject;
    private string $message;

    public function __construct(string $firstname, string $lastname, string $email, string $phonenumber, string $subject, string $message)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->phonenumber = $phonenumber;
        $this->subject = $subject;
        $this->message = $message;
    }

    // Returns an array with the object values
    public function setObjectValues(): array
    {
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
    public function getFirstName(): string
    {
        return htmlspecialchars($this->firstname);
    }

    // Get the last name from the object
    public function getLastName(): string
    {
        return htmlspecialchars($this->lastname);
    }

    // Get the email from the object
    public function getEmail(): string
    {
        return htmlspecialchars($this->email);
    }

    // Get the phone number from the object
    public function getPhonenumber(): string
    {
        return htmlspecialchars($this->phonenumber);
    }

    // Get the subject from the object
    public function getSubject(): string
    {
        return htmlspecialchars($this->subject);
    }

    // Get the message from the object
    public function getMessage(): string
    {
        return htmlspecialchars($this->message);
    }

    // Sets the POST array to null to prevent resubmission on page refresh
    public function setPostToNull()
    {
        if ($this->isSubmitted()) {
            if (!headers_sent()) {
                header("Location: ?view=contact");
                exit;
            } else {
                echo "<script>window.location.href='?view=contact';</script>";
                exit;
            }
        }
    }

    // Checks if the form is submitted
    public function isSubmitted(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Checks if any of the required fields are empty
    public function isVariableEmpty(): bool
    {

        $requiredFields = [$this->getFirstName(), $this->getLastName(), $this->getEmail(), $this->getPhonenumber(), $this->getSubject(), $this->getMessage()];
        foreach ($requiredFields as $field) {
            if (empty($field)) {
                return false;
            }
        }

        return true;

    }

    // Returns the class for the textbox based on whether the field is empty or not
    public function getTextboxClass(string $fieldName): string
    {

        // Check if the form is submitted and the field is empty
        if ($this->isSubmitted() && empty($this->setObjectValues()[$fieldName])) {
            return "textbox textbox-error";
        }

        // Return the default class
        return "textbox";

    }

    // Validates the contact info fields
    function validateContactInfoFields(): bool
    {

        // Prevent the function running at first load
        if ($this->isSubmitted() === false) {
            return false;
        }

        // Test if all fields are not empty
        if ($this->isVariableEmpty() === false) {
            throw new LengthException(__('contactvalidations_empty'));
        }

        // Validate if the email is valid
        if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(__('contactvalidations_invalidemail'));
        }

        // Checks and the error messages if the check did not pass
        $validations = [
            'firstname' => [
                'pattern' => "/^[a-zA-Z0-9\s]+$/",
                'message' => __('contactvalidations_invalidfirstname')
            ],
            'lastname' => [
                'pattern' => "/^[a-zA-Z0-9\s]+$/",
                'message' => __('contactvalidations_invalidlastname')
            ],
            'phonenumber' => [
                'pattern' => "/^[\d\s\-\+]{6,18}$/",
                'message' => __('contactvalidations_invalidphonenumber')
            ],
            'subject' => [
                'minLength' => 3,
                'message' => __('contactvalidations_invalidsubject')
            ],
            'message' => [
                'minLength' => 20,
                'message' => __('contactvalidations_invalidmessage')
            ]
        ];

        // Iterate through the validations and return the error message if the check did not pass
        
        foreach ($validations as $input => $check) {
            $value = $this->setObjectValues()[$input];
            if (!empty($check['minLength']) && strlen($value) < $check['minLength']) {
                throw new InvalidArgumentException($check['message']);
            }
            if (!empty($check['pattern']) && !preg_match($check['pattern'], $value)) {
                throw new InvalidArgumentException($check['message']);
            }
        }

        // Return true if all checks passed
        return true;

    }
}

?>