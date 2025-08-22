<?php

namespace App\Http\Controllers;

use App\Models\DeviceListing;
use Illuminate\Http\Request;

class DeviceListingController extends Controller
{
    // عرض كل العروض
    public function index()
    {
        $listings = DeviceListing::with(['device', 'warrantyCompany'])->get();
        return response()->json($listings);
    }

    // إنشاء عرض جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|exists:device_variants,id',
            'seller_company' => 'nullable|string|max:100',
            'price' => 'required|numeric',
            'currency' => 'nullable|string|max:10',
            'cost' => 'nullable|numeric',
            'status' => 'required|in:new,used',
            'warranty' => 'boolean',
            'warranty_company_id' => 'nullable|exists:providers,id',
            'stock' => 'integer|min:0',
        ]);

        $listing = DeviceListing::create($validated);
        return response()->json($listing, 201);
    }

    // عرض عرض واحد بالتفصيل
    public function show($id)
    {
        $listing = DeviceListing::with(['device', 'warrantyCompany'])->findOrFail($id);
        return response()->json($listing);
    }

    // تحديث عرض موجود
    public function update(Request $request, $id)
    {
        $listing = DeviceListing::findOrFail($id);

        $validated = $request->validate([
            'device_id' => 'sometimes|exists:device_variants,id',
            'seller_company' => 'nullable|string|max:100',
            'price' => 'sometimes|numeric',
            'currency' => 'nullable|string|max:10',
            'cost' => 'nullable|numeric',
            'status' => 'sometimes|in:new,used',
            'warranty' => 'boolean',
            'warranty_company_id' => 'nullable|exists:providers,id',
            'stock' => 'integer|min:0',
        ]);

        $listing->update($validated);
        return response()->json($listing);
    }

    // حذف عرض
    public function destroy($id)
    {
        $listing = DeviceListing::findOrFail($id);
        $listing->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
