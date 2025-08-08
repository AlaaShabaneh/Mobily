<?php

namespace App\Http\Controllers;

use App\Models\DeviceModel;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function index()
    {
        // إرجاع كل النماذج مع العلامة التجارية المرتبطة
        $models = DeviceModel::with('brand')->get();
        return response()->json($models);
    }

    public function show($id)
    {
        $model = DeviceModel::with('brand')->findOrFail($id);
        return response()->json($model);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:100',
        ]);

        $model = DeviceModel::create($validated);
        return response()->json($model, 201);
    }

    public function update(Request $request, $id)
    {
        $model = DeviceModel::findOrFail($id);

        $validated = $request->validate([
            'brand_id' => 'sometimes|exists:brands,id',
            'name' => 'sometimes|string|max:100',
        ]);

        $model->update($validated);

        return response()->json($model);
    }

    public function destroy($id)
    {
        $model = DeviceModel::findOrFail($id);
        $model->delete();

        return response()->json(null, 204);
    }
}
