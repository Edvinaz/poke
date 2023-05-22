<?php

namespace App\Services;

class EmailService
{
    public static function sendEmail(string $recipient): void
    {
        $messageText = $_SESSION['user']['username'] . ' siunčia tau poke';

        $subject = $messageText;
        $message = $messageText;
        $headers = 'From: ' . $_SESSION['user']['username'] . "\r\n" .
            'Reply-To: ' . $_SESSION['user']['username'] . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($recipient, $subject, $message, $headers);
    }
}