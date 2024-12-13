<?php

namespace App\Services;

class MessageReplaceBrService
{
    public static function replacing(string $message): string
    {
        return $message ? str_replace(['<br />', '<br>'], "\n", $message) : '';
    }
}