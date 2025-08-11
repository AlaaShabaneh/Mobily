<?php

namespace App\Http\Controllers;

use App\Models\StockEntry;
use Illuminate\Http\Request;

class StockEntryController extends Controller
{
    public function index()
    {
        $entries = StockEntry::with([
            'device',
            'warrantyCompany',
            'supplier',
            'serials' // إضافة السيريالات
        ])->get();

        return response()->json($entries);
    }

    public function show($id)
    {
        $entry = StockEntry::with([
            'device',
            'warrantyCompany',
            'supplier',
            'serials' // إضافة السيريالات
        ])->findOrFail($id);

        return response()->json($entry);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|integer|exists:devices,id',
            'warranty_company_id' => 'nullable|integer|exists:warranty_companies,id',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'purchase_price' => 'nullable|numeric',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'serial_numbers' => 'required|array|min:1',
            'serial_numbers.*' => 'string|max:100|distinct'
        ]);

        // تخزين الدفعة
        $stockEntry = StockEntry::create($validated);

        // إدخال السيريالات
        foreach ($validated['serial_numbers'] as $serial) {
            $stockEntry->serials()->create([
                'serial_number' => $serial
            ]);
        }

        return response()->json($stockEntry->load('serials'), 201);
    }

    public function update(Request $request, $id)
    {
        $entry = StockEntry::findOrFail($id);

        $validated = $request->validate([
            'device_id' => 'sometimes|required|integer|exists:devices,id',
            'warranty_company_id' => 'nullable|integer|exists:warranty_companies,id',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'quantity' => 'sometimes|required|integer|min:1',
            'purchase_price' => 'nullable|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $entry->update($validated);
        return response()->json($entry);
    }

    public function destroy($id)
    {
        $entry = StockEntry::findOrFail($id);
        $entry->delete();
        return response()->json(null, 204);
    }
}
