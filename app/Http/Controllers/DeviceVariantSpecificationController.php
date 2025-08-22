<?php

namespace App\Http\Controllers;

use App\Models\DeviceVariantSpecification;
use Illuminate\Http\Request;

class DeviceVariantSpecificationController extends Controller
{
    // عرض جميع المواصفات المرتبطة بالمتغيرات
    public function index(Request $request)
    {
        $query = DeviceVariantSpecification::with('specification'); ;

        // إذا فيه variant_id في الـ query string، نفلتر عليه
        if ($request->has('variant_id')) {
            $query->where('variant_id', $request->variant_id);
        }

        return response()->json($query->get());
    }


    // إنشاء قيمة مواصفة جديدة لمتغير جهاز
    public function store(Request $request)
    {
        $validated = $request->validate([
            'variant_id' => 'required|integer|exists:device_variants,id',
            'specification_id' => 'required|integer|exists:specifications,id',
            'value' => 'nullable|string|max:255',
        ]);

        $specification = DeviceVariantSpecification::create($validated);

        return response()->json($specification, 201);
    }

    // عرض مواصفة معينة
    public function show($id)
    {
        $specification = DeviceVariantSpecification::findOrFail($id);
        return response()->json($specification);
    }

    // تحديث مواصفة
    public function update(Request $request, $id)
    {
        $specification = DeviceVariantSpecification::findOrFail($id);

        $validated = $request->validate([
            'variant_id' => 'sometimes|integer|exists:device_variants,id',
            'specification_id' => 'sometimes|integer|exists:specifications,id',
            'value' => 'nullable|string|max:255',
        ]);

        $specification->update($validated);

        return response()->json($specification);
    }

    // حذف مواصفة
    public function destroy($id)
    {
        $specification = DeviceVariantSpecification::findOrFail($id);
        $specification->delete();

        return response()->json(null, 204);
    }
}
