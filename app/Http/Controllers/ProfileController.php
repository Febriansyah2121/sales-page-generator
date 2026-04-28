<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update($request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]));
        return redirect()->route('profile.edit')->with('status', 'Profile updated!');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->user()->delete();
        return redirect('/');
    }
}