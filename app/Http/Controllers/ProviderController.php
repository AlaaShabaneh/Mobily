<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index()
    {
        $providers = Provider::all();
        return response()->json($providers);
    }

    public function show($id)
    {
        $provider = Provider::findOrFail($id);
        return response()->json($provider);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'contact_info' => 'nullable|string',
        ]);

        $provider = Provider::create($validated);
        return response()->json($provider, 201);
    }

    public function update(Request $request, $id)
    {
        $provider = Provider::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'contact_info' => 'nullable|string',
        ]);

        $provider->update($validated);
        return response()->json($provider);
    }

    public function destroy($id)
    {
        $provider = Provider::findOrFail($id);
        $provider->delete();
        return response()->json(null, 204);
    }
}
