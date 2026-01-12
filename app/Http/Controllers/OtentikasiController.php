<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtentikasiController extends Controller
{
    public function tampilHalamanLogin()
    {
        return view('auth.login');
    }

    public function prosesLogin(Request $permintaan)
    {
        $kredensial = $permintaan->validate([
            'username' => ['required'],
            'password' => ['required'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Auth::attempt akan mencari user berdasarkan 'username',
        // lalu memverifikasi 'password' input dengan hash di kolom 'password_hash' (sesuai getAuthPassword di Model)
        if (Auth::attempt(['username' => $kredensial['username'], 'password' => $kredensial['password']])) {
            $permintaan->session()->regenerate();

            // Update waktu login terakhir
            /** @var \App\Models\User $pengguna */
            $pengguna = Auth::user();
            $pengguna->last_login = now();
            $pengguna->save();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'Kombinasi username dan password tidak cocok.',
        ])->onlyInput('username');
    }

    public function prosesLogout(Request $permintaan)
    {
        Auth::logout();
        $permintaan->session()->invalidate();
        $permintaan->session()->regenerateToken();
        return redirect('/login');
    }
}
