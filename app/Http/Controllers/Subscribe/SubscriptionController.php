<?php

namespace App\Http\Controllers\Subscribe;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Services\Subscribe\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    // Показать доступные тарифы
    public function showPlans()
    {
        $plans = Plan::all();
        return view('subscriptions.plans', compact('plans'));
    }

    // Оформить подписку
    public function subscribe(Request $request, $planId)
    {
        $plan = Plan::findOrFail($planId);
        $this->subscriptionService->createSubscription(auth()->user(), $plan);

        return redirect()->route('home')->with('success', 'Подписка успешно оформлена!');
    }
}
