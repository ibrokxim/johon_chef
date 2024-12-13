<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\User;
use App\Services\TelegramSendingService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BannedUserChat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:banned';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Получаем все подписки, срок действия которых истекает
        $subscriptions = Subscription::where('ends_at', '<=', Carbon::now()->addDays(3))
            ->where('is_active', true)
            ->get();

        foreach ($subscriptions as $subscription) {
            $user = $subscription->user;
            // Приводим обе даты к началу дня
            $daysLeft = Carbon::now()->startOfDay()->diffInDays(Carbon::parse($subscription->ends_at)->startOfDay(), false);

            if ($daysLeft == 3) {
                $this->sendReminder($user, $daysLeft);
            } elseif ($daysLeft == 2) {
                $this->sendReminder($user, $daysLeft);
            } elseif ($daysLeft == 1) {
                $this->sendReminder($user, $daysLeft);
            } elseif ($daysLeft == 0) {
                $this->sendBlockMessage($user);

                // Деактивируем подписку
                $subscription->update([
                    'is_active' => false,
                ]);

                // Обновляем поле banned у пользователя на true
                $user->update([
                    'banned' => true,
                ]);

                $this->info("User ID {$user->id} has been blocked due to expired subscription.");
            }
        }

        $this->info('All subscriptions have been processed.');
    }

    // Метод для отправки уведомления
    private function sendReminder(User $user, int $daysLeft)
    {
        $message = "Sizning obunangiz $daysLeft kundan so'ng  tugaydi. Iltimos, obunangizni uzaytiring";

        (new TelegramSendingService())->sendMessage($user->chat_id, $message);

        $this->info("Notification sent to User ID {$user->name} about {$daysLeft} days left.");
    }

    // Метод для отправки сообщения о блокировке
    private function sendBlockMessage(User $user)
    {
        (new TelegramSendingService())->banChatMember($user->chat_id);
        $message = "Sizning obunangiz tugadi, va sizning hisobingniz bloklandi. Iltimos, hisobingizni blokdan ochish uchun, obunangizni yangilang";

        // Пример отправки через Telegram
         (new TelegramSendingService())->sendMessage($user->chat_id, $message);

        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/banned.log'),
        ])->info('Banned user: '. $user->chat_id);

        $this->info("Block notification sent to User ID {$user->name}.");
    }
}
