<?php
namespace App\Http\Controllers;

use App\Models\DeviceSpecificationValue;
use Illuminate\Http\Request;

class DeviceSpecificationValueController extends Controller
{
    public function index()
    {
        return DeviceSpecificationValue::with(['device', 'specification'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'specification_id' => 'required|exists:specifications,id',
            'value' => 'nullable|string|max:255',
        ]);

        return DeviceSpecificationValue::create($data);
    }

    public function show(DeviceSpecificationValue $deviceSpecificationValue)
    {
        return $deviceSpecificationValue->load(['device', 'specification']);
    }

    public function update(Request $request, DeviceSpecificationValue $deviceSpecificationValue)
    {
        $data = $request->validate([
            'value' => 'nullable|string|max:255',
        ]);

        $deviceSpecificationValue->update($data);

        return $deviceSpecificationValue;
    }

    public function destroy(DeviceSpecificationValue $deviceSpecificationValue)
    {
        $deviceSpecificationValue->delete();
        return response()->noContent();
    }
}
