<?php

namespace App\Http\Controllers;

use App\Models\WarrantyClaim;
use Illuminate\Http\Request;

class WarrantyClaimController extends Controller
{
    public function index()
    {
        $claims = WarrantyClaim::with(['user', 'deviceListing', 'order'])->get();
        return response()->json($claims);
    }

    public function show($id)
    {
        $claim = WarrantyClaim::with(['user', 'deviceListing', 'order'])->findOrFail($id);
        return response()->json($claim);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'device_listing_id' => 'nullable|integer|exists:device_listings,id',
            'order_id' => 'nullable|integer|exists:orders,id',
            'issue_description' => 'required|string',
            'claim_date' => 'nullable|date',
            'status' => 'nullable|in:pending,approved,rejected,in_progress,resolved',
            'resolution_notes' => 'nullable|string',
        ]);

        $claim = WarrantyClaim::create($validated);
        return response()->json($claim, 201);
    }

    public function update(Request $request, $id)
    {
        $claim = WarrantyClaim::findOrFail($id);

        $validated = $request->validate([
            'issue_description' => 'sometimes|required|string',
            'claim_date' => 'sometimes|date',
            'status' => 'sometimes|in:pending,approved,rejected,in_progress,resolved',
            'resolution_notes' => 'nullable|string',
        ]);

        $claim->update($validated);
        return response()->json($claim);
    }

    public function destroy($id)
    {
        $claim = WarrantyClaim::findOrFail($id);
        $claim->delete();
        return response()->json(null, 204);
    }
}
