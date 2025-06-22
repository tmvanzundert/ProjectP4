<?php

require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mail
{
    public string $Name;
    public string $Subject;
    public string $Body;
    private PHPMailer $mail;
    private array $env;

    public function __construct(string $name, string $subject, string $body) {
        $this->Name = $name;
        $this->Subject = $subject;
        $this->Body = $body;

        $envPath = dirname(__DIR__, 2) . '/.env';
        $env = parse_ini_file($envPath);
        if ($env === false) {
            die('Failed to load .env file at ' . $envPath);
        }
        $this->env = $env;

        $this->mail = $this->Connect();

    }

    public function Connect(): object {

        try {
            
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();       
            $mail->SMTPAuth   = true;                  
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->env['mail_username'];
            $mail->Password   = $this->env['mail_password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';
            $mail->isHTML(true);
            return $mail;

        }
        catch (Exception $e) {
            die('Failed to connect to mail server: ' . $e->getMessage());
        }

    }

    public function SendMail(): bool {
        try {
            $this->mail->setFrom($this->env['mail_username'], $this->Name);
            $this->mail->addAddress($this->env['mail_username'], 'Contact Website');
            $this->mail->Subject = $this->Subject;
            $this->mail->Body    = $this->Body;
            $this->mail->send();
            
            return true;
        }
        catch (Exception $e) {
            error_log('Mail could not be sent. Error: ' . $e->getMessage());
            return false;
        }
    }
    
}