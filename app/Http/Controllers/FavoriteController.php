<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // إضافة جهاز للمفضلة للمستخدم (مثلاً المستخدم الحالي)
    public function add(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:device_variants,id',
        ]);

        $user = $request->user(); // تأكد من استخدام auth middleware

        $user->favoriteDevices()->syncWithoutDetaching([$request->device_id]);

        return response()->json(['message' => 'Device added to favorites.']);
    }

    // إزالة جهاز من المفضلة
    public function remove(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:device_variants,id',
        ]);

        $user = $request->user();

        $user->favoriteDevices()->detach($request->device_id);

        return response()->json(['message' => 'Device removed from favorites.']);
    }

    // عرض كل الأجهزة المفضلة للمستخدم
    public function list(Request $request)
    {
        $user = $request->user();

        $favorites = $user->favoriteDevices()->get();

        return response()->json($favorites);
    }
}
