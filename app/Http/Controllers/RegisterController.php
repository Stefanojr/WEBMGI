<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Unit;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;  // Menambahkan import Validator


class RegisterController extends Controller
{
    public function create()
    {
        $perusahaan = Perusahaan::all();
        $units = Unit::all();
        return view('register', compact('perusahaan', 'units'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_user' => 'required|string|max:255',
                'perner' => 'required|string|max:50|unique:tb_user,perner',
                'password' => 'required|string|min:6',
                'email_user' => 'required|email|max:255|unique:tb_user,email_user',
                'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
                'id_unit' => 'required|exists:unit,id_unit',
            ]);

            $user = new User();
            $user->nama_user = $request->nama_user;
            $user->perner = $request->perner;
            $user->password = Hash::make($request->password);
            $user->email_user = $request->email_user;
            $user->id_unit = $request->id_unit;
            $user->role_user = 'user';
            $user->aktif = 1;
            $user->save();

            return redirect()->route('register.create')->with('success', 'Registrasi berhasil! Anda akan dialihkan ke halaman login.');

        } catch (\Exception $e) {
            return redirect()->route('register.create')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getUnitsByPerusahaan($id_perusahaan)
    {
        $units = Unit::where('id_perusahaan', $id_perusahaan)->get();
        return response()->json($units);
    }


}
