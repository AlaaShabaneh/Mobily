<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function index()
    {
        $statuses = OrderStatus::all();
        return response()->json($statuses);
    }

    public function show($id)
    {
        $status = OrderStatus::findOrFail($id);
        return response()->json($status);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $status = OrderStatus::create($validated);
        return response()->json($status, 201);
    }

    public function update(Request $request, $id)
    {
        $status = OrderStatus::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $status->update($validated);
        return response()->json($status);
    }

    public function destroy($id)
    {
        $status = OrderStatus::findOrFail($id);
        $status->delete();

        return response()->json(null, 204);
    }
}
