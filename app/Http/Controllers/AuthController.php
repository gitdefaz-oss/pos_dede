<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function index ()
    {
        return view('login');
    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout(Request $request)
{
    // Mengakhiri sesi pengguna
    Auth::logout();

    // Menghapus session pengguna
    $request->session()->invalidate();

    // Meregenerate token CSRF
    $request->session()->regenerateToken();

    // Redirect ke halaman login setelah logout
    return redirect()->route('login')->with('success', 'Anda telah keluar aplikasi!');
}
}
