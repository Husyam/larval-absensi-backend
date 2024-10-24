<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CompanyController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view company', only: ['index']),
            new Middleware('permission:edit company', only: ['edit']),
            new Middleware('permission:create company', only: ['create']),
            new Middleware('permission:delete company', only: ['destroy']),
        ];
    }

    public function show() {
        $company = Company::find(1);
        return view('pages.company.show', compact('company'));
    }

    public function edit($id) {
        $company = Company::find($id);
        return view('pages.company.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius_km' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);

        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius_km' => $request->radius_km,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
        ]);

        return redirect()->route('companies.show', 1)->with('success', 'Company updated successfully');
    }
}
