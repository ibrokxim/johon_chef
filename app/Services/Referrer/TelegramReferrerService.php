<?php

namespace App\Services\Referrer;

use App\Models\User;
use App\Services\TelegramSendingService;
use Illuminate\Support\Facades\Storage;

class TelegramReferrerService
{
    public static function checkReferrer(User $user, $token)
    {
        // Найдем пользователя по реферальному токену
        $referrer = User::where('referral_token', $token)->first();

        if ($referrer && $referrer->id !== $user->id) {

            // Проверка, установлен ли уже реферер
            if ($user->referrer_id) {
                (new TelegramSendingService())->sendMessage($user->chat_id,
                    "У вас уже установлен реферер.");
                return;
            }

            // Привязка реферера к пользователю
            $user->update([
                'referrer_id' => $referrer->id,
            ]);

//            // Отправка сообщения с подтверждением
//            (new TelegramSendingService())->sendMessage($user->chat_id,
//                "Вы зарегистрированы по реферальной ссылке от {$referrer->name}.");
        }

    }

    public static function rewardReferrer(User $referrer)
    {
        // Проверяем, если количество пользователей кратно 2
        if ($referrer->count_referrer === 2) {
            // Сбрасываем счетчик
            $referrer->update(['count_referrer' => 0]);

            // Получаем активную подписку
            $activeSubscription = $referrer->activeSubscription()->first();

            if ($activeSubscription) {
                $activeSubscription->ends_at = $activeSubscription->ends_at->addMonth(1);
                $activeSubscription->update();
            }
        }
    }
}