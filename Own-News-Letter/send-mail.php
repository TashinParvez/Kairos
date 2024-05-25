<?php
$to_email = "tashinparvez2021@gmail.com";
$subject = "Kairos-Memories";
$message = "Hi, This is test email send by PHP Script";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Contest-type:text/html;charset=UTF-8" . "\r\n";

$headers .= "From: <tashinparvez2002@gmail.com>" ."\r\n";

if (mail($to_email, $subject, $message, $headers)) {
    echo "Email successfully sent to $to_email...";
} else {
    echo "Email sending failed...";
}
?>