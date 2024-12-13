<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingAdminController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        return view('admin.settings.index', compact('setting'));
    }

    public function update(Setting $setting, Request $request)
    {
        $setting->update($request->all());

        return redirect(route('setting_admin'))
            ->with(['success' => 'Настройки успешно обновлены']);
    }
}
