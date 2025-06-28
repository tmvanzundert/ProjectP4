<?php

require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    public string $Name;
    public string $Subject;
    public string $Body;
    private PHPMailer $mail;
    private array $env;

    /**
     * Constructor - Initialize mail object and SMTP connection
     * @param string $name Sender name
     * @param string $subject Email subject
     * @param string $body Email body content
     */
    public function __construct(string $name, string $subject, string $body)
    {
        $this->Name = $name;
        $this->Subject = $subject;
        $this->Body = $body;

        // Load environment variables from .env file
        $envPath = dirname(__DIR__, 2) . '/.env';
        $env = parse_ini_file($envPath);
        if ($env === false) {
            echo 'Failed to load .env file at ' . $envPath;
            sleep(5);
            header('Location: index.php');
            exit;
        }
        $this->env = $env;

        // Initialize PHPMailer connection
        $this->mail = $this->Connect();
    }

    /**
     * Establishes SMTP connection using Gmail configuration
     * @return PHPMailer Configured PHPMailer object
     */
    public function Connect(): object
    {
        try {
            $mail = new PHPMailer(true);
            
            // Configure SMTP settings for Gmail
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $this->env['mail_username'];
            $mail->Password = $this->env['mail_password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            return $mail;

        } catch (Exception $e) {
            die('Failed to connect to mail server: ' . $e->getMessage());
        }
    }

    /**
     * Sends email using configured SMTP settings
     * @return bool True if email sent successfully, false otherwise
     */
    public function SendMail(): bool
    {
        try {
            $this->mail->setFrom($this->env['mail_username'], $this->Name);
            $this->mail->addAddress($this->env['mail_username'], 'Contact Website');
            $this->mail->Subject = $this->Subject;
            $this->mail->Body = $this->Body;
            $this->mail->send();

            return true;
        } catch (Exception $e) {
            error_log('Mail could not be sent. Error: ' . $e->getMessage());
            return false;
        }
    }
}