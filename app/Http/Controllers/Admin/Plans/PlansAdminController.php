<?php

namespace App\Http\Controllers\Admin\Plans;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanAdminRequest;
use App\Models\Plan;
use Illuminate\Http\RedirectResponse;

class PlansAdminController extends Controller
{
    public function index()
    {
        $plans = Plan::orderBy('id')->paginate(15);

        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.plan-create');
    }

    public function store(PlanAdminRequest $planAdminRequest): \Illuminate\Http\RedirectResponse
    {
        try {
            Plan::create($planAdminRequest->validated());

            return redirect(route('plans_admin'))
                ->with('success', 'Тариф успешно создан');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ошибка при добавлении: ' . $e->getMessage()]);
        }
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.plan-edit', compact('plan'));
    }

    public function update(Plan $plan, PlanAdminRequest $planAdminRequest): \Illuminate\Http\RedirectResponse
    {
        try {
            $plan->update($planAdminRequest->validated());

            return redirect(route('plans_admin'))
                ->with('success', 'Тариф успешно обновлен');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ошибка при обновлении: ' . $e->getMessage()]);
        }
    }

    public function destroy(Plan $plan): RedirectResponse
    {
        try {
            $plan->delete();

            return redirect(route('plans_admin'))
                ->with('success', 'Тариф успешно удален');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ошибка при удалении: ' . $e->getMessage()]);
        }
    }
}
