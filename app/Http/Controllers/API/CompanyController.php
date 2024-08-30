<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends BaseController
{
    public function index()
    {
        $companies = Company::with('vacancies')->get();
        return response()->json([
            'status' => true,
            'message' => 'Companies retrieved successfully',
            'data' => $companies
        ], 200);
    }

    public function show($id)
    {
        $company = Company::with('vacancies')->findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Company retrieved successfully',
            'data' => $company
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $company = Company::create($request->all());
        
        return response()->json([
            'status' => true,
            'message' => 'Company created successfully',
            'data' => $company
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $company = Company::findOrFail($id);
        $company->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Company updated successfully',
            'data' => $company
        ], 201);
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json([
            'status' => true,
            'message' => 'Company deleted successfully'
        ], 204);
    }
}
