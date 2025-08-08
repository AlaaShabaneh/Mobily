<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::all();
        return response()->json($types);
    }

    public function show($id)
    {
        $type = Type::findOrFail($id);
        return response()->json($type);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $type = Type::create($validated);
        return response()->json($type, 201);
    }

    public function update(Request $request, $id)
    {
        $type = Type::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $type->update($validated);
        return response()->json($type);
    }

    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();
        return response()->json(null, 204);
    }
}
