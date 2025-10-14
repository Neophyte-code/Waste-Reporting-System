<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require_once __DIR__ . '/../../vendor/autoload.php';

class Emailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        //Gmail SMTP Configuration
        $smtpHost = 'smtp.gmail.com';
        $smtpUser = 'neophytedeveloper944@gmail.com';
        $smtpPass = 'hhjbdxphulvmviqc';
        $smtpPort = 587; // TLS port

        try {
            $this->mail->isSMTP();
            $this->mail->Host       = $smtpHost;
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = $smtpUser;
            $this->mail->Password   = $smtpPass;
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port       = $smtpPort;
            $this->mail->setFrom($smtpUser, 'Waste Reporting System');
        } catch (Exception $e) {
            error_log("Emailer Initialization Error: {$e->getMessage()}");
        }
    }


    /**
     * Send OTP email
     * @param string $recipient Recipient email address
     * @param string $otp The generated OTP
     * @return bool true if sent, false otherwise
     */
    public function sendVerificationOtp($recipient, $otp)
    {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($recipient);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Your Waste Reporting System Verification Code';
            $this->mail->Body = "
                <div style='font-family: Arial, sans-serif;'>
                    <h2 style='color:#2E8B57;'>Email Verification</h2>
                    <p>Hello,</p>
                    <p>Your One-Time Password (OTP) for verifying your account is:</p>
                    <h1 style='letter-spacing:4px; color:#006400;'>$otp</h1>
                    <p>This code will expire in <b>10 minutes</b>.</p>
                    <p>If you did not request this, please ignore this message.</p>
                    <br>
                    <p style='font-size:12px; color:#555;'>Waste Reporting System</p>
                </div>
            ";
            $this->mail->AltBody = "Your OTP code is: $otp";


            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Email send error: {$e->getMessage()}");
            return false;
        }
    }
}
