<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function index()
    {
        return Credit::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric',
            'source_order_id' => 'nullable|integer|exists:orders,id',
        ]);

        $credit = Credit::create($validated);
        return response()->json($credit, 201);
    }

    public function show($id)
    {
        return Credit::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $credit = Credit::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric',
            'source_order_id' => 'nullable|integer|exists:orders,id',
        ]);

        $credit->update($validated);
        return response()->json($credit);
    }

    public function destroy($id)
    {
        $credit = Credit::findOrFail($id);
        $credit->delete();

        return response()->json(null, 204);
    }
}
