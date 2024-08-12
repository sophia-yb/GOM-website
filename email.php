<?php
$messageSent = false;
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    if (!empty($name) && !empty($email) && !empty($message)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'sophiaybuda@gmail.com';
                $mail->Password = 'miauaomjwiqcijfe'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom($email, $name);
                $mail->addAddress('sophiaybuda@gmail.com');

                $mail->isHTML(false);
                $mail->Subject = "New Contact Form Submission from $name";
                $mail->Body = "Name: $name\nEmail: $email\n\nMessage:\n$message\n";

                $mail->send();
                $messageSent = true;
            } catch (Exception $e) {
                echo "Sorry, something went wrong. Please try again.";
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
        } else {
            echo "Invalid email address. Please enter a valid email.";
        }
    } else {
        echo "All fields are required. Please fill in all fields.";
    }
} else {
    echo "Invalid request method.";
}
?>
<?php if ($messageSent): ?>
    <div class="thank-you-message show">
        Thank you, your message has been sent!
    </div>
<?php endif; ?>
