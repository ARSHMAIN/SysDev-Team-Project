<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if (isset($_POST['submit'])) {
    $name = htmlentities($_POST['name']);
    $email = htmlentities($_POST['email']);
    $subject = htmlentities($_POST['subject']);
    $inquiry = htmlentities($_POST['inquiry']);

    $mail = new PHPMailer(true); // Move this line outside the try block

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'example@gmail.com'; // Your Gmail address
        $mail->Password = 'example'; // Your Gmail password or App Password
        $mail->SMTPSecure = 'tls'; // Use 'tls' instead of 'ssl'
        $mail->Port = 587; // Use port 587 instead of 465
        $mail->isHTML();

        $mail->setFrom($email, $name);
        $mail->addAddress('example@gmail.com');
        $mail->Subject = "$email ($subject)";
        $mail->Body = $inquiry;

        $mail->send();
        header('Location: /?controller=contact&action=contact');
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: $mail->ErrorInfo";
    }
}
