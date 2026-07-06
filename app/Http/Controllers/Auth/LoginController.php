<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'kata_sandi' => 'required',
        ]);

        // Laravel expects 'password' but our DB uses 'kata_sandi'
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['kata_sandi']], $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // If in maintenance mode, bypass it for this admin session
            if (app()->isDownForMaintenance()) {
                $cookie = cookie('laravel_maintenance', 'admin-bypass', 120);
                return redirect()->intended('/admin')->withCookie($cookie);
            }
            
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
