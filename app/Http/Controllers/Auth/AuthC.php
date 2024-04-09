<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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
                return redirect()->route('direktur.dashboard');
            } elseif ($user->level == 'Human Resource') {
                return redirect()->route('hr.dashboard');
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

    public function forget_password(){
        return view('auth.forget-password');
    }

    public function forget_password_send(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email'
            ],
            [
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Email harus berupa @'
            ]
        );
        $status = Password::sendResetLink(
            $request->only('email'),
        );
        return $status === Password::RESET_LINK_SENT ?
            back()->with('success', 'Reset password berhasil terkirim ke email') :
            back()->with('error', 'Email kamu tidak valid');
    }

    function reset($token)
    {
        return view('auth.reset-password', ['token'=>$token]);
    }

    public function reset_password(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ],[
            'token.required'=>'Token wajib diisi',
            'email.reqiuired'=>'Email wajib diisi',
            'password.required'=>'Password wajib diisi',
            'password.min'=>'Password minimal 8 character',
            'password.confirmed'=>'Password harus sama'
        ]);

        $status = Password::reset(
            $request->only('email','password', 'password_confirmation','token'),
            function(User $user, string $password){
                $user->forceFill([
                    'password'=> Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
                event(new PasswordReset($user));
            }
        );
        return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('success', 'Reset password berhasil')
        : back()->with('error', 'Terjadi kesalahan!');
    }
}
