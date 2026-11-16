<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $dataLogin = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi.',
            'password.required' => 'Kata sandi harus diisi.',
        ]);

        // hanya email manajer (@manajer.koperasi) dan admin (@admin.koperasi) yang boleh masuk
        if (User::peranDariEmail($dataLogin['email']) == null) {
            return back()
                ->withErrors(['email' => 'Hanya akun Manajer dan Admin yang dapat masuk.'])
                ->withInput($request->only('email'));
        }

        if (!Auth::attempt($dataLogin, $request->has('ingat'))) {
            return back()
                ->withErrors(['email' => 'Email atau kata sandi salah.'])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}