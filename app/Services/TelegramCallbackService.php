<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\User;

class TelegramCallbackService
{
    public User $user;
    public Setting $setting;

    public function __construct(public int $chat_id)
    {
        $this->user = User::where('chat_id', $this->chat_id)->first();
        $this->setting = Setting::first();
    }

    public function process(string $callback, string $callback_id, $message_id)
    {
        if ($callback === 'offer_success') {

            if (!$this->user->confirm_offer) {

                $keyboard = [
                    [
                        [
                            'text' => "Kanalga obuna bo'lish",
                            'url' => env('TELEGRAM_BOT_CHANNEL_INVITE_PROD')
                        ]
                    ],
                ];

                (new TelegramSendingService())
                    ->sendVideo($this->user->chat_id, '', '', $keyboard);
            }

            $this->user->update([
                'confirm_offer' => true
            ]);

            // Подтверждаем обработку callback
            (new TelegramSendingService())->answerCallback($this->user->chat_id, $callback_id, '✅');

            (new TelegramSendingService())->removeMessage($this->user->chat_id, $message_id);
        }


        if ($callback === 'action_tariff') {

            (new TelegramSendingService())->answerCallback($this->user->chat_id, $callback_id, '✅');

            (new TelegramSendingService())->removeMessage($this->user->chat_id, $message_id);

            $message = MessageReplaceBrService::replacing($this->setting->markup?->tariff_description);

            $plans = \App\Models\Plan::all();
            $keyboard = [];

            foreach ($plans as $plan) {
                $keyboard[] = [
                    [
                        'text' => $plan->name, // Выводим название тарифа
                        'callback_data' => 'tariff_' . $plan->id // Указываем callback_data с ID тарифа
                    ]
                ];
            }

            $keyboard[] = [
                [
                    'text' => '⬅ Orqaga', // Текст кнопки
                    'callback_data' => 'go_back' // callback_data для обработки кнопки "Назад"
                ]
            ];

            (new TelegramSendingService())
                ->sendInlineKeyboard($this->user->chat_id, $message, $keyboard);
        }

        if ($callback === 'action_about') {
            (new TelegramSendingService())->answerCallback($this->user->chat_id, $callback_id, '✅');

            (new TelegramSendingService())->removeMessage($this->user->chat_id, $message_id);

            $keyboard = [
                [
                    [
                        'text' => '💳 Tariflar',
                        'callback_data' => 'action_tariff'
                    ],
                ],
                [
                    [
                        'text' => "🤵 Menejer bilan bog'lanish",
                        'url' => $this->setting->markup?->manager,
                    ]
                ],
                [
                    [
                        'text' => '⬅ Orqaga', // Текст кнопки
                        'callback_data' => 'go_back' // callback_data для обработки кнопки "Назад"
                    ]
                ]
            ];

            $message = MessageReplaceBrService::replacing($this->setting->markup?->about);

            (new TelegramSendingService())
                ->sendInlineKeyboard($this->user->chat_id, $message, $keyboard);
        }


        // Callback tariff
        if (str_starts_with($callback, 'tariff_')) {

            (new TelegramSendingService())->answerCallback($this->user->chat_id, $callback_id, '✅');

            // Получаем ID тарифа из callback_data
            $tariff_id = (int)str_replace('tariff_', '', $callback);

            // Получаем тариф по ID
            $tariff = \App\Models\Plan::find($tariff_id);

            if ($tariff) {

                (new TelegramSendingService())->removeMessage($this->user->chat_id, $message_id);

                $message = MessageReplaceBrService::replacing($this->setting->markup?->payment);

                $keyboard = [
                    [
                        [
                            'text' => 'Karta orqali to`lov (Powered by Payme)',
                            'web_app' => [
                                'url' => "https://jahoncommunitybot.uz/checkout/$tariff->id/".$this->user->id
                            ]
                        ],
                    ],
                    [
                        [
                            'text' => "🤵 Menejer bilan bog'lanish",
                            'url' => $this->setting->markup?->manager,
                        ]
                    ],
                    [
                        [
                            'text' => '⬅ Orqaga',
                            'callback_data' => 'action_tariff'
                        ]
                    ]
                ];

                (new TelegramSendingService())
                    ->sendInlineKeyboard($this->user->chat_id, $message, $keyboard);

            } else {
                (new TelegramSendingService())->sendMessage($this->user->chat_id, 'Tarif qanday?');
            }

        }

        // Back
        if ($callback === 'go_back') {
            (new TelegramSendingService())->answerCallback($this->user->chat_id, $callback_id, '✅');

            (new TelegramSendingService())->removeMessage($this->user->chat_id, $message_id);

            (new TelegramActionsService($this->user, $this->setting))->main();
        }
    }
}