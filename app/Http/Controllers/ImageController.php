<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Device;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    // جلب كل الصور لجهاز معين
    public function index($deviceId)
    {
        $device = Device::findOrFail($deviceId);
        return response()->json($device->images);
    }

    // إضافة صورة لجهاز معين
    public function store(Request $request, $deviceId)
    {
        $request->validate([
            'url' => 'required|url',
            'is_main' => 'boolean',
        ]);

        $image = Image::create([
            'device_id' => $deviceId,
            'url' => $request->url,
            'is_main' => $request->is_main ?? 0,
        ]);

        return response()->json($image, 201);
    }

    // حذف صورة
    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $image->delete();

        return response()->json(null, 204);
    }
}
