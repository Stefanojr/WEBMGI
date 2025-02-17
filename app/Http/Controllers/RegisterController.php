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
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'perner' => 'required|string|max:50|unique:tb_user,perner',
            'password' => 'required|string|min:6',
            'email_user' => 'required|email|max:255|unique:tb_user,email_user',
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
            'id_unit' => 'required|exists:unit,id_unit',
        ]);

        User::create([
            'nama_user' => $request->nama_user,
            'perner' => $request->perner,
            'password' => Hash::make($request->password),
            'email_user' => $request->email_user,
            'id_unit' => $request->id_unit,
            'role_user' => 'user', // Default role
            'aktif' => 1, // Default active
        ]);

        // Redirect langsung ke halaman login tanpa menggunakan route
    return redirect('/')->with('success', 'Registrasi berhasil!');
    }

    public function getUnitsByPerusahaan($id_perusahaan)
    {
        $units = Unit::where('id_perusahaan', $id_perusahaan)->get();
        return response()->json($units);
    }


}
