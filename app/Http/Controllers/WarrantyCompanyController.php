<?php

namespace App\Http\Controllers;

use App\Models\WarrantyCompany;
use Illuminate\Http\Request;

class WarrantyCompanyController extends Controller
{
    public function index()
    {
        return WarrantyCompany::all();
    }

    public function show($id)
    {
        return WarrantyCompany::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'contact_info' => 'nullable|string',
        ]);

        $company = WarrantyCompany::create($validated);
        return response()->json($company, 201);
    }

    public function update(Request $request, $id)
    {
        $company = WarrantyCompany::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'contact_info' => 'nullable|string',
        ]);

        $company->update($validated);
        return response()->json($company);
    }

    public function destroy($id)
    {
        WarrantyCompany::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
