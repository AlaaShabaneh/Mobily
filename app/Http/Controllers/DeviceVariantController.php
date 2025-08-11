<?php

namespace App\Http\Controllers;

use App\Models\DeviceVariant;
use Illuminate\Http\Request;

class DeviceVariantController extends Controller
{
    // عرض جميع المتغيرات
    public function index()
    {
        $variants = DeviceVariant::with('specifications')->get();
        return response()->json($variants);
    }

    // إنشاء متغير جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'model_id' => 'required|integer',
            'type_id' => 'required|integer',
        ]);

        $variant = DeviceVariant::create($validated);

        return response()->json($variant, 201);
    }

    // عرض متغير معين
    public function show($id)
    {
        $variant = DeviceVariant::with('specifications')->findOrFail($id);
        return response()->json($variant);
    }

    // تحديث متغير
    public function update(Request $request, $id)
    {
        $variant = DeviceVariant::findOrFail($id);

        $validated = $request->validate([
            'model_id' => 'sometimes|integer',
            'type_id' => 'sometimes|integer',
        ]);

        $variant->update($validated);

        return response()->json($variant);
    }

    // حذف متغير
    public function destroy($id)
    {
        $variant = DeviceVariant::findOrFail($id);
        $variant->delete();

        return response()->json(null, 204);
    }
}
