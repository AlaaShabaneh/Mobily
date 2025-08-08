<?php

namespace App\Http\Controllers;

use App\Models\WarrantyRating;
use Illuminate\Http\Request;

class WarrantyRatingController extends Controller
{
    public function index()
    {
        return WarrantyRating::all();
    }

    public function show($id)
    {
        return WarrantyRating::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|integer|exists:users,id',
            'warranty_claim_id' => 'nullable|integer|exists:warranty_claims,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        $warrantyRating = WarrantyRating::create($validated);
        return response()->json($warrantyRating, 201);
    }

    public function update(Request $request, $id)
    {
        $warrantyRating = WarrantyRating::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'nullable|integer|exists:users,id',
            'warranty_claim_id' => 'nullable|integer|exists:warranty_claims,id',
            'rating' => 'sometimes|required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        $warrantyRating->update($validated);
        return response()->json($warrantyRating);
    }

    public function destroy($id)
    {
        WarrantyRating::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
