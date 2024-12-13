<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\PictureController;
use App\Http\Controllers\Web\TelegramDataController;
use App\Http\Controllers\Admin\Users\UserAdminController;
use App\Http\Controllers\Admin\Plans\PlansAdminController;
use App\Http\Controllers\Admin\Setting\SettingAdminController;

Route::get('/', function () {
    return abort(404);
});

Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function() {
        Route::view('login', 'admin.login')->name('login');
        Route::post('auth', [UserAdminController::class, 'auth'])->name('admin_auth');
    });

    Route::middleware(['auth:admin'])->group(function() {
        Route::get('', [UserAdminController::class, 'index'])
            ->name('admin_index');

        Route::redirect('/', 'admin/users');

        // Users
        Route::get('users', [UserAdminController::class, 'index'])->name('users_admin');
        Route::get('users/add', [UserAdminController::class, 'create'])->name('users_create');
        Route::post('users/store', [UserAdminController::class, 'store'])->name('users_store');

        Route::get('users/edit/{user}', [UserAdminController::class, 'edit'])->name('users_edit');
        Route::post('users/update/{user}', [UserAdminController::class, 'update'])->name('users_update');
        Route::any('users/delete/{user}', [UserAdminController::class, 'destroy'])->name('users_delete');


        // Plans
        Route::get('plans', [PlansAdminController::class, 'index'])->name('plans_admin');
        Route::get('plans/add', [PlansAdminController::class, 'create'])->name('plans_create');
        Route::post('plans/store', [PlansAdminController::class, 'store'])->name('plans_store');

        Route::get('plans/edit/{plan}', [PlansAdminController::class, 'edit'])->name('plans_edit');
        Route::post('plans/update/{plan}', [PlansAdminController::class, 'update'])->name('plans_update');
        Route::any('plans/delete/{plan}', [PlansAdminController::class, 'destroy'])->name('plans_delete');

        // Settings
        Route::get('settings', [SettingAdminController::class, 'index'])->name('setting_admin');
        Route::post('settings/update/{setting?}', [SettingAdminController::class, 'update'])->name('setting_update');

        // Logout
        Route::get('logout', [UserAdminController::class, 'logout'])->name('admin_logout');

        // Pictures
        Route::post('pictures/store', [PictureController::class, 'store'])->name('pictures_store');
        Route::post('pictures/delete/{picture}', [PictureController::class, 'destroy'])->name('pictures_delete');
    });
});


// Профиль
Route::get('/', function (\Illuminate\Http\Request $request) {
    return view('web.profile');
})->name('cabinet');

// Рефералы
Route::get('referrals', function (\Illuminate\Http\Request $request) {
    return view('web.referrals');
})->name('referrals');

Route::post('card/bind', [CardController::class, 'bindCard'])->name('card.bind');
Route::post('referrals/link', function(\Illuminate\Http\Request $request) {

    $link = auth()->user()->getTelegramReferralLink();
    return response()
        ->json(['referral_link' => $link]);

})->name('referrals_link');

// Проверяем Bot App
Route::get('telegram', [TelegramDataController::class, 'index'])->name('telegram_index');
Route::post('check', [TelegramDataController::class, 'telegramCheck'])->name('telegram_check');

Route::get('checkout/{id?}/{user_id?}', [OrderController::class, 'show'])->name('checkout.show');
