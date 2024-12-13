<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\TelegramRouteAction;
use App\Http\Controllers\Controller;
use App\Services\TelegramSendingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TelegramController extends Controller
{
    public function webhook(Request $request, TelegramRouteAction $action)
    {
        $data = json_decode($request->getContent());
        $action->handle($data);
    }
}
