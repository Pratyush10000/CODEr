<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['_replyto'];
    $message = $_POST['message'];
    $to = 'your-email@example.com'; // Replace with your email address

    $subject = 'New Contact Form Submission';
    $headers = "From: $name <$email>";

    mail($to, $subject, $message, $headers);
}
?>
