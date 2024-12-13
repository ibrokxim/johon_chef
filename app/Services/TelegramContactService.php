<?php

namespace App\Services;

class TelegramContactService
{
    public function __construct(public int $chat_id)
    {
    }

    public function process(string $phone)
    {

    }
}