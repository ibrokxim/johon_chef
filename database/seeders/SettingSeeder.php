<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'markup' => [
                'greetings' => "Assalomu alaykum 😊<br>Ushbu bot sizga Jahon Chefning yopiq kanaliga ulanishga yordam beradi.<br><br>Kanalga 1, 3, 6 va 12 oylik obuna tariflari bor.<br><br>Obunani xohlagan vaqtingiz bekor qilishingiz mumkin.<br><br>Sizni kanalda kutamiz 🙌🏻",
                'about' => "
                    Jahon Chef Community bu nima?"
                    .PHP_EOL.PHP_EOL.
                    "✅ Onlayn kurslar" .PHP_EOL.
                    "Hozirgi paytda kanalga 'Kruassan' va 'Nonushta' onlayn kurslari joylangan" .PHP_EOL.
                    "✅ Ekskluziv (boshqa joyda joylanmagan) video reseptlar" .PHP_EOL.
                    "Reseptni obunachilar o'zlari tanlashadi".PHP_EOL.
                    "✅ Ovqat tayyorlashga oyid foydali ma'lumotlar va bilimlar" .PHP_EOL.PHP_EOL.
                    "Undan tashqari".PHP_EOL.
                    "🤝 Foydali tanishuvlar va muloqot (networking)".PHP_EOL.
                    "🤩Sovg'alar, master klassda qatnashish uchun vaucherlar".PHP_EOL.PHP_EOL.
                    "Sizni Community da kutamiz 😇
                ",
                'payment' => "Qulay to'lov turini tanlang:<br><br>*keyingi – siz obunangizni Bot menyusida boshqarishingiz mumkin<br>*Siz obuna tugaguniga qadar bildirishnomalarni olasiz",
                'public_offer_title' => 'Taklif shartnomasi',
//                'public_offer' => 'https://simplit.io/pdfs/oferta_ru.pdf',
                'public_offer' => 'https://poddomen.aquabox-client.uz/assets/oferta_tayyor.pdf',
                'tariff_description' => "1 oylik obuna 75 000 so'm<br>3 oylik obuna <s>225 000 so'm</s> 200 000 so'm<br>6 oylik obuna <s>450 000 so'm</s> 400 000 so'm<br>12 oylik obuna <s>900 000 so'm</s> 750 000 so'm<br>",
                'manager' => 'https://t.me/jahonchef_admin',
                'youtube_link' => 'https://youtu.be/NrCDW4cMCMY?feature=shared',
                'video_link' => 'https://cdn.coverr.co/videos/coverr-premium-woman-traces-on-sand/720p.mp4',
            ]
        ]);
    }
}
