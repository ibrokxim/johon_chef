<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plan = Plan::create(
            [
                'name' => '1 oylik',
                'description' => 'Подписка на 1 месяц.',
                'price' => 1000,
                'duration' => 1, // 1 месяц
            ],
        );

//        $plan->orders()->create([
//            'price' => $plan->price,
//            'user_id' => 2,
//        ]);

        $plan = Plan::create(
            [
                'name' => '3 oylik',
                'description' => 'Подписка на 3 месяца.',
                'price' => 200000,
                'duration' => 3, // 3 месяца
            ],
        );

//        $plan->orders()->create([
//            'price' => $plan->price,
//            'user_id' => 2,
//        ]);

        Plan::create(
            [
                'name' => '6 oylik',
                'description' => 'Подписка на 6 месяцев.',
                'price' => 400000,
                'duration' => 6, // 6 месяцев
            ],
        );

        Plan::create(
            [
                'name' => '12 oylik',
                'description' => 'Подписка на 12 месяцев.',
                'price' => 750000,
                'duration' => 12, // 12 месяцев
            ],
        );
    }
}
