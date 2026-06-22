<?php
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$message = $_POST['message'];

$to = "bhaskarvyas001@gmail.com";
$subject = "New Appointment Enquiry";

$body = "
Name: $name
Phone: $phone
Email: $email

Message:
$message
";

mail($to, $subject, $body);

header("Location: thank-you.html");