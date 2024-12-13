<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserPaymentToken extends Model
{
    protected $fillable = ['user_id', 'card_token', 'card_last4', 'pin_code', 'pin_attempts'];

    // Установка PIN
    public function setPinCode(string $pin): void
    {
        $this->pin_code = Hash::make($pin);
        $this->pin_attempts = 0; // Сбрасываем попытки после установки PIN
        $this->save();
    }

    // Проверка PIN перед оплатой
    public function checkPinCode(string $pin): bool
    {
        if (Hash::check($pin, $this->pin_code)) {
            // Сбрасываем счетчик попыток при успешной проверке
            $this->pin_attempts = 0;
            $this->save();
            return true;
        } else {
            // Увеличиваем счетчик неудачных попыток
            $this->increment('pin_attempts');

            // Если неудачных попыток 3, удаляем токен
            if ($this->pin_attempts >= 3) {
                $this->delete();
            }

            return false;
        }
    }
}