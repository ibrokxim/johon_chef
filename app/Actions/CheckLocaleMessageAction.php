<?php

namespace App\Actions;

use App\Models\User;

class CheckLocaleMessageAction
{
    public function getLocaleMessage(User $user, array $data): string
    {
        return match ($user->lang) {
            'ru' => $data['ru'],
            'uz' => $data['uz'],
        };
    }
}