<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\TelegramAuthService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Response|null
     */
    public function handle(Request $request, Closure $next): Response|null
    {
        try {
            $data = json_decode($request->getContent());
            $callback = $data?->callback_query ?? null;
            $chat_id = $callback ? $callback->from->id : ($data->message?->chat?->id ?? null);
            $name = $data->message?->chat?->first_name ?? null;
            $message = $data?->message?->text ?? null;
            $chat_id = $chat_id ? $chat_id : ($data?->chat_join_request?->from->id ?? null);

            if (!$chat_id) {
                Log::warning('Chat ID не найден в запросе');
                return null;
            }

            $user = User::where('chat_id', $chat_id)
                ->first();

            if (!$user && str_starts_with($message, '/start')) {
                (new TelegramAuthService())->create($chat_id, $name, $message);
                return null;
            }

            return $next($request);
        } catch (\Exception $e) {
            Log::error('Ошибка аутинтификации: ' . $e->getMessage());
            return null;
        }
    }
}
