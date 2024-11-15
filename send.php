<?php

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Required files
require 'phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/phpmailer/src/SMTP.php';

// Create an instance; passing true enables exceptions
if (isset($_POST["submit"])) {

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                              // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';         // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                     // Enable SMTP authentication
        $mail->Username   = 'christiandenvermendoza@gmail.com'; // Your email
        $mail->Password   = 'ojrbzcgnufzsgwyy';       // Your SMTP password
        $mail->SMTPSecure = 'ssl';                    // Enable SSL encryption
        $mail->Port       = 465;                      // TCP port to connect to

        // Sender information (user's email)
        $mail->setFrom($_POST["email"], $_POST["name"]);  // Set the user's email and name as the sender
        $mail->addAddress('kylacapanay0@gmail.com'); // Recipient email

        // Content
        $mail->isHTML(true);                          // Set email format to HTML
        $mail->Subject = $_POST["subject"];           // Email subject
        $mail->Body    = $_POST["message"];           // Email message

        // Send the email and check result
        if ($mail->send()) {
            echo "Message was sent successfully!";
        } else {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>