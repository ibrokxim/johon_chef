<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'chat_id' => 12345,
            'name' => 'Andrew',
            'email' => 'dkyshka25@gmail.com',
            'password' => 'password',
            'role_id' => 2,
        ]);

        User::create([
            'chat_id' => 33333,
            'name' => 'Jhon',
            'role_id' => 1,
        ]);
    }
}
