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

        /**
         * Openingstijden opslaan
         */
        $company->openingtimes()->detach();
        foreach ($request->get('openingtimes')['day'] as $key => $value) {

            if (empty($value)) {
                continue;
            }

            $day = $request->get('openingtimes')['day'][$key] ?? NULL;
            $time_open = $request->get('openingtimes')['time_open'][$key] ?? NULL;
            $time_close = $request->get('openingtimes')['time_close'][$key] ?? NULL;


            $company->openingtimes()->attach($company->id, ['day' => $day, 'time_open' => $time_open, 'time_close' => $time_close]);
        }

        return redirect()->route('company.index')->with('alert', ['type' => 'success', 'message' => 'Bedrijf succesvol aangepast.']);
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('company.index')->with('alert', ['type' => 'success', 'message' => 'Bedrijf succesvol verwijderd.']);
    }
}
