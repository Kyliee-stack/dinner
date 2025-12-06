<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan form login (dipanggil oleh route: admin.login.form).
     */
    public function create()
    {
        // Untuk saat ini, kita akan mengembalikan tampilan sederhana.
        // Anda perlu membuat file view ini nanti: resources/views/auth/login.blade.php
        return view('auth.login'); 
    }

    /**
     * Handle proses login (dipanggil oleh route: admin.login).
     */
    public function store(Request $request)
    {
        // Validasi input data login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba proses login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek apakah pengguna memiliki role admin (middleware is.admin akan menangani otorisasi,
            // tapi kita tambahkan pengamanan di sini jika perlu)

            // Redirect pengguna ke dashboard admin setelah sukses login
            return redirect()->intended(route('admin.dashboard'));
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Kombinasi Email dan Password tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Logout pengguna.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirect ke halaman utama atau halaman login
        return redirect('/');
    }
}