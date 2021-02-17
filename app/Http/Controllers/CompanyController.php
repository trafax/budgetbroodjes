<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $companies = Company::orderBy('title', 'ASC');
        if ($request->get('search')) {
            $companies->where('title', 'LIKE', '%'. $request->get('search') .'%');
        }

        return view('companies.index')->with('companies', $companies->get());
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'domain' => 'unique:companies,domain'
        ]);

        $company = new Company();
        $company->fill($request->all());
        $company->save();

        return redirect()->route('company.index')->with('alert', ['type' => 'success', 'message' => 'Bedrijf succesvol toegevoegd.']);
    }

    public function edit(Company $company)
    {
        return view('companies.edit')->with('company', $company);
    }

    public function update(Company $company, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'domain' => 'unique:companies,domain,'.$company->id.',id'
        ]);

        $company->fill($request->all());
        $company->save();

        return redirect()->route('company.index')->with('alert', ['type' => 'success', 'message' => 'Bedrijf succesvol aangepast.']);
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('company.index')->with('alert', ['type' => 'success', 'message' => 'Bedrijf succesvol verwijderd.']);
    }
}
