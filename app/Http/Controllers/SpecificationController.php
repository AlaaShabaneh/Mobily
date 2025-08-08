<?php

namespace App\Http\Controllers;

use App\Models\Specification;
use Illuminate\Http\Request;

class SpecificationController extends Controller
{
    public function index()
    {
        $specifications = Specification::all();
        return response()->json($specifications);
    }

    public function show($id)
    {
        $specification = Specification::findOrFail($id);
        return response()->json($specification);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $specification = Specification::create($validated);
        return response()->json($specification, 201);
    }

    public function update(Request $request, $id)
    {
        $specification = Specification::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
        ]);

        $specification->update($validated);
        return response()->json($specification);
    }

    public function destroy($id)
    {
        $specification = Specification::findOrFail($id);
        $specification->delete();
        return response()->json(null, 204);
    }
}
