<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Unit;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'perner' => 'required',
            'password' => 'required'
        ]);

        // Cek apakah perner ada di database
        $user = User::where('perner', $request->input('perner'))->first();

        // Jika perner tidak ditemukan
        if (!$user) {
            return back()->with('error', 'PERNER tidak terdaftar');
        }

        // Cek password
        if (!Hash::check($request->input('password'), $user->password)) {
            return back()->with('error', 'Password salah');
        }

        // Cek status aktif
        if (!$user->aktif) {
            return back()->with('error', 'Akun perlu aktivasi');
        }

        // Login pengguna
        Auth::login($user);

        // Simpan perner ke session
        session(['perner' => Auth::user()->perner]);

        // Flash message untuk login berhasil
        session()->flash('success', 'Anda berhasil login!');

        // Redirect berdasarkan role_user
        switch ($user->role_user) {
            case 'superadmin':
                return redirect()->route('superadmin.home');
            case 'user':
                return redirect()->route('unit.home2');
            case 'komite':
                return redirect()->route('superadmin.home');
            default:
                return back()->with('error', 'Role tidak ditemukan');
        }
    }

    public function logout()
    {
        Auth::logout();

        // Flash success message saat logout
        session()->flash('success', 'Anda berhasil logout!');

        return redirect()->route('login');
    }
}
