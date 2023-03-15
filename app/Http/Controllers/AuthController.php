<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index()
    {
        return Inertia::render('auth/login');
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect(route('dashboard'));
        } else {
            return redirect(route('login'))->withErrors(['login' => "Invalid username atau password"]);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
