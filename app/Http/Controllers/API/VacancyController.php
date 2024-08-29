<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VacancyController extends BaseController
{
    public function index()
    {
        $vacancies = Vacancy::with('company')->get();
        return response()->json([
            'status' => true,
            'message' => 'Jobs retrieved successfully',
            'data' => $vacancies
        ], 200);
    }

    public function show($id)
    {
        $vacancy = Vacancy::with('company')->findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Job retrieved successfully',
            'data' => $vacancy
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);
        
        if($validator->fails())
        {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $vacancy = Vacancy::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Job created successfully',
            'data' => $vacancy
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);
        
        if($validator->fails())
        {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $vacancy = Vacancy::findOrFail($id);
        $vacancy->update($request->all());
    }

    public function destroy($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        $vacancy->delete();

        return response()->json([
            'status' => true,
            'message' => 'Job deleted successfully'
        ], 204);
    }
}
