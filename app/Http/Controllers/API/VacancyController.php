<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\VacancyResource;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VacancyController extends BaseController
{
    public function index()
    {
        $vacancies = Vacancy::with('company')->get();
        return $this->sendResponse(VacancyResource::collection($vacancies), 'Vacancies retrieved successfully');
    }

    public function show($id)
    {
        $vacancy = Vacancy::with('company')->findOrFail($id);
        if (is_null($vacancy)) {
            return $this->sendError('Vacancy not found.');
        }

        return $this->sendResponse(new VacancyResource($vacancy), 'Vacancy retrieved successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);
        
        if($validator->fails())
        {
            if($validator->fails())
            {
                $this->sendError('Validation Error.', $validator->errors());
            }
        }

        $vacancy = Vacancy::create($request->all());
        return $this->sendResponse(new VacancyResource($vacancy), 'Vacancy created successfully');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);
        
        if($validator->fails())
        {
            if($validator->fails())
            {
                $this->sendError('Validation Error.', $validator->errors());
            }
        }

        $vacancy = Vacancy::findOrFail($id);
        $vacancy->update($request->all());

        return $this->sendResponse(new VacancyResource($vacancy), 'Vacancy updated seccessfully');
    }

    public function destroy($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        $vacancy->delete();

        return $this->sendResponse([], 'Vacancy deleted successfully');
    }
}
