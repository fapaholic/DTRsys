<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthManager extends Controller
{
    function login() {
        return view('login');
    }

    function registration() {
        return view('registration');
    }

    function loginPost(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email','password');

        // First attempt to log in as User (admin)
        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->intended(route('dashboard')); // Admin dashboard
        }

        // If not a user, attempt to log in as Employee
        if (Auth::guard('employee')->attempt($credentials)) {
            return redirect()->intended(route('/e-dashboard')); // Employee dashboard
        }

        return redirect(route('login'))->with("error", "Username or Password is Incorrect!");
    }

    function registrationPost(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        if (!$user) {
            return redirect(route('registration'))->with("error", "Registration Failed");
        }

        return redirect(route('login'))->with("success", "Registered Successfully!");
    }

    function logout() {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        } elseif (Auth::guard('employee')->check()) {
            Auth::guard('employee')->logout();
        }

        Session::flush();
        return redirect(route('login'));
    }
}
