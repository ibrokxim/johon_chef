<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TelegramSendingService
{
    protected string $token;
    protected string $key_location;

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN');
    }

    public function sendMessage(int $chat_id, string $message): void
    {
        $data = [
            "chat_id" => $chat_id,
            "text" => $message,
            "parse_mode" => "html"
        ];

        $this->sendRequest('/sendMessage', $data);
    }

    public function replyMessage(int $chat_id, int $message_id, string $message): void
    {
        $data = [
            "chat_id" => $chat_id,
            "text" => $message,
            "parse_mode" => "html",
            "reply_to_message_id" => $message_id
        ];

        $this->sendRequest('/sendMessage', $data);
    }
//
    public function removeMessage($chat_id, int $messageId)
    {
        $data = [
            "chat_id" => $chat_id,
            "message_id" => $messageId
        ];

        $this->sendRequest('/deleteMessage', $data);
    }

    public function sendInlineKeyboard(int $chat_id, string $message, array $keyboard)
    {
        $data = [
            "chat_id" => $chat_id,
            "text" => $message,
            "parse_mode" => "html",
            'protect_content' => true,
            'reply_markup' => json_encode([
                'inline_keyboard' => $keyboard,
            ]),
        ];

        $this->sendRequest('/sendMessage', $data);
    }

    public function sendKeyboard(int $chat_id, string $message, array $keyboard)
    {
        $data = [
            "chat_id" => $chat_id,
            "text" => $message,
            "parse_mode" => "html",

            'reply_markup' => json_encode([
                'keyboard' => $keyboard,
                'one_time_keyboard' => false, // отключить скрытие меню
                'resize_keyboard' => true, // отключить адаптацию кнопок по высоте
            ]),
        ];

        $this->sendRequest('/sendMessage', $data);
    }

    public function sendVideo(int $chat_id, string $video_path, string $caption = '', array $keyboard = [])
    {
        $data = [
            'chat_id' => $chat_id,
            'supports_streaming' => true,
            'video' => 'BAACAgIAAxkBAAIDfmbzy9LH9nRylSdTc8RktuqSwGxBAALYYAACB36YSxB-geKsJigfNgQ', // путь к видеофайлу или URL
            'caption' => $caption,
            'parse_mode' => 'html', // если требуется форматирование
            'reply_markup' => json_encode([
                'inline_keyboard' => $keyboard,
            ])
        ];

        $this->sendRequest('/sendVideo', $data);
    }

    public function sendPhone(int $chat_id, string $message, array $keyboard)
    {
        $data = [
            "chat_id" => $chat_id,
            "text" => $message,
            "parse_mode" => "html",

            'reply_markup' => json_encode([
                'keyboard' => $keyboard,
                'one_time_keyboard' => false,
                'resize_keyboard' => true,
            ]),
        ];

        $this->sendRequest('/sendMessage', $data);
    }

    public function approveJoinRequest($user_id)
    {
        $privateChat = env('TELEGRAM_BOT_CHANNEL_PROD');

        $data = [
            'chat_id' => $privateChat,
            'user_id' => $user_id,
        ];

        $this->sendRequest('/approveChatJoinRequest', $data);
    }

    // Метод для отклонения запроса на вступление
    public function declineJoinRequest($chat_id, $user_id)
    {
        $privateChat = env('TELEGRAM_BOT_CHANNEL_PROD');

        $data = [
            'chat_id' => $privateChat,
            'user_id' => $user_id,
        ];
        $this->sendRequest('/declineChatJoinRequest', $data);
    }

    public function banChatMember($user_id, $chat_id = null, $until_date = null, $revoke_messages = false)
    {
        // Используйте указанный chat_id или возьмите из конфигурации
        $privateChat = $chat_id ?? env('TELEGRAM_BOT_CHANNEL_PROD');

        // Подготовка данных для запроса
        $data = [
            'chat_id' => $privateChat,
            'user_id' => $user_id,
            'revoke_messages' => $revoke_messages
        ];

        // Если указана дата для разблокировки
        if ($until_date) {
            $data['until_date'] = $until_date;
        }

        // Отправка запроса на бан пользователя
        $this->sendRequest('/banChatMember', $data);
    }

    public function unbanChatMember($user_id, $chat_id = null, $only_if_banned = false)
    {
        // Используйте указанный chat_id или возьмите из конфигурации
        $privateChat = $chat_id ?? env('TELEGRAM_BOT_CHANNEL_PROD');

        // Подготовка данных для запроса
        $data = [
            'chat_id' => $privateChat,
            'user_id' => $user_id,
            'only_if_banned' => $only_if_banned
        ];

        // Отправка запроса на разбан пользователя
        $this->sendRequest('/unbanChatMember', $data);

        // Создаем ссылку-приглашение
        $inviteLink = $this->createChatInviteLink($privateChat);

        // Отправляем ссылку пользователю
        if ($inviteLink) {
            $this->sendInviteToUser($user_id, $inviteLink);
        }
    }

    public function sendInviteToUser($user_id, $invite_link)
    {
        $message = "Sizning obunangiz yangilandi va shu havola orqali kanalga qo’shilishingiz mumkun: $invite_link";

        // Отправляем сообщение пользователю с приглашением
        $this->sendRequest('/sendMessage', [
            'chat_id' => $user_id,
            'text' => $message,
        ]);
    }

    public function createChatInviteLink($chat_id = null)
    {
        // Используйте указанный chat_id или возьмите из конфигурации
        $privateChat = $chat_id ?? env('TELEGRAM_BOT_CHANNEL_PROD');

        // Подготовка данных для запроса
        $data = [
            'chat_id' => $privateChat,
            'member_limit' => 1
        ];

        // Отправка запроса на создание ссылки-приглашения
        $response = $this->sendRequest('/createChatInviteLink', $data);

        // Возвращаем ссылку-приглашение
        return $response['result']['invite_link'] ?? null;
    }

    public function answerCallback($chat_id, int $callback_id, string $msg)
    {
        $data = [
            "chat_id" => $chat_id,
            "callback_query_id" => $callback_id,
            "text" => $msg
        ];

        $this->sendRequest('/answerCallbackQuery', $data);
    }

    public function sendRequest(string $url, array $data): array
    {
        try {
            $response = Http::post('https://api.telegram.org/bot'.$this->token.$url, $data)->throw();

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Непредвиденная ошибка: ' . $e->getMessage());
            return [];
        }
    }


}
