<?php

namespace App\Services;

use App\Models\User;
use App\Models\Setting;
use App\Services\Referrer\TelegramReferrerService;

class TelegramAuthService
{
    public User $user;
    public Setting $setting;

    public function create(int $chat_id, string $name, string $message)
    {
        $this->setting = Setting::first();

        $this->user = User::create([
            'chat_id' => $chat_id,
            'name' => $name,
            'in_auth' => true,
        ]);

        $parts = explode(' ', $message);

        $token = $parts[1] ?? null;

        if ($token) {
            TelegramReferrerService::checkReferrer($this->user, $token);
        }

        (new TelegramActionsService($this->user, $this->setting))->main();
    }
}
