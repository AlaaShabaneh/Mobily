<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    // عرض كل الأسعار
    public function index()
    {
        $prices = Price::with('device')->get();
        return response()->json($prices);
    }

    // عرض سعر معين
    public function show($id)
    {
        $price = Price::with('device')->findOrFail($id);
        return response()->json($price);
    }

    // إنشاء سعر جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'price' => 'required|numeric',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
        ]);

        $price = Price::create($validated);
        return response()->json($price, 201);
    }

    // تحديث سعر موجود
    public function update(Request $request, $id)
    {
        $price = Price::findOrFail($id);

        $validated = $request->validate([
            'device_id' => 'sometimes|exists:devices,id',
            'price' => 'sometimes|numeric',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
        ]);

        $price->update($validated);
        return response()->json($price);
    }

    // حذف سعر
    public function destroy($id)
    {
        $price = Price::findOrFail($id);
        $price->delete();

        return response()->json(null, 204);
    }
}
