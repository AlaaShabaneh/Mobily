<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with(['user', 'status'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'status_id' => 'nullable|exists:order_statuses,id',
            'total_amount' => 'nullable|numeric',
        ]);

        $order = Order::create($validated);

        return response()->json($order, 201);
    }

    public function show($id)
    {
        return Order::with(['user', 'status'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'status_id' => 'nullable|exists:order_statuses,id',
            'total_amount' => 'nullable|numeric',
        ]);

        $order->update($validated);

        return response()->json($order);
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}
