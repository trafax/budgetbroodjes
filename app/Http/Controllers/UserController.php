<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $users = User::where('role', 'user')->orderBy('name', 'ASC');
        if ($request->get('search')) {
            $users->where('name', 'LIKE', '%'. $request->get('search') .'%');
        }

        return view('users.index')->with('users', $users->get());
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $user = new User();
        $request->request->set('password', Hash::make($request->get('password')));
        $user->fill($request->all());
        $user->save();

        return redirect()->route('user.index')->with('alert', ['type' => 'success', 'message' => 'Gebruiker succesvol toegevoegd.']);
    }

    public function edit(User $user)
    {
        return view('users.edit')->with('user', $user);
    }

    public function update(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $user->fill($request->all());
        $user->save();

        return redirect()->route('users.index')->with('alert', ['type' => 'success', 'message' => 'Gebruiker succesvol aangepast.']);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('alert', ['type' => 'success', 'message' => 'Gebruiker succesvol verwijderd.']);
    }
}
