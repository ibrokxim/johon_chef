<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_payment_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Связь с пользователем
            $table->string('card_token'); // Токен карты
            $table->string('card_last4'); // Последние 4 цифры карты для отображения пользователю
            $table->string('pin_code')->nullable(); // Хэшированный PIN-код
            $table->integer('pin_attempts')->default(0); // Счетчик неудачных попыток ввода PIN
            $table->timestamps();
            $table->softDeletes(); // Для мягкого удаления токенов
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_payment_tokens');
    }
};
