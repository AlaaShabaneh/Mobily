<?php
namespace App\Http\Controllers;

use App\Models\DeviceRating;
use Illuminate\Http\Request;

class DeviceRatingController extends Controller
{
    public function index()
    {
        return DeviceRating::with(['user', 'device'])->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'device_id' => 'required|exists:devices,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        return DeviceRating::create($data);
    }

    public function show(DeviceRating $deviceRating)
    {
        return $deviceRating->load(['user', 'device']);
    }

    public function update(Request $request, DeviceRating $deviceRating)
    {
        $data = $request->validate([
            'rating' => 'integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $deviceRating->update($data);
        return $deviceRating;
    }

    public function destroy(DeviceRating $deviceRating)
    {
        $deviceRating->delete();
        return response()->noContent();
    }
}
