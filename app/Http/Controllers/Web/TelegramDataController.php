<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TelegramDataController extends Controller
{
    public function index()
    {
        return view('web.telegram');
    }

    public function telegramCheck(Request $request)
    {
        $bot_token = env('TELEGRAM_BOT_TOKEN');
        $data_check_string = $request?->telegram_data;
        $cat = $data_check_string;

        // Проверяем, что данные получены
        if (!$data_check_string) {
            return response()->json(['error' => 'No telegram data provided'], 400);
        }

        $data_check_arr = explode('&', rawurldecode($data_check_string));
        $needle = 'hash=';
        $check_hash = false;

        foreach ($data_check_arr as &$val) {
            if (str_starts_with($val, $needle)) {
                $check_hash = substr_replace($val, '', 0, strlen($needle));
                $val = null;
            }
        }

        $data_check_arr = array_filter($data_check_arr);
        sort($data_check_arr);

        $data_check_string = implode("\n", $data_check_arr);
        $secret_key = hash_hmac('sha256', $bot_token, "WebAppData", true);
        $hash = bin2hex(hash_hmac('sha256', $data_check_string, $secret_key, true));

        // Сравниваем хэш
        if (strcmp($hash, $check_hash) === 0) {
            // 1. Разбираем строку на массив параметров
            parse_str($cat, $params);

            // 2. Проверяем наличие параметра 'user' и декодируем JSON
            if (isset($params['user'])) {
                // 3. Декодируем строку user, которая находится в формате JSON
                $userData = json_decode($params['user'], true);

                if ($userData) {
                    $user = User::where('chat_id', $userData['id'])
                        ->first();

                    Auth::login($user);

                    return response()->json(['success' => true]);
                }
            }

        }

        return response()->json(['error' => 'Telegram data verification failed'], 403);
    }
}
