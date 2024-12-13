<?php

namespace App\Services;

use App\Actions\PhoneValidateAction;
use App\Models\Setting;
use App\Models\User;
use App\Services\Referrer\TelegramReferrerService;
use Illuminate\Support\Facades\Storage;

class TelegramMessageService
{
    public User $user;
    public Setting $setting;

    public function __construct(public int $chat_id)
    {
        $this->user = User::where('chat_id', $this->chat_id)->first();
        $this->setting = Setting::first();
    }

    public function message(string $message)
    {
        if ($this->user->in_auth && $this->user->status) {

            if (str_starts_with($message, '/start')) {
                (new TelegramActionsService($this->user, $this->setting))->main();
            }

//            if ($message == '🗞 Рефрелы') {
//                (new TelegramActionsService($this->user, $this->setting))->referral();
//            }
//
//            if ($message == '🔖 Подписка') {
//                (new TelegramActionsService($this->user, $this->setting))->subscribe();
//            }

//            // Назад
//            if ($message == '⬅ Orqaga' && ($this->user->step == 'referral' || $this->user->step == 'subscribe')) {
//                (new TelegramActionsService($this->user, $this->setting))->defaultMenu();
//            }

        } else {
            if (!$this->user->status) {
                (new TelegramSendingService())->sendMessage($this->user->chat_id,
                    'Вы заблокированы');
            }
        }
    }
}
