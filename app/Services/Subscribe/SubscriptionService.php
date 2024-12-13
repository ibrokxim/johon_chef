<?php

namespace App\Services\Subscribe;

use App\Models\Plan;
use App\Models\Subscription;

class SubscriptionService
{
    public function createSubscription($user, Plan $plan)
    {
        // Деактивируем все старые подписки пользователя
        $user->subscriptions()->update(['is_active' => false]);

        // Создаем новую подписку
        return Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'starts_at' => now(),
            'ends_at' => now()->addMonths($plan->duration), // Продление на количество месяцев
            'is_active' => true,
        ]);
    }
}