<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAdminRequest;
use App\Http\Requests\UserAuthRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserAdminController extends Controller
{
    public function index(): View
    {
        $users = User::where('role_id', Role::USER)->orderBy('id')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function auth(UserAuthRequest $userAuthRequest): RedirectResponse
    {
        if (auth()->guard('admin')->attempt($userAuthRequest->validated())) {
            return redirect(route('admin_index'));
        }

        return back()->withInput()->withErrors(['error' => 'Неверный email или пароль']);
    }

    public function store(UserAdminRequest $userAdminRequest): RedirectResponse
    {
        User::create($userAdminRequest->validated());

        return redirect(route('users_admin'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.users-edit', compact('user'));
    }

    public function update(User $user, UserAdminRequest $userAdminRequest): RedirectResponse
    {
        try {
            $user->update($userAdminRequest->validated());

            if($userAdminRequest->ends_at) {
                $user->activeSubscription?->update([
                    'ends_at' => $userAdminRequest->ends_at,
                ]);
            }

            return redirect(route('users_admin'))
                ->with('success', 'Пользователь успешно обновлен');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ошибка при обновлении: ' . $e->getMessage()]);
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        try {
            if ($user->id == 1) {
                return redirect(route('users_admin'));
            }

            $user->delete();

            return redirect(route('users_admin'))
                ->with('success', 'Пользователь успешно удален');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ошибка при удалении: ' . $e->getMessage()]);
        }
    }

    public function logout(): RedirectResponse
    {
        auth()->guard('admin')->logout();

        return redirect(route('login'));
    }
}