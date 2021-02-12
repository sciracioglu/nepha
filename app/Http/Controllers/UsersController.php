<?php

namespace App\Http\Controllers;

use App\Models\User;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('users');
    }

    public function list()
    {
        return User::orderBy('name')->get();
    }

    public function update(User $user)
    {

        $change = User::find($user->id);
        (int) $user->role === 2
            ? $change->update(['role' => 1])
            : $change->update(['role' => 2]);
    }

    public function store()
    {
        $data = request()->validate([
            'email' => 'required',
            'name' => 'required',
            'role' => 'required',
        ]);

        User::create($data);
    }

    public function destroy($id)
    {
        User::find($id)
            ->delete();
    }
}
