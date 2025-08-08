<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return Brand::all();
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);
        return Brand::create($request->all());
    }

    public function show($id)
    {
        return Brand::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $request->validate(['name' => 'required|string|max:100']);
        $brand->update($request->all());
        return $brand;
    }

    public function destroy($id)
    {
        Brand::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
