<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(2); // Получаем первого пользователя

        // Создаем подписку на 1 месяц
        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => 1, // ID базового тарифа
            'starts_at' => now(),
            'ends_at' => now()->addMonth(), // Добавляем 1 месяц
            'is_active' => true,
        ]);
    }
}
