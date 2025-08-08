<?php

namespace App\Http\Controllers;

use App\Models\WarrantyDetail;
use Illuminate\Http\Request;

class WarrantyDetailController extends Controller
{
    public function index()
    {
        return WarrantyDetail::all();
    }

    public function show($id)
    {
        return WarrantyDetail::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_listing_id' => 'nullable|integer|exists:device_listings,id',
            'duration_months' => 'required|integer|min:0',
            'coverage' => 'nullable|string',
            'terms' => 'nullable|string',
        ]);

        $warrantyDetail = WarrantyDetail::create($validated);
        return response()->json($warrantyDetail, 201);
    }

    public function update(Request $request, $id)
    {
        $warrantyDetail = WarrantyDetail::findOrFail($id);

        $validated = $request->validate([
            'device_listing_id' => 'nullable|integer|exists:device_listings,id',
            'duration_months' => 'sometimes|required|integer|min:0',
            'coverage' => 'nullable|string',
            'terms' => 'nullable|string',
        ]);

        $warrantyDetail->update($validated);
        return response()->json($warrantyDetail);
    }

    public function destroy($id)
    {
        WarrantyDetail::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
