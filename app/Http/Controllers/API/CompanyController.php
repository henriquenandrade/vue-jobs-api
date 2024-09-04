<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends BaseController
{
    public function index()
    {
        $companies = Company::paginate(10);
        return $this->sendResponse(CompanyResource::collection($companies)
            ->response()
            ->getData(true),
            'Companies retrieved successfully');
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        
        if (is_null($company)) {
            return $this->sendError('Company not found.');
        }

        return $this->sendResponse(new CompanyResource($company), 'Company retrieved successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|unique:companies|string|max:255',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $company = Company::create($request->all());
        
        return $this->sendResponse(new CompanyResource($company), 'Company created successfully');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|unique:companies|string|max:255',
        ]);

        if($validator->fails())
        {
            $this->sendError('Validation Error.', $validator->errors());
        }

        $company = Company::findOrFail($id);
        $company->update($request->all());

        return $this->sendResponse(new CompanyResource($company), 'Company updated seccessfully');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return $this->sendResponse([], 'Company deleted successfully');
    }
}
