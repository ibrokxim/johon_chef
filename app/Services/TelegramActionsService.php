<?php

namespace App\Services;

use App\Actions\CheckLocaleMessageAction;
use App\Actions\UserUpdateStepAction;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class TelegramActionsService
{
    public function __construct(public User $user, public Setting $setting)
    {
    }

    public function main()
    {
        (new UserUpdateStepAction())->update($this->user, 'main');

        $message = MessageReplaceBrService::replacing($this->setting->markup?->greetings);

        if (!$this->user->confirm_offer) {

            $keyboard = [
                [
                    [
                        'text' => '📑 Ommaviy oferta',
                        'url' => $this->setting->markup?->public_offer,
                    ],
                ],
                [
                    [
                        'text' => 'Oferta shartlariga roziman',
                        'callback_data' => 'offer_success',
                    ]
                ]
            ];

        } else {

            $keyboard = [
                [
                    [
                        'text' => "Kanalga obuna bo'lish",
                        'url' => env('TELEGRAM_BOT_CHANNEL_INVITE_PROD')
                    ]
                ],
//                [
//                    [
//                        'text' => 'Shaxsiy hisob',
//                        'web_app' => [
//                            'url' => "https://jahoncommunitybot.uz/telegram"
//                        ]
//                    ]
//                ],
//                [
//                    [
//                        'text' => '💳 Tariflar',
//                        'callback_data' => 'action_tariff'
//                    ],
//                ],
                [
                    [
                        'text' => "🤵 Menejer bilan bog'lanish",
                        'url' => $this->setting->markup?->manager,
                    ]
                ],
                [
                    [
                        'text' => "🔎 Kanal haqida batafsil",
                        'callback_data' => 'action_about',
                    ]
                ]
            ];

        }

        (new TelegramSendingService())->sendInlineKeyboard($this->user->chat_id, $message, $keyboard);
    }

    public function phone()
    {
        (new UserUpdateStepAction())->update($this->user, 'phone');


        $text = (new CheckLocaleMessageAction())->getLocaleMessage($this->user, [
            'ru' => '📲 '. __('Отправьте контакт'),
            'uz' => '📲 '. __('Raqamingizni yuboring')
        ]);

        $message = (new CheckLocaleMessageAction())->getLocaleMessage($this->user, [
            'ru' => '📲 '. __('Отправьте или введите свой номер телефона 👇  в виде: +998 ** *** ****'),
            'uz' => '📲 '. __('Raqamni shu formatda 👇  yuboring: +998 ** *** ****')
        ]);

        $keyboard = [
            [
                [
                    'text' => $text,
                    'request_contact' => true,
                ],
            ],
        ];

        (new TelegramSendingService())->sendPhone($this->user->chat_id, $message, $keyboard);
    }
}
