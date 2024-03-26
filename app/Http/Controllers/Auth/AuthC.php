<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthC extends Controller
{
    public function index()
    {
        return view("auth.login");
    }
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required|min:8"
        ], [
            "email.required" => "Email harus diisi",
            "email.email" => "Harus menggunakan email yang valid",
            "password.required" => "Password harus diisi",
            "password.min" => "Password harus minimal 8 karakter",
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            if ($user->level == 'Karyawan') {
                return redirect()->route('employee.dashboard');
            } elseif ($user->level == 'Direktur') {
                return redirect('/homedirektur');
            } elseif ($user->level == 'Human Resource') {
                return redirect('/homehuman');
            } else {
                Auth::logout();
                alert()->error('Akun Anda tidak memiliki akses yang sesuai.');
                return redirect()->back();
            }
        } else {
            alert()->error('Email atau password tidak valid.');
            return redirect()->back();
        }
    }

    public function logout(){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
