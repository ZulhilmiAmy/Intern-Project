<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            $request->session()->regenerate();

            $user = Auth::user();
            $role = strtolower(trim($user->role));

            if ($role === 'admin') {
                return redirect()->route('admin.home');
            }

            if ($role === 'ict') {
                return redirect()->route('ict.dashboard');
            }

            Auth::logout();
            return back()->with('error', 'Role tidak sah');
        }

        return back()->with('error', 'Email atau kata laluan tidak sah');
    }
}