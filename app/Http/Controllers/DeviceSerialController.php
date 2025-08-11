<?php

namespace App\Http\Controllers;

use App\Models\DeviceSerial;
use Illuminate\Http\Request;

class DeviceSerialController extends Controller
{
    public function index()
    {
        return response()->json(DeviceSerial::all());
    }

    public function show($id)
    {
        return response()->json(DeviceSerial::findOrFail($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'stock_entry_id' => 'required|exists:stock_entries,id',
            'serial_number' => 'required|string|unique:device_serials,serial_number',
        ]);

        $serial = DeviceSerial::create($validated);

        return response()->json($serial, 201);
    }

    public function update(Request $request, $id)
    {
        $serial = DeviceSerial::findOrFail($id);

        $validated = $request->validate([
            'serial_number' => 'required|string|unique:device_serials,serial_number,' . $id,
        ]);

        $serial->update($validated);

        return response()->json($serial);
    }

    public function destroy($id)
    {
        $serial = DeviceSerial::findOrFail($id);
        $serial->delete();

        return response()->json(null, 204);
    }

    public function search(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string'
        ]);

        $serial = DeviceSerial::where('serial_number', $request->serial_number)->first();

        if (!$serial) {
            return response()->json(['message' => 'Serial not found'], 404);
        }

        return response()->json($serial);
    }
}
