<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Picture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PictureController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'mimes:png,jpg,jpeg,webp|max:10240',
        ]);

        if ($request->file('file')) {
            $file = $request->file('file');
            return response()->json(['location' => Storage::url($file)]);
        }

        return null;
    }

    public function destroy(Picture $picture): JsonResponse
    {
        if ($picture->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
