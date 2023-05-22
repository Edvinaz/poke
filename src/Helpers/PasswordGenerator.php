<?php

namespace App\Helpers;

class PasswordGenerator
{
    public static function generatePassword($length = 8) {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()';

        $password = '';

        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];

        $allChars = $uppercase . $lowercase . $numbers . $specialChars;

        $remainingLength = $length - 3;

        for ($i = 0; $i < $remainingLength; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        $password = str_shuffle($password);

        return $password;
    }
}