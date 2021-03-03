<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('company_id', config()->get('company_id'))->where('role', 'user')->orderBy('name', 'ASC');
        if ($request->get('search')) {
            $users->where('name', 'LIKE', '%'. $request->get('search') .'%');
        }

        return view('employees.index')->with('users', $users->get());
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $user = new User();
        $request->request->set('password', Hash::make($request->get('password')));
        $request->request->set('company_id', config()->get('company_id'));
        $user->fill($request->all());
        $user->save();

        return redirect()->route('employee.index')->with('alert', ['type' => 'success', 'message' => 'Medewerker succesvol toegevoegd.']);
    }

    public function edit(User $employee)
    {
        return view('employees.edit')->with('user', $employee);
    }

    public function update(User $employee, Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $employee->fill($request->all());
        $employee->save();

        return redirect()->route('employee.index')->with('alert', ['type' => 'success', 'message' => 'Medewerker succesvol aangepast.']);
    }

    public function destroy(User $employee)
    {
        $employee->delete();

        return redirect()->route('employee.index')->with('alert', ['type' => 'success', 'message' => 'Medewerker succesvol verwijderd.']);
    }
}
