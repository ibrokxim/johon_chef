<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Request $request, $plan_id = null, $user_id = null)
    {
        $order = null;
        $plan = Plan::findOrFail($plan_id);
        $user = User::findOrFail($user_id);

        if ($plan && $user) {
            // Проверяем, существует ли уже заказ для данного пользователя и плана
            $order = Order::where('plan_id', $plan_id)
                ->where('user_id', $user_id)
                ->where('status', 1)
                ->first();

            if (!$order) {
                // Если заказа нет, создаем новый
                $order = new Order();
                $order->plan_id = $plan_id;
                $order->user_id = $user_id;
                $order->price = $plan->price;
                $order->save();
            }
        }

        return view('web.orders.create', compact('order', 'user'));
    }
}
